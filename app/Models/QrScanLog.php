<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrScanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'scanner_user_id',
        'qr_code_id',
        'is_valid',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
    ];

    public function scannerUser()
    {
        return $this->belongsTo(QrScannerUser::class, 'scanner_user_id');
    }

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }
}