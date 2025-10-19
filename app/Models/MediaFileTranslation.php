<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFileTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_file_id',
        'language_id',
        'title',
        'description',
        'alt_text'
    ];

    public function mediaFile()
    {
        return $this->belongsTo(MediaFile::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}