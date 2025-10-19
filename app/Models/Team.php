<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'leader_id',
        'group_leader_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the leader of the team
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    /**
     * Get the group leader of the team
     */
    public function groupLeader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'group_leader_id');
    }

    /**
     * Get all personels in the team
     */
    public function personels(): HasMany
    {
        return $this->hasMany(TeamPersonel::class)->orderBy('order');
    }

    /**
     * Get personel count for the team
     */
    public function personelCount(): int
    {
        return $this->personels()->count();
    }

    /**
     * Scope for active teams
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
