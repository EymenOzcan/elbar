<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecretWall extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'secret_wall_entries';

    protected $fillable = [
        'isimsoyisim',
        'resim_url',
        'facebook_link',
        'instagram_link',
        'linkedin_link',
        'tiktok_link',
        'whatsapp_link',
        'x_link',
        'youtube_link',
        'is_active',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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

    // Helper metodlar
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

    public function getActiveSocialLinksCount()
    {
        return count(array_filter($this->getSocialLinksArray()));
    }
}