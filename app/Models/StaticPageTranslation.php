<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPageTranslation extends Model
{
    protected $fillable = [
        'static_page_id',
        'language_id',
        'title',
        'content',
        'meta_description',
        'custom_fields',
    ];

    protected $casts = [
        'custom_fields' => 'array',
    ];

    public function staticPage()
    {
        return $this->belongsTo(StaticPage::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
