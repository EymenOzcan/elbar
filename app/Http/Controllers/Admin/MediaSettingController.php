<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaSettingController extends Controller
{
    public function index()
    {
        $settings = MediaSetting::all()->keyBy('key');
        
        // Gruplara göre ayarları organize et
        $groups = [
            'storage' => [
                'title' => 'Depolama Ayarları',
                'icon' => '💾',
                'settings' => []
            ],
            'image' => [
                'title' => 'Görsel Ayarları',
                'icon' => '🖼️',
                'settings' => []
            ],
            'video' => [
                'title' => 'Video Ayarları',
                'icon' => '🎬',
                'settings' => []
            ],
            'watermark' => [
                'title' => 'Filigran Ayarları',
                'icon' => '©️',
                'settings' => []
            ],
            'upload' => [
                'title' => 'Yükleme Ayarları',
                'icon' => '⬆️',
                'settings' => []
            ],
        ];
        
        foreach ($settings as $setting) {
            $group = $setting->group ?? 'general';
            if (isset($groups[$group])) {
                $groups[$group]['settings'][] = $setting;
            }
        }
        
        return view('admin.media-settings.index', compact('settings', 'groups'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->input('settings', []) as $key => $value) {
            $setting = MediaSetting::where('key', $key)->first();
            
            if ($setting) {
                // Boolean için özel işlem
                if ($setting->type === 'boolean') {
                    $value = $value === 'on' || $value === '1' || $value === 'true' ? 'true' : 'false';
                }
                
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->route('admin.media-settings.index')
            ->with('success', 'Medya ayarları başarıyla güncellendi.');
    }

    public function testConnection(Request $request)
    {
        $type = $request->input('type');
        
        try {
            switch ($type) {
                case 's3':
                    $accessKey = MediaSetting::get('s3_key');
                    $secretKey = MediaSetting::get('s3_secret');
                    $region = MediaSetting::get('s3_region');
                    $bucket = MediaSetting::get('s3_bucket');
                    
                    if (empty($accessKey) || empty($secretKey) || empty($bucket)) {
                        return response()->json([
                            'success' => false, 
                            'message' => 'S3 bilgileri eksik. Lütfen tüm alanları doldurun.'
                        ]);
                    }
                    
                    // S3 test edilebilir (AWS SDK gerekir)
                    return response()->json([
                        'success' => true, 
                        'message' => 'S3 ayarları kaydedildi. Yükleme yaparken test edilecek.'
                    ]);
                    
                case 'cloudinary':
                    $cloudName = MediaSetting::get('cloudinary_cloud_name');
                    $apiKey = MediaSetting::get('cloudinary_api_key');
                    $apiSecret = MediaSetting::get('cloudinary_api_secret');
                    
                    if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
                        return response()->json([
                            'success' => false, 
                            'message' => 'Cloudinary bilgileri eksik.'
                        ]);
                    }
                    
                    return response()->json([
                        'success' => true, 
                        'message' => 'Cloudinary ayarları kaydedildi.'
                    ]);
                    
                default:
                    return response()->json([
                        'success' => false, 
                        'message' => 'Geçersiz bağlantı tipi'
                    ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Bağlantı hatası: ' . $e->getMessage()
            ]);
        }
    }
}