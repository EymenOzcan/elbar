<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'language_id',
        'title',
        'description',
        'meta_title',
        'meta_description'
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}