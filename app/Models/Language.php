<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'flag',
        'is_active',
        'is_default',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function pageTranslations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function menuTranslations()
    {
        return $this->hasMany(MenuTranslation::class);
    }

    public static function getDefault()
    {
        return self::where('is_default', true)->first();
    }

    public static function getActive()
    {
        return self::where('is_active', true)->orderBy('sort_order')->get();
    }
}