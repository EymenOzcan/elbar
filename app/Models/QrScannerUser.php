<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QrScannerUser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'full_name',
        'is_active',
        'scan_count',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    public function scanLogs()
    {
        return $this->hasMany(QrScanLog::class, 'scanner_user_id');
    }

    public function incrementScanCount()
    {
        $this->increment('scan_count');
    }
}