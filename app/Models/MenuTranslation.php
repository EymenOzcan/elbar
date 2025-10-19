<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'language_id',
        'title'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}