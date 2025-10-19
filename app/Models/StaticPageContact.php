<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPageContact extends Model
{
    protected $fillable = [
        'static_page_id',
        'phone',
        'email',
        'address',
        'city',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'whatsapp',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
        'youtube_url',
        'working_hours',
    ];

    protected $casts = [
        'working_hours' => 'array',
    ];

    public function staticPage()
    {
        return $this->belongsTo(StaticPage::class);
    }
}
