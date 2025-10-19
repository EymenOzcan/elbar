<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Language;
use App\Models\Category;
use App\Models\GalleryTranslation;
use App\Models\MediaFile;
use App\Models\MediaFileTranslation;
use App\Models\MediaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');
        
        $query = Gallery::with(['translations.language', 'categories', 'mediaFiles'])
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc');
        
        if ($type !== 'all') {
            $query->where('type', $type);
        }
        
        $galleries = $query->get();
        
        return view('admin.galleries.index', compact('galleries', 'type'));
    }

    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::with('translations')->where('is_active', true)->get();
        
        return view('admin.galleries.create', compact('languages', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:photo,video',
            'slug' => 'required|unique:galleries,slug',
            'translations' => 'required|array',
            'translations.*.title' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
        ]);

        $gallery = Gallery::create([
            'type' => $request->type,
            'slug' => $request->slug,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($request->translations as $languageId => $translation) {
            if (!empty($translation['title'])) {
                GalleryTranslation::create([
                    'gallery_id' => $gallery->id,
                    'language_id' => $languageId,
                    'title' => $translation['title'],
                    'description' => $translation['description'] ?? '',
                    'meta_title' => $translation['meta_title'] ?? $translation['title'],
                    'meta_description' => $translation['meta_description'] ?? '',
                ]);
            }
        }

        if ($request->categories) {
            $gallery->categories()->sync($request->categories);
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri başarıyla oluşturuldu.');
    }

    public function show(Gallery $gallery)
    {
        $gallery->load(['translations.language', 'categories.translations', 'mediaFiles.translations']);
        
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load(['translations', 'categories']);
        
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::with('translations')->where('is_active', true)->get();
        
        $translations = [];
        foreach ($languages as $language) {
            $translation = $gallery->translations->where('language_id', $language->id)->first();
            $translations[$language->id] = $translation ?: new GalleryTranslation(['language_id' => $language->id]);
        }
        
        return view('admin.galleries.edit', compact('gallery', 'languages', 'categories', 'translations'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'type' => 'required|in:photo,video',
            'slug' => 'required|unique:galleries,slug,' . $gallery->id,
            'translations' => 'required|array',
            'translations.*.title' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
        ]);

        $gallery->update([
            'type' => $request->type,
            'slug' => $request->slug,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($request->translations as $languageId => $translation) {
            if (!empty($translation['title'])) {
                GalleryTranslation::updateOrCreate(
                    [
                        'gallery_id' => $gallery->id,
                        'language_id' => $languageId
                    ],
                    [
                        'title' => $translation['title'],
                        'description' => $translation['description'] ?? '',
                        'meta_title' => $translation['meta_title'] ?? $translation['title'],
                        'meta_description' => $translation['meta_description'] ?? '',
                    ]
                );
            }
        }

        if ($request->has('categories')) {
            $gallery->categories()->sync($request->categories);
        } else {
            $gallery->categories()->detach();
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri başarıyla güncellendi.');
    }

    public function destroy(Gallery $gallery)
    {
        // Medya dosyalarını sil
        foreach ($gallery->mediaFiles as $media) {
            if ($media->storage_type === 'local') {
                Storage::disk('public')->delete($media->file_path);
                if ($media->thumbnail) {
                    Storage::disk('public')->delete($media->thumbnail);
                }
            }
            $media->translations()->delete();
            $media->delete();
        }

        $gallery->categories()->detach();
        $gallery->translations()->delete();
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri ve tüm medya dosyaları başarıyla silindi.');
    }

    /**
     * Medya dosyalarını yükle
     */
    public function upload(Request $request, Gallery $gallery)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => $gallery->type === 'photo' 
                ? 'image|mimes:jpeg,jpg,png,gif,webp,tiff|max:10240' 
                : 'mimes:mp4,webm,avi,mov,mkv|max:5242880', // 5GB = 5242880 KB
        ]);

        $uploadedFiles = [];
        $storageType = MediaSetting::get('default_storage_type', 'local');

        foreach ($request->file('files') as $file) {
            try {
                // Dosya bilgilerini al
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();
                
                // Benzersiz dosya adı oluştur
                $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                // Dosyayı sakla
                $path = $file->storeAs(
                    'galleries/' . $gallery->slug,
                    $fileName,
                    'public'
                );

                // Medya dosyası kaydı oluştur
                $mediaFile = MediaFile::create([
                    'gallery_id' => $gallery->id,
                    'type' => $gallery->type === 'photo' ? 'image' : 'video',
                    'storage_type' => $storageType,
                    'file_path' => $path,
                    'file_name' => $fileName,
                    'file_size' => $fileSize,
                    'mime_type' => $mimeType,
                    'sort_order' => $gallery->mediaFiles()->count(),
                    'is_active' => true,
                ]);

                // Görsel ise boyutları al
                if ($gallery->type === 'photo') {
                    try {
                        $imageSize = getimagesize($file->getPathname());
                        if ($imageSize) {
                            $mediaFile->update([
                                'width' => $imageSize[0],
                                'height' => $imageSize[1],
                            ]);
                        }

                        // Thumbnail oluştur
                        $this->generateThumbnail($file, $path, $mediaFile);
                    } catch (\Exception $e) {
                        // Thumbnail oluşturulamazsa devam et
                    }
                }

                // Video ise thumbnail oluşturmayı atla (şimdilik)
                // Video thumbnail'i için FFmpeg gerekir

                // Varsayılan çeviri ekle
                $defaultLanguage = Language::where('is_default', true)->first();
                if ($defaultLanguage) {
                    MediaFileTranslation::create([
                        'media_file_id' => $mediaFile->id,
                        'language_id' => $defaultLanguage->id,
                        'title' => pathinfo($originalName, PATHINFO_FILENAME),
                        'alt_text' => pathinfo($originalName, PATHINFO_FILENAME),
                    ]);
                }

                $uploadedFiles[] = [
                    'id' => $mediaFile->id,
                    'name' => $fileName,
                    'url' => $mediaFile->getUrl(),
                ];

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dosya yüklenirken hata oluştu: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($uploadedFiles) . ' dosya başarıyla yüklendi.',
            'files' => $uploadedFiles
        ]);
    }

                    /**
                 * Thumbnail oluştur (Intervention Image ile)
                 */
              /**
 * Thumbnail oluştur - Basit versiyon (GD yok ise orijinali kullan)
 */
private function generateThumbnail($file, $originalPath, $mediaFile)
{
    // GD extension kontrolü
    if (!extension_loaded('gd') || !function_exists('imagecreatefromjpeg')) {
        // GD yüklü değilse, orijinal resmi thumbnail olarak kullan
        $mediaFile->update(['thumbnail' => $originalPath]);
        \Log::warning('GD extension not loaded, using original image as thumbnail');
        return;
    }

    try {
        $thumbnailWidth = (int) (MediaSetting::get('image_thumbnail_width', 300) ?? 300);
        $thumbnailHeight = (int) (MediaSetting::get('image_thumbnail_height', 300) ?? 300);

        // Thumbnail yolu
        $pathInfo = pathinfo($originalPath);
        $thumbnailPath = $pathInfo['dirname'] . '/thumbnails/' . $pathInfo['basename'];

        // Klasör oluştur
        if (!Storage::disk('public')->exists($pathInfo['dirname'] . '/thumbnails')) {
            Storage::disk('public')->makeDirectory($pathInfo['dirname'] . '/thumbnails');
        }

        $sourcePath = Storage::disk('public')->path($originalPath);
        $destPath = Storage::disk('public')->path($thumbnailPath);

        // Dosya var mı kontrol et
        if (!file_exists($sourcePath)) {
            $mediaFile->update(['thumbnail' => $originalPath]);
            return;
        }

        // Dosya tipini al
        $imageInfo = @getimagesize($sourcePath);
        
        if (!$imageInfo) {
            $mediaFile->update(['thumbnail' => $originalPath]);
            return;
        }

        list($width, $height, $imageType) = $imageInfo;
        
        // Kaynak resmi yükle
        $source = null;
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $source = @imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $source = @imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $source = @imagecreatefromgif($sourcePath);
                break;
            case IMAGETYPE_WEBP:
                if (function_exists('imagecreatefromwebp')) {
                    $source = @imagecreatefromwebp($sourcePath);
                }
                break;
        }

        if (!$source) {
            $mediaFile->update(['thumbnail' => $originalPath]);
            return;
        }

        // Aspect ratio hesapla
        $ratio = min($thumbnailWidth / $width, $thumbnailHeight / $height);
        $newWidth = (int) ($width * $ratio);
        $newHeight = (int) ($height * $ratio);

        // Thumbnail oluştur
        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        
        if (!$thumb) {
            imagedestroy($source);
            $mediaFile->update(['thumbnail' => $originalPath]);
            return;
        }

        // PNG şeffaflık desteği
        if ($imageType === IMAGETYPE_PNG) {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            $transparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
            if ($transparent !== false) {
                imagefill($thumb, 0, 0, $transparent);
            }
        }

        // Resmi yeniden boyutlandır
        $resized = imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        if (!$resized) {
            imagedestroy($source);
            imagedestroy($thumb);
            $mediaFile->update(['thumbnail' => $originalPath]);
            return;
        }

        // Kaydet
        $saved = false;
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $saved = @imagejpeg($thumb, $destPath, 85);
                break;
            case IMAGETYPE_PNG:
                $saved = @imagepng($thumb, $destPath, 8);
                break;
            case IMAGETYPE_GIF:
                $saved = @imagegif($thumb, $destPath);
                break;
            case IMAGETYPE_WEBP:
                if (function_exists('imagewebp')) {
                    $saved = @imagewebp($thumb, $destPath, 85);
                }
                break;
        }

        imagedestroy($source);
        imagedestroy($thumb);

        if ($saved && file_exists($destPath)) {
            $mediaFile->update(['thumbnail' => $thumbnailPath]);
        } else {
            $mediaFile->update(['thumbnail' => $originalPath]);
        }

    } catch (\Exception $e) {
        \Log::error('Thumbnail generation error: ' . $e->getMessage());
        $mediaFile->update(['thumbnail' => $originalPath]);
    }
}

    /**
     * Medya dosyasını sil
     */
    public function deleteMedia(Request $request, Gallery $gallery, MediaFile $media)
    {
        if ($media->gallery_id !== $gallery->id) {
            return response()->json([
                'success' => false,
                'message' => 'Medya bu galeriye ait değil.'
            ], 403);
        }

        try {
            // Dosyaları sil
            if ($media->storage_type === 'local') {
                Storage::disk('public')->delete($media->file_path);
                if ($media->thumbnail) {
                    Storage::disk('public')->delete($media->thumbnail);
                }
            }

            // Veritabanı kayıtlarını sil
            $media->translations()->delete();
            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Medya dosyası başarıyla silindi.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Silme işlemi sırasında hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }



                    /**
                 * Chunk upload başlat
                 */
                public function uploadChunk(Request $request, Gallery $gallery)
                {
                    try {
                        // Chunk bilgilerini al
                        $chunkIndex = $request->input('dzchunkindex', 0);
                        $totalChunks = $request->input('dztotalchunkcount', 1);
                        $uuid = $request->input('dzuuid');
                        
                        if (!$uuid) {
                            return response()->json(['error' => 'UUID gerekli'], 400);
                        }

                        // Chunk dosyasını al
                        $chunk = $request->file('file');
                        
                        if (!$chunk) {
                            return response()->json(['error' => 'Dosya bulunamadı'], 400);
                        }

                        // Geçici dizin
                        $tempDir = storage_path('app/temp-uploads/' . $uuid);
                        if (!file_exists($tempDir)) {
                            mkdir($tempDir, 0755, true);
                        }

                        // Chunk'ı kaydet
                        $chunkPath = $tempDir . '/chunk_' . $chunkIndex;
                        move_uploaded_file($chunk->getPathname(), $chunkPath);

                        // Son chunk ise birleştir
                        if ($chunkIndex == $totalChunks - 1) {
                            return $this->mergeChunks($request, $gallery, $uuid, $totalChunks);
                        }

                        return response()->json([
                            'success' => true,
                            'message' => 'Chunk ' . ($chunkIndex + 1) . '/' . $totalChunks . ' yüklendi'
                        ]);

                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }

                /**
                 * Chunk'ları birleştir ve medya dosyası oluştur
                 */
                private function mergeChunks(Request $request, Gallery $gallery, $uuid, $totalChunks)
                {
                    try {
                        $tempDir = storage_path('app/temp-uploads/' . $uuid);
                        
                        // Orijinal dosya bilgilerini al
                        $originalName = $request->input('dzfilename', 'file');
                        $fileSize = $request->input('dztotalfilesize', 0);
                        
                        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                        $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '_' . Str::random(6) . '.' . $extension;
                        
                        // Hedef yol
                        $destinationDir = storage_path('app/public/galleries/' . $gallery->slug);
                        if (!file_exists($destinationDir)) {
                            mkdir($destinationDir, 0755, true);
                        }
                        
                        $finalPath = $destinationDir . '/' . $fileName;
                        $finalFile = fopen($finalPath, 'wb');
                        
                        if (!$finalFile) {
                            throw new \Exception('Hedef dosya oluşturulamadı');
                        }

                        // Chunk'ları birleştir
                        for ($i = 0; $i < $totalChunks; $i++) {
                            $chunkPath = $tempDir . '/chunk_' . $i;
                            
                            if (!file_exists($chunkPath)) {
                                fclose($finalFile);
                                throw new \Exception('Chunk ' . $i . ' bulunamadı');
                            }
                            
                            $chunkFile = fopen($chunkPath, 'rb');
                            while (!feof($chunkFile)) {
                                fwrite($finalFile, fread($chunkFile, 8192));
                            }
                            fclose($chunkFile);
                            unlink($chunkPath); // Chunk'ı sil
                        }
                        
                        fclose($finalFile);
                        
                        // Geçici dizini temizle
                        rmdir($tempDir);
                        
                        // MIME type'ı belirle
                        $mimeType = mime_content_type($finalPath);
                        
                        // Relative path
                        $relativePath = 'galleries/' . $gallery->slug . '/' . $fileName;
                        
                        // MediaFile kaydı oluştur
                        $mediaFile = MediaFile::create([
                            'gallery_id' => $gallery->id,
                            'type' => $gallery->type === 'photo' ? 'image' : 'video',
                            'storage_type' => 'local',
                            'file_path' => $relativePath,
                            'file_name' => $fileName,
                            'file_size' => $fileSize,
                            'mime_type' => $mimeType,
                            'sort_order' => $gallery->mediaFiles()->count(),
                            'is_active' => true,
                        ]);

                        // Görsel ise boyutları al
                        if ($gallery->type === 'photo') {
                            try {
                                $imageSize = getimagesize($finalPath);
                                if ($imageSize) {
                                    $mediaFile->update([
                                        'width' => $imageSize[0],
                                        'height' => $imageSize[1],
                                    ]);
                                }
                                
                                // Thumbnail oluştur
                                $this->generateThumbnail(null, $relativePath, $mediaFile);
                            } catch (\Exception $e) {
                                \Log::warning('Image size/thumbnail error: ' . $e->getMessage());
                            }
                        }

                        // Video ise süresini al (FFmpeg varsa)
                        if ($gallery->type === 'video') {
                            try {
                                if (function_exists('shell_exec')) {
                                    $duration = shell_exec("ffmpeg -i " . escapeshellarg($finalPath) . " 2>&1 | grep Duration | cut -d ' ' -f 4 | sed s/,//");
                                    if ($duration) {
                                        list($hours, $minutes, $seconds) = explode(':', trim($duration));
                                        $totalSeconds = ($hours * 3600) + ($minutes * 60) + floor($seconds);
                                        $mediaFile->update(['duration' => $totalSeconds]);
                                    }
                                }
                            } catch (\Exception $e) {
                                \Log::warning('Video duration error: ' . $e->getMessage());
                            }
                        }

                        // Varsayılan çeviri ekle
                        $defaultLanguage = Language::where('is_default', true)->first();
                        if ($defaultLanguage) {
                            MediaFileTranslation::create([
                                'media_file_id' => $mediaFile->id,
                                'language_id' => $defaultLanguage->id,
                                'title' => pathinfo($originalName, PATHINFO_FILENAME),
                                'alt_text' => pathinfo($originalName, PATHINFO_FILENAME),
                            ]);
                        }

                        return response()->json([
                            'success' => true,
                            'message' => 'Dosya başarıyla yüklendi',
                            'file' => [
                                'id' => $mediaFile->id,
                                'name' => $fileName,
                                'url' => $mediaFile->getUrl(),
                                'size' => $this->formatBytes($fileSize),
                            ]
                        ]);

                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'error' => 'Birleştirme hatası: ' . $e->getMessage()
                        ], 500);
                    }
                }

                /**
                 * Byte formatla
                 */
                private function formatBytes($bytes, $precision = 2)
                {
                    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                    
                    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                        $bytes /= 1024;
                    }
                    
                    return round($bytes, $precision) . ' ' . $units[$i];
                }




}