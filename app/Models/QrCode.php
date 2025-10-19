<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'target_url',
        'qr_image_path',
        'expires_at',
        'is_used',
        'used_at',
        'user_agent',
        'ip_address',
        'scan_count',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'is_used' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * QR kodunun geçerliliğini kontrol et
     */
    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    /**
     * QR kodunun geçerli olup olmadığını kontrol et
     */
    public function isValid(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    /**
     * QR kodu kullanıldı olarak işaretle
     */
    public function markAsUsed($userAgent = null, $ipAddress = null): void
    {
        $this->update([
            'is_used' => true,
            'used_at' => Carbon::now(),
            'user_agent' => $userAgent,
            'ip_address' => $ipAddress,
            'scan_count' => $this->scan_count + 1,
        ]);
    }

    /**
     * Scan sayısını artır
     */
    public function incrementScan(): void
    {
        $this->increment('scan_count');
    }

    /**
     * Sadece aktif QR kodlarını getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Sadece geçerli QR kodlarını getir
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
                    ->where('expires_at', '>', Carbon::now());
    }

    /**
     * Süresi dolmuş QR kodlarını getir
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', Carbon::now());
    }
}