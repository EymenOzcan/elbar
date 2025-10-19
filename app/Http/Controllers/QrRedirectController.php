<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;

class QrRedirectController extends Controller
{
    public function redirect($code)
    {
        $qrCode = QrCode::where('code', $code)->first();

        if (!$qrCode) {
            abort(404, 'QR kod bulunamadı.');
        }

        // QR kod geçerliliğini kontrol et
        if (!$qrCode->isValid()) {
            abort(410, 'QR kod süresi dolmuş veya geçersiz.');
        }

        // Tarama sayısını artır
        $qrCode->increment('scan_count');

        // Hedef URL'ye yönlendir
        return redirect($qrCode->target_url);
    }
}
