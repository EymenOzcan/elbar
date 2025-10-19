<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'type',
        'storage_type',
        'file_path',
        'thumbnail',
        'file_name',
        'file_size',
        'mime_type',
        'width',
        'height',
        'duration',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // İlişkiler
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function translations()
    {
        return $this->hasMany(MediaFileTranslation::class);
    }

    // URL Oluşturma
    public function getUrl()
    {
        switch ($this->storage_type) {
            case 'local':
                return asset('storage/' . $this->file_path);
            case 's3':
            case 'cloudinary':
            case 'custom':
                return $this->file_path; // Tam URL olarak saklanıyor
            default:
                return asset('storage/' . $this->file_path);
        }
    }

    public function getThumbnailUrl()
    {
        if (!$this->thumbnail) {
            return $this->getUrl();
        }

        switch ($this->storage_type) {
            case 'local':
                return asset('storage/' . $this->thumbnail);
            case 's3':
            case 'cloudinary':
            case 'custom':
                return $this->thumbnail;
            default:
                return asset('storage/' . $this->thumbnail);
        }
    }

    // Helper metodlar
    public function getTranslation($languageId = null)
    {
        if (!$languageId) {
            $languageId = Language::getDefault()->id;
        }
        return $this->translations->where('language_id', $languageId)->first();
    }

    public function getFormattedSize()
    {
        if (!$this->file_size) return 'N/A';
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }

    public function getFormattedDuration()
    {
        if (!$this->duration) return null;
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}