<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonelTranslation extends Model
{
    protected $fillable = [
        'personel_id',
        'language_id',
        'position',
        'description',
    ];

    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
