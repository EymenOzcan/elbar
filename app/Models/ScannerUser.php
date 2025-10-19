<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannerUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'username',
        'password',
        'scan_count',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'scan_count' => 'integer',
    ];

    /**
     * Aktif kullanıcılar
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Pasif kullanıcılar
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Tarama sayısını artır
     */
    public function incrementScanCount()
    {
        $this->increment('scan_count');
    }
}