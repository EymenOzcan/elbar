<?php

  namespace App\Http\Controllers\Api;

  use App\Http\Controllers\Controller;
  use App\Models\SecretWallEntry;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Validator;
  use Illuminate\Support\Facades\Cache;

  class SecretWallController extends Controller
  {
      /**
       * Onaylanmış kayıtlı kişileri getir (Frontend için)
       *
       * @return \Illuminate\Http\JsonResponse
       */
      public function index(Request $request)
      {
          try {
              // Sadece onaylanmış ve aktif kayıtları getir
              $query = SecretWallEntry::active()->recent();

              // Sayfalama parametreleri
              $perPage = $request->input('per_page', 12);
              $perPage = min(max($perPage, 1), 100); // 1-100 arası sınırla

              // Arama varsa
              if ($request->has('search') && !empty($request->search)) {
                  $query->where('isimsoyisim', 'like', '%' .
  $request->search . '%');
              }

              $entries = $query->paginate($perPage);

              // Verileri API formatına dönüştür
              $data = $entries->map(function ($entry) {
                  return [
                      'id' => $entry->id,
                      'isimsoyisim' => $entry->isimsoyisim,
                      'resim_url' => $entry->getImageData(),
                      'initials' => $entry->getInitials(),
                      'avatar_color' => $entry->getAvatarColor(),
                      'social_links' => [
                          'facebook' => $entry->facebook_link,
                          'instagram' => $entry->instagram_link,
                          'linkedin' => $entry->linkedin_link,
                          'tiktok' => $entry->tiktok_link,
                          'whatsapp' => $entry->whatsapp_link,
                          'x' => $entry->x_link,
                          'youtube' => $entry->youtube_link,
                      ],
                      'created_at' => $entry->created_at->toIso8601String(),
                  ];
              });

              return response()->json([
                  'success' => true,
                  'data' => $data,
                  'pagination' => [
                      'total' => $entries->total(),
                      'per_page' => $entries->perPage(),
                      'current_page' => $entries->currentPage(),
                      'last_page' => $entries->lastPage(),
                      'from' => $entries->firstItem(),
                      'to' => $entries->lastItem(),
                  ],
              ], 200);

          } catch (\Exception $e) {
              return response()->json([
                  'success' => false,
                  'message' => 'Kayıtlar getirilirken bir hata oluştu.',
                  'error' => config('app.debug') ? $e->getMessage() : null,
              ], 500);
          }
      }

      /**
       * Yeni kullanıcı kaydı (Frontend için)
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\JsonResponse
       */
      public function store(Request $request)
      {
          try {
              // 1. HONEYPOT KONTROLÜ - Botlar için gizli alan
              if ($request->filled('website')) {
                  // Bot tespit edildi, sessizce başarılı gibi göster
                  return response()->json([
                      'success' => true,
                      'message' => 'Kaydınız başarıyla alındı!',
                  ], 201);
              }

              // 2. ZAMAN BAZLI KORUMA - Form yüklenme zamanı kontrolü
              $formLoadTime = $request->input('form_load_time');
              if ($formLoadTime && (time() - $formLoadTime) < 3) {
                  return response()->json([
                      'success' => false,
                      'message' => 'Lütfen formu daha dikkatli doldurun.',
                  ], 422);
              }

              // 3. RATE LIMITING - IP başına saatte 6 kayıt
              $ip = $request->ip();
              $rateLimitKey = 'secret_wall_rate_limit:' . $ip;
              $submissions = Cache::get($rateLimitKey, 0);

              if ($submissions >= 6) {
                  return response()->json([
                      'success' => false,
                      'message' => 'Çok fazla kayıt denemesi yaptınız.
  Lütfen 1 saat sonra tekrar deneyin.',
                  ], 429);
              }

              // 4. VALIDASYON
              $validator = Validator::make($request->all(), [
                  'isimsoyisim' => 'required|string|max:255',
                  'resim_base64' => 'nullable|string', // Base64 string
                  'facebook_link' => 'nullable|url|max:500',
                  'instagram_link' => 'nullable|string|max:500',
                  'linkedin_link' => 'nullable|url|max:500',
                  'tiktok_link' => 'nullable|url|max:500',
                  'whatsapp_link' => 'nullable|string|max:500',
                  'x_link' => 'nullable|url|max:500',
                  'youtube_link' => 'nullable|url|max:500',
              ], [
                  'isimsoyisim.required' => 'İsim soyisim alanı
  zorunludur.',
                  'isimsoyisim.max' => 'İsim soyisim en fazla 255 karakter
  olabilir.',
                  '*.url' => 'Geçerli bir URL giriniz.',
                  '*.max' => 'Bu alan çok uzun.',
              ]);

              if ($validator->fails()) {
                  return response()->json([
                      'success' => false,
                      'message' => 'Validasyon hatası.',
                      'errors' => $validator->errors(),
                  ], 422);
              }

              // 5. XSS KORUMASI - HTML tag'lerini temizle
              $cleanName = strip_tags($request->isimsoyisim);

              // 6. BASE64 RESİM KONTROLÜ ve DOĞRULAMA
              $imageBase64 = null;
              if ($request->filled('resim_base64')) {
                  $base64Image = $request->resim_base64;

                  // Data URI prefix'i kontrol et ve temizle
                  if
  (preg_match('/^data:image\/(jpeg|jpg|png|webp);base64,/', $base64Image,
  $matches)) {
                      $imageType = $matches[1];
                      $base64Image =
  preg_replace('/^data:image\/(jpeg|jpg|png|webp);base64,/', '',
  $base64Image);
                  } else {
                      // Prefix yoksa direkt base64 string olarak kabul et
                      $imageType = 'jpeg'; // default
                  }

                  // Base64 decode et ve doğrula
                  $imageContent = base64_decode($base64Image, true);

                  if ($imageContent === false) {
                      return response()->json([
                          'success' => false,
                          'message' => 'Geçersiz base64 resim formatı.',
                      ], 422);
                  }

                  // Boyut kontrolü (5MB max)
                  $imageSizeInBytes = strlen($imageContent);
                  if ($imageSizeInBytes > 5 * 1024 * 1024) {
                      return response()->json([
                          'success' => false,
                          'message' => 'Resim boyutu en fazla 5MB
  olabilir.',
                      ], 422);
                  }

                  // Dosya gerçek bir resim mi kontrol et
                  $imageInfo = @getimagesizefromstring($imageContent);
                  if ($imageInfo === false) {
                      return response()->json([
                          'success' => false,
                          'message' => 'Geçersiz resim dosyası.',
                      ], 422);
                  }

                  // Sadece belirli MIME tiplerini kabul et
                  $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png',
  'image/webp'];
                  if (!in_array($imageInfo['mime'], $allowedMimes)) {
                      return response()->json([
                          'success' => false,
                          'message' => 'Sadece JPG, PNG ve WEBP formatları
  kabul edilir.',
                      ], 422);
                  }

                  // Resmi sıkıştır (max 800x800)
                  $gd = imagecreatefromstring($imageContent);

                  if ($gd !== false) {
                      $width = imagesx($gd);
                      $height = imagesy($gd);
                      $maxSize = 800;

                      // Resize if needed
                      if ($width > $maxSize || $height > $maxSize) {
                          $ratio = min($maxSize / $width, $maxSize /
  $height);
                          $newWidth = (int)($width * $ratio);
                          $newHeight = (int)($height * $ratio);

                          $newImage = imagecreatetruecolor($newWidth,
  $newHeight);

                          // PNG için transparency desteği
                          imagealphablending($newImage, false);
                          imagesavealpha($newImage, true);

                          imagecopyresampled($newImage, $gd, 0, 0, 0, 0,
  $newWidth, $newHeight, $width, $height);

                          ob_start();
                          imagejpeg($newImage, null, 85); // 85% quality
                          $compressedContent = ob_get_clean();

                          imagedestroy($newImage);
                          imagedestroy($gd);

                          $imageBase64 = base64_encode($compressedContent);
                      } else {
                          imagedestroy($gd);
                          $imageBase64 = base64_encode($imageContent);
                      }
                  } else {
                      return response()->json([
                          'success' => false,
                          'message' => 'Resim işlenemedi.',
                      ], 422);
                  }
              }

              // 7. KAYDET - Admin onayı bekleyecek şekilde
              $entry = SecretWallEntry::create([
                  'isimsoyisim' => $cleanName,
                  'resim_base64' => $imageBase64,
                  'facebook_link' => strip_tags($request->facebook_link),
                  'instagram_link' => strip_tags($request->instagram_link),
                  'linkedin_link' => strip_tags($request->linkedin_link),
                  'tiktok_link' => strip_tags($request->tiktok_link),
                  'whatsapp_link' => strip_tags($request->whatsapp_link),
                  'x_link' => strip_tags($request->x_link),
                  'youtube_link' => strip_tags($request->youtube_link),
                  'is_active' => false, // Admin onayı bekliyor
                  'ip_address' => $request->ip(),
                  'user_agent' => $request->userAgent(),
                  'session_id' => session()->getId(),
                  'view_count' => 0,
              ]);

              // 8. RATE LIMIT SAYACINI ARTIR - 1 saat boyunca sakla
              Cache::put($rateLimitKey, $submissions + 1, now()->addHour());

              return response()->json([
                  'success' => true,
                  'message' => 'Kaydınız başarıyla alındı! Admin onayından
  sonra gizli duvarda görüntülenecektir.',
                  'data' => [
                      'id' => $entry->id,
                      'isimsoyisim' => $entry->isimsoyisim,
                      'status' => 'pending_approval',
                  ],
              ], 201);

          } catch (\Exception $e) {
              return response()->json([
                  'success' => false,
                  'message' => 'Kayıt oluşturulurken bir hata oluştu.',
                  'error' => config('app.debug') ? $e->getMessage() : null,
              ], 500);
          }
      }

      /**
       * Tek bir kayıt detayını getir
       *
       * @param  int  $id
       * @return \Illuminate\Http\JsonResponse
       */
      public function show($id)
      {
          try {
              $entry = SecretWallEntry::active()->findOrFail($id);

              // Görüntülenme sayısını artır
              $entry->incrementViewCount();

              return response()->json([
                  'success' => true,
                  'data' => [
                      'id' => $entry->id,
                      'isimsoyisim' => $entry->isimsoyisim,
                      'resim_url' => $entry->getImageData(),
                      'initials' => $entry->getInitials(),
                      'avatar_color' => $entry->getAvatarColor(),
                      'social_links' => [
                          'facebook' => $entry->facebook_link,
                          'instagram' => $entry->instagram_link,
                          'linkedin' => $entry->linkedin_link,
                          'tiktok' => $entry->tiktok_link,
                          'whatsapp' => $entry->whatsapp_link,
                          'x' => $entry->x_link,
                          'youtube' => $entry->youtube_link,
                      ],
                      'view_count' => $entry->view_count,
                      'created_at' => $entry->created_at->toIso8601String(),
                  ],
              ], 200);

          } catch (\Exception $e) {
              return response()->json([
                  'success' => false,
                  'message' => 'Kayıt bulunamadı.',
                  'error' => config('app.debug') ? $e->getMessage() : null,
              ], 404);
          }
      }

      /**
       * İstatistik bilgilerini getir
       *
       * @return \Illuminate\Http\JsonResponse
       */
      public function statistics()
      {
          try {
              $stats = [
                  'total_entries' => SecretWallEntry::active()->count(),
                  'total_views' =>
  SecretWallEntry::active()->sum('view_count'),
                  'recent_entries' => SecretWallEntry::active()
                      ->whereDate('created_at', '>=', now()->subDays(7))
                      ->count(),
              ];

              return response()->json([
                  'success' => true,
                  'data' => $stats,
              ], 200);

          } catch (\Exception $e) {
              return response()->json([
                  'success' => false,
                  'message' => 'İstatistikler getirilirken bir hata
  oluştu.',
                  'error' => config('app.debug') ? $e->getMessage() : null,
              ], 500);
          }
      }
  }

