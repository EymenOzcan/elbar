<?php

namespace App\Http\Controllers;

use App\Models\SecretWallEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class SecretWallPublicController extends Controller
{
    /**
     * Gizli Duvar kayıt formu (Public)
     */
    public function index()
    {
        return view('public.secret-wall.index');
    }

    /**
     * Gizli Duvar kayıt işlemi
     */
    public function store(Request $request)
    {
        // 1. HONEYPOT KONTROLÜ - Botlar için gizli alan
        if ($request->filled('website')) {
            // Bot tespit edildi, sessizce reddet
            return back()->with('success', 'Kaydınız başarıyla alındı!');
        }

        // 2. ZAMAN BAZLI KORUMA - Form yüklenme zamanı kontrolü
        $formLoadTime = $request->input('form_load_time');
        if ($formLoadTime && (time() - $formLoadTime) < 3) {
            return back()->withErrors(['error' => 'Lütfen formu daha dikkatli doldurun.'])->withInput();
        }

        // 3. RATE LIMITING - IP başına saatte 6 kayıt
        $ip = $request->ip();
        $rateLimitKey = 'secret_wall_rate_limit:' . $ip;
        $submissions = Cache::get($rateLimitKey, 0);

        if ($submissions >= 6) {
            return back()->withErrors(['error' => 'Çok fazla kayıt denemesi yaptınız. Lütfen 1 saat sonra tekrar deneyin.'])->withInput();
        }

        $validator = Validator::make($request->all(), [
            'isimsoyisim' => 'required|string|max:255',
            'resim' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max, sadece güvenli formatlar
            'facebook_link' => 'nullable|url|max:500',
            'instagram_link' => 'nullable|string|max:500',
            'linkedin_link' => 'nullable|url|max:500',
            'tiktok_link' => 'nullable|url|max:500',
            'whatsapp_link' => 'nullable|string|max:500',
            'x_link' => 'nullable|url|max:500',
            'youtube_link' => 'nullable|url|max:500',
        ], [
            'isimsoyisim.required' => 'İsim soyisim alanı zorunludur.',
            'resim.image' => 'Yüklenen dosya bir resim olmalıdır.',
            'resim.mimes' => 'Sadece JPG, PNG ve WEBP formatları kabul edilir.',
            'resim.max' => 'Resim boyutu en fazla 5MB olabilir.',
            '*.url' => 'Geçerli bir URL giriniz.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 4. XSS KORUMASI - HTML tag'lerini temizle
        $cleanName = strip_tags($request->isimsoyisim);

        // 5. DOSYA GÜVENLİĞİ - Resmi base64'e çevir ve doğrula
        $imageBase64 = null;
        if ($request->hasFile('resim')) {
            $image = $request->file('resim');

            // Dosya gerçek bir resim mi kontrol et
            $imageInfo = @getimagesize($image->getRealPath());
            if ($imageInfo === false) {
                return back()->withErrors(['resim' => 'Geçersiz resim dosyası.'])->withInput();
            }

            // Sadece belirli MIME tiplerini kabul et
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!in_array($imageInfo['mime'], $allowedMimes)) {
                return back()->withErrors(['resim' => 'Sadece JPG, PNG ve WEBP formatları kabul edilir.'])->withInput();
            }

            $imageContent = file_get_contents($image->getRealPath());

            // Resmi sıkıştır (max 800x800)
            $gd = imagecreatefromstring($imageContent);

            if ($gd !== false) {
                $width = imagesx($gd);
                $height = imagesy($gd);
                $maxSize = 800;

                // Resize if needed
                if ($width > $maxSize || $height > $maxSize) {
                    $ratio = min($maxSize / $width, $maxSize / $height);
                    $newWidth = (int)($width * $ratio);
                    $newHeight = (int)($height * $ratio);

                    $newImage = imagecreatetruecolor($newWidth, $newHeight);

                    // PNG için transparency desteği
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);

                    imagecopyresampled($newImage, $gd, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

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
                return back()->withErrors(['resim' => 'Resim işlenemedi.'])->withInput();
            }
        }

        // 6. KAYDET - Admin onayı bekleyecek şekilde
        SecretWallEntry::create([
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

        // 7. RATE LIMIT SAYACINI ARTIR - 1 saat boyunca sakla
        Cache::put($rateLimitKey, $submissions + 1, now()->addHour());

        return back()->with('success', 'Kaydınız başarıyla alındı! Admin onayından sonra gizli duvarda görüntülenecektir.');
    }
}
