<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $fillable = [
        'page_type',
        'title',
        'slug',
        'image',
        'banner_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(StaticPageTranslation::class);
    }

    public function contact()
    {
        return $this->hasOne(StaticPageContact::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('page_type', $type);
    }

    // Get translation for specific language
    public function getTranslation($languageId)
    {
        return $this->translations()->where('language_id', $languageId)->first();
    }

    // Get page type label
    public function getPageTypeLabelAttribute()
    {
        $labels = [
            'contact' => 'İletişim',
            'about' => 'Hakkımızda',
            'privacy' => 'Gizlilik Politikası',
            'terms' => 'Kullanım Koşulları',
            'faq' => 'Sıkça Sorulan Sorular',
        ];

        return $labels[$this->page_type] ?? $this->page_type;
    }
}
