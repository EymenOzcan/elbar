<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMediaFollow extends Model
{
    use HasFactory;

    protected $fillable = [
        'personel_id',
        'platform',
        'ip_address',
        'user_agent',
    ];

    // Relationships
    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }
}
