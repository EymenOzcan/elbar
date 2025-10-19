<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'slug',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // İlişkiler
    public function translations()
    {
        return $this->hasMany(GalleryTranslation::class);
    }

    public function mediaFiles()
    {
        return $this->hasMany(MediaFile::class)->orderBy('sort_order');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'gallery_categories');
    }

    // Helper metodlar
    public function getTranslation($languageId = null)
    {
        if (!$languageId) {
            $languageId = Language::getDefault()->id;
        }
        return $this->translations->where('language_id', $languageId)->first();
    }

    public static function getByType($type)
    {
        return self::where('type', $type)->where('is_active', true)->orderBy('sort_order')->get();
    }
}