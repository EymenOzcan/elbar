<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'label',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active module
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper to get the active module
    public static function getActiveModule()
    {
        return self::where('is_active', true)->first();
    }
}
