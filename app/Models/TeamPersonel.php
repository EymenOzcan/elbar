<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamPersonel extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'personel_id',
        'order',
    ];

    /**
     * Get the team
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the personel
     */
    public function personel(): BelongsTo
    {
        return $this->belongsTo(Personel::class);
    }
}
