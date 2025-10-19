<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecretWallEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'isimsoyisim',
        'resim_base64',
        'facebook_link',
        'instagram_link',
        'linkedin_link',
        'tiktok_link',
        'whatsapp_link',
        'x_link',
        'youtube_link',
        'is_active',
        'approved_at',
        'approved_by',
        'ip_address',
        'user_agent',
        'session_id',
        'view_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'approved_at' => 'datetime',
        'view_count' => 'integer'
    ];

    protected $dates = [
        'approved_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // İlişkiler
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopelar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Base64 Resim Metodları
    public function hasImage()
    {
        return !empty($this->resim_base64) &&
               (str_starts_with($this->resim_base64, 'data:image') ||
                str_starts_with($this->resim_base64, '/9j') ||  // JPEG base64
                str_starts_with($this->resim_base64, 'iVBOR')); // PNG base64
    }

    public function getImageData()
    {
        if (!$this->hasImage()) {
            return null;
        }

        // Eğer data:image ile başlamıyorsa ekle
        if (!str_starts_with($this->resim_base64, 'data:image')) {
            // PNG mi JPEG mi kontrol et
            if (str_starts_with($this->resim_base64, 'iVBOR')) {
                return 'data:image/png;base64,' . $this->resim_base64;
            } else {
                return 'data:image/jpeg;base64,' . $this->resim_base64;
            }
        }

        return $this->resim_base64;
    }

    public function getImageSize()
    {
        if (!$this->hasImage()) {
            return 0;
        }

        // Base64 string'in boyutunu hesapla (KB)
        $base64 = $this->resim_base64;
        if (str_contains($base64, ',')) {
            $base64 = substr($base64, strpos($base64, ',') + 1);
        }
        
        return round(strlen($base64) * 0.75 / 1024, 2);
    }

    public function getImageType()
    {
        if (!$this->hasImage()) {
            return null;
        }

        if (preg_match('/data:image\/(\w+);base64,/', $this->resim_base64, $matches)) {
            return strtoupper($matches[1]);
        }

        return 'JPEG'; // Default
    }

    // Sosyal Medya Metodları
    public function getSocialLinksArray()
    {
        return [
            'facebook' => $this->facebook_link,
            'instagram' => $this->instagram_link,
            'linkedin' => $this->linkedin_link,
            'tiktok' => $this->tiktok_link,
            'whatsapp' => $this->whatsapp_link,
            'x' => $this->x_link,
            'youtube' => $this->youtube_link,
        ];
    }

    public function getActiveSocialLinks()
    {
        return array_filter($this->getSocialLinksArray());
    }

    public function getActiveSocialLinksCount()
    {
        return count($this->getActiveSocialLinks());
    }

    // Avatar Oluşturma (resim yoksa)
    public function getInitials()
    {
        $words = explode(' ', $this->isimsoyisim);
        $initials = '';
        
        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $initials .= mb_strtoupper(mb_substr($word, 0, 1));
            }
        }
        
        return mb_substr($initials, 0, 2);
    }

    public function getAvatarColor()
    {
        // İsme göre tutarlı renk oluştur
        $colors = [
            'from-blue-400 to-blue-600',
            'from-purple-400 to-purple-600',
            'from-pink-400 to-pink-600',
            'from-red-400 to-red-600',
            'from-orange-400 to-orange-600',
            'from-yellow-400 to-yellow-600',
            'from-green-400 to-green-600',
            'from-teal-400 to-teal-600',
            'from-cyan-400 to-cyan-600',
            'from-indigo-400 to-indigo-600',
        ];
        
        $index = ord($this->isimsoyisim[0]) % count($colors);
        return $colors[$index];
    }

    // IP ve Güvenlik
    public function getFormattedIpAddress()
    {
        if (!$this->ip_address) {
            return 'Bilinmiyor';
        }

        // IPv4 için son okteti maskele
        if (filter_var($this->ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $this->ip_address);
            $parts[3] = 'xxx';
            return implode('.', $parts);
        }

        // IPv6 için son bölümü maskele
        if (filter_var($this->ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $parts = explode(':', $this->ip_address);
            $parts[count($parts) - 1] = 'xxxx';
            return implode(':', $parts);
        }

        return 'Maskelenmiş';
    }

    public function getBrowserInfo()
    {
        if (!$this->user_agent) {
            return 'Bilinmiyor';
        }

        // Basit browser detection
        $ua = $this->user_agent;
        
        if (str_contains($ua, 'Chrome')) return 'Chrome';
        if (str_contains($ua, 'Safari')) return 'Safari';
        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Edge')) return 'Edge';
        if (str_contains($ua, 'Opera')) return 'Opera';
        
        return 'Diğer';
    }

    // İstatistik
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    // Onaylama
    public function approve($adminId = null)
    {
        $this->update([
            'is_active' => true,
            'approved_at' => now(),
            'approved_by' => $adminId ?? auth()->id()
        ]);
    }

    public function reject()
    {
        $this->update([
            'is_active' => false,
            'approved_at' => null,
            'approved_by' => null
        ]);
    }

    // API için JSON formatı
    public function toPublicArray()
    {
        return [
            'id' => $this->id,
            'isimsoyisim' => $this->isimsoyisim,
            'resim_url' => $this->getImageData(),
            'facebook_link' => $this->facebook_link,
            'instagram_link' => $this->instagram_link,
            'linkedin_link' => $this->linkedin_link,
            'tiktok_link' => $this->tiktok_link,
            'whatsapp_link' => $this->whatsapp_link,
            'x_link' => $this->x_link,
            'youtube_link' => $this->youtube_link,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}