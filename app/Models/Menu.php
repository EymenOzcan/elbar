<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'parent_id',
        'type',
        'url',
        'page_id',
        'target',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(MenuTranslation::class);
    }

    public function translation($languageId = null)
    {
        if (!$languageId) {
            $language = Language::getDefault();
            $languageId = $language ? $language->id : 1;
        }
        
        return $this->hasOne(MenuTranslation::class)->where('language_id', $languageId);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    public function activeChildren()
    {
        return $this->children()->where('is_active', true);
    }

    // Belirli bir lokasyondaki menüleri getir
    public static function getByLocation($location)
    {
        return self::where('location', $location)
                   ->whereNull('parent_id')
                   ->where('is_active', true)
                   ->orderBy('sort_order')
                   ->with(['translations', 'children.translations'])
                   ->get();
    }

    // Menü URL'ini oluştur
    public function getUrl($languageCode = null)
    {
        if ($this->type == 'link') {
            return $this->url;
        }
        
        if ($this->type == 'page' && $this->page) {
            $lang = $languageCode ?: app()->getLocale();
            return '/' . $lang . '/' . $this->page->slug;
        }
        
        return '#';
    }
}