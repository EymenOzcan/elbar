<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'slug',
        'icon',
        'image',
        'price',
        'price_type',
        'is_featured',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function translations()
    {
        return $this->hasMany(ServiceTranslation::class);
    }

    public function translation($languageId = null)
    {
        if (!$languageId) {
            $language = Language::getDefault();
            $languageId = $language ? $language->id : 1;
        }
        
        return $this->hasOne(ServiceTranslation::class)->where('language_id', $languageId);
    }

    public function getTranslation($languageCode = null)
    {
        if (!$languageCode) {
            $language = Language::getDefault();
        } else {
            $language = Language::where('code', $languageCode)->first();
        }
        
        if (!$language) {
            return null;
        }
        
        return $this->translations()->where('language_id', $language->id)->first();
    }

    // Fiyat formatı
    public function getFormattedPrice()
    {
        if (!$this->price) {
            return 'Fiyat Sorunuz';
        }

        $price = number_format($this->price, 2, ',', '.');
        
        switch ($this->price_type) {
            case 'hourly':
                return $price . ' TL / Saat';
            case 'monthly':
                return $price . ' TL / Ay';
            case 'yearly':
                return $price . ' TL / Yıl';
            default:
                return $price . ' TL';
        }
    }
}