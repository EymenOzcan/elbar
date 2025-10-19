<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'template',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function translation($languageId = null)
    {
        if (!$languageId) {
            $language = Language::getDefault();
            $languageId = $language ? $language->id : 1;
        }
        
        return $this->hasOne(PageTranslation::class)->where('language_id', $languageId);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Belirli bir dildeki içeriği getir
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

    // Tüm dillerdeki başlıkları getir
    public function getAllTitles()
    {
        return $this->translations()->with('language')->get()->pluck('title', 'language.code');
    }

public function categories()
{
    return $this->belongsToMany(Category::class, 'page_categories');
}

// Belirli bir kategoriye ait mi?
public function hasCategory($categoryId)
{
    return $this->categories()->where('category_id', $categoryId)->exists();
}

// Kategoriye göre sayfaları getir
public static function getByCategorySlug($slug, $limit = null)
{
    $category = Category::where('slug', $slug)->first();
    
    if (!$category) {
        return collect();
    }
    
    $query = self::whereHas('categories', function($q) use ($category) {
        $q->where('category_id', $category->id);
    })->where('is_active', true);
    
    if ($limit) {
        $query->limit($limit);
    }
    
    return $query->get();
}


}