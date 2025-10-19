<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisualShow extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_data',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Sadece aktif görselleri getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Sıralı görselleri getir
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
