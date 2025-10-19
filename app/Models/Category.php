<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'icon',
        'image',
        'color',
        'parent_id',
        'is_active',
        'show_in_menu',
        'show_in_home',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_menu' => 'boolean',
        'show_in_home' => 'boolean',
    ];

    // Ana kategoriler (VoIP, Sunucu, Sinema, Sanat, vb.)
    public static $mainCategories = [
        'voip' => [
            'icon' => 'phone',
            'color' => '#3b82f6',
            'subcategories' => ['voip-systems', 'call-center', 'cloud-pbx', 'sip-trunk']
        ],
        'server' => [
            'icon' => 'server',
            'color' => '#10b981',
            'subcategories' => ['dedicated-server', 'vps', 'cloud-hosting', 'colocation']
        ],
        'cinema' => [
            'icon' => 'film',
            'color' => '#f59e0b',
            'subcategories' => ['cinema-systems', 'projection', 'sound-systems', 'cinema-seats']
        ],
        'art' => [
            'icon' => 'palette',
            'color' => '#8b5cf6',
            'subcategories' => ['exhibitions', 'gallery', 'art-consulting', 'restoration']
        ],
        'entertainment' => [
            'icon' => 'music',
            'color' => '#ec4899',
            'subcategories' => ['event-organization', 'concert-systems', 'lighting', 'stage-design']
        ],
        'technology' => [
            'icon' => 'cpu',
            'color' => '#06b6d4',
            'subcategories' => ['software-development', 'mobile-apps', 'iot', 'ai-solutions']
        ]
    ];

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function translation($languageId = null)
    {
        if (!$languageId) {
            $language = Language::getDefault();
            $languageId = $language ? $language->id : 1;
        }
        
        return $this->hasOne(CategoryTranslation::class)->where('language_id', $languageId);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'page_categories');
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Aktif alt kategorileri getir
    public function activeChildren()
    {
        return $this->children()->where('is_active', true)->orderBy('sort_order');
    }

    // Belirli bir dildeki kategori adını getir
    public function getName($languageCode = null)
    {
        $translation = $this->getTranslation($languageCode);
        return $translation ? $translation->name : $this->slug;
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
}