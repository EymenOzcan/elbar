<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'language_id',
        'title',
        'short_description',
        'content',
        'features',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'features' => 'array'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}