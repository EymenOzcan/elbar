<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Personel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'phone',
        'email',
        'employment_type',
        'qr_code',
        'is_active',
        'instagram_username',
        'facebook_username',
        'tiktok_username',
        'x_username',
        'linkedin_username',
        'youtube_username',
        'whatsapp_number',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Generate unique QR code on creation
    protected static function booted()
    {
        static::creating(function ($personel) {
            if (empty($personel->qr_code)) {
                $personel->qr_code = 'PER-' . strtoupper(Str::random(12));
            }
        });
    }

    // Relationships
    public function socialMediaFollows()
    {
        return $this->hasMany(SocialMediaFollow::class);
    }

    public function translations()
    {
        return $this->hasMany(PersonelTranslation::class);
    }

    public function teams()
    {
        return $this->hasMany(TeamPersonel::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePrimli($query)
    {
        return $query->where('employment_type', 'primli');
    }

    public function scopeKadrolu($query)
    {
        return $query->where('employment_type', 'kadrolu');
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getTotalFollowsAttribute()
    {
        return $this->socialMediaFollows()->count();
    }

    public function getFollowsByPlatform($platform)
    {
        return $this->socialMediaFollows()->where('platform', $platform)->count();
    }

    public function getQrCodeUrlAttribute()
    {
        return route('personel.social-media', $this->qr_code);
    }
}
