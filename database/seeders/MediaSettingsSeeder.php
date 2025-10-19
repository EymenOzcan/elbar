<?php

namespace Database\Seeders;

use App\Models\MediaSetting;
use Illuminate\Database\Seeder;

class MediaSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Storage Type Selection
            ['key' => 'default_storage_type', 'value' => 'local', 'type' => 'string', 'group' => 'storage'],
            
            // File Size Limits
            ['key' => 'max_image_size', 'value' => '10240', 'type' => 'integer', 'group' => 'image'], // 10MB in KB
            ['key' => 'max_video_size', 'value' => '5242880', 'type' => 'integer', 'group' => 'video'], // 5GB in KB
            ['key' => 'chunk_size', 'value' => '2048', 'type' => 'integer', 'group' => 'upload'], // 2MB in KB
            
            // Allowed File Types
            ['key' => 'allowed_image_types', 'value' => 'jpg,jpeg,png,gif,webp,tiff,raw', 'type' => 'string', 'group' => 'image'],
            ['key' => 'allowed_video_types', 'value' => 'mp4,webm,avi,mov,mkv,flv', 'type' => 'string', 'group' => 'video'],
            
            // Local Storage
            ['key' => 'local_storage_path', 'value' => 'storage/app/public', 'type' => 'string', 'group' => 'storage'],
            
            // Amazon S3 Settings
            ['key' => 's3_enabled', 'value' => 'false', 'type' => 'boolean', 'group' => 'storage'],
            ['key' => 's3_bucket', 'value' => '', 'type' => 'string', 'group' => 'storage'],
            ['key' => 's3_region', 'value' => 'eu-central-1', 'type' => 'string', 'group' => 'storage'],
            ['key' => 's3_key', 'value' => '', 'type' => 'string', 'group' => 'storage'],
            ['key' => 's3_secret', 'value' => '', 'type' => 'string', 'group' => 'storage'],
            ['key' => 's3_endpoint', 'value' => '', 'type' => 'string', 'group' => 'storage'],
            ['key' => 's3_url', 'value' => '', 'type' => 'string', 'group' => 'storage'],
            
            // Cloudinary Settings
            ['key' => 'cloudinary_enabled', 'value' => 'false', 'type' => 'boolean', 'group' => 'storage'],
            ['key' => 'cloudinary_cloud_name', 'value' => '', 'type' => 'string', 'group' => 'storage'],
            ['key' => 'cloudinary_api_key', 'value' => '', 'type' => 'string', 'group' => 'storage'],
            ['key' => 'cloudinary_api_secret', 'value' => '', 'type' => 'string', 'group' => 'storage'],
            ['key' => 'cloudinary_folder', 'value' => 'media', 'type' => 'string', 'group' => 'storage'],
            
            // Custom URL Settings
            ['key' => 'custom_url_enabled', 'value' => 'false', 'type' => 'boolean', 'group' => 'storage'],
            ['key' => 'custom_url_base', 'value' => '', 'type' => 'string', 'group' => 'storage'],
            ['key' => 'custom_url_path', 'value' => '/media', 'type' => 'string', 'group' => 'storage'],
            
            // Image Processing Settings
            ['key' => 'image_thumbnail_width', 'value' => '300', 'type' => 'integer', 'group' => 'image'],
            ['key' => 'image_thumbnail_height', 'value' => '300', 'type' => 'integer', 'group' => 'image'],
            ['key' => 'auto_generate_thumbnails', 'value' => 'true', 'type' => 'boolean', 'group' => 'image'],
            ['key' => 'auto_compress_images', 'value' => 'true', 'type' => 'boolean', 'group' => 'image'],
            ['key' => 'image_quality', 'value' => '85', 'type' => 'integer', 'group' => 'image'], // 0-100
            
            // Video Processing Settings
            ['key' => 'video_thumbnail_at_second', 'value' => '5', 'type' => 'integer', 'group' => 'video'],
            ['key' => 'auto_generate_video_thumbnails', 'value' => 'true', 'type' => 'boolean', 'group' => 'video'],
            
            // Watermark Settings
            ['key' => 'watermark_enabled', 'value' => 'false', 'type' => 'boolean', 'group' => 'watermark'],
            ['key' => 'watermark_position', 'value' => 'bottom-right', 'type' => 'string', 'group' => 'watermark'],
            ['key' => 'watermark_image', 'value' => '', 'type' => 'string', 'group' => 'watermark'],
            ['key' => 'watermark_opacity', 'value' => '50', 'type' => 'integer', 'group' => 'watermark'],
            
            // Upload Settings
            ['key' => 'enable_chunk_upload', 'value' => 'true', 'type' => 'boolean', 'group' => 'upload'],
            ['key' => 'max_parallel_uploads', 'value' => '3', 'type' => 'integer', 'group' => 'upload'],
        ];

        foreach ($settings as $setting) {
            MediaSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'] ?? 'string',
                    'group' => $setting['group'] ?? 'general',
                ]
            );
        }

        $this->command->info('Medya ayarları başarıyla oluşturuldu!');
    }
}