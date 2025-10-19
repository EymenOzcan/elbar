<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use App\Models\ScannerUser;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScanController extends Controller
{
    /**
     * QR Tarama sayfası
     */
    public function index()
    {
        return view('scanner.scan');
    }

    /**
     * QR Kod doğrulama
     */
    public function verify(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $qrCodeValue = $request->input('qr_code');

        // QR kodu veritabanında bul
        $qrCode = QrCode::where('code', $qrCodeValue)->first();

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'status' => 'invalid',
                'message' => 'QR kod bulunamadı. Geçersiz kod!',
                'color' => 'red',
            ]);
        }

        // Süre kontrolü
        if ($qrCode->isExpired()) {
            return response()->json([
                'success' => false,
                'status' => 'expired',
                'message' => 'QR kodunun süresi dolmuş!',
                'expires_at' => $qrCode->expires_at->format('d.m.Y H:i'),
                'color' => 'orange',
            ]);
        }

        // Aktiflik kontrolü
        if (!$qrCode->is_active) {
            return response()->json([
                'success' => false,
                'status' => 'inactive',
                'message' => 'QR kod pasif durumda!',
                'color' => 'gray',
            ]);
        }

        // Kullanım kontrolü (tek kullanımlıksa)
        if ($qrCode->is_used) {
            return response()->json([
                'success' => false,
                'status' => 'used',
                'message' => 'Bu QR kod daha önce kullanılmış!',
                'used_at' => $qrCode->used_at->format('d.m.Y H:i'),
                'color' => 'yellow',
            ]);
        }

        // Geçerli QR kod
        return response()->json([
            'success' => true,
            'status' => 'valid',
            'message' => 'Geçerli QR Kod! Giriş izni verilebilir.',
            'qr_code_id' => $qrCode->id,
            'code' => $qrCode->code,
            'target_url' => $qrCode->target_url,
            'expires_at' => $qrCode->expires_at->format('d.m.Y H:i'),
            'scan_count' => $qrCode->scan_count,
            'color' => 'green',
        ]);
    }

    /**
     * Giriş izni ver
     */
    public function allowEntry(QrCode $qrCode, Request $request)
    {
        // Scanner kullanıcı bilgisi
        $scannerId = session('scanner_user.id');
        $scanner = ScannerUser::find($scannerId);

        if (!$scanner) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz işlem!',
            ], 401);
        }

        // QR kodu geçerli mi kontrol et
        if (!$qrCode->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'QR kod geçersiz veya süresi dolmuş!',
            ], 400);
        }

        // QR kodu kullanıldı olarak işaretle
        $qrCode->markAsUsed(
            $request->userAgent(),
            $request->ip()
        );

        // Scanner kullanıcının tarama sayısını artır
        $scanner->increment('scan_count');

        return response()->json([
            'success' => true,
            'message' => 'Giriş izni verildi! ✓',
            'scan_count' => $scanner->scan_count,
            'entry_time' => Carbon::now()->format('H:i:s'),
        ]);
    }

    /**
     * Giriş reddet
     */
    public function denyEntry(QrCode $qrCode, Request $request)
    {
        $reason = $request->input('reason', 'Belirtilmedi');

        // Scanner kullanıcı bilgisi
        $scannerId = session('scanner_user.id');
        $scanner = ScannerUser::find($scannerId);

        if (!$scanner) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz işlem!',
            ], 401);
        }

        // QR kodun scan sayısını artır (reddedildi bile olsa kayıt)
        $qrCode->incrementScan();

        // Log olarak kaydedilebilir (opsiyonel)
        // QrScanLog::create([...]);

        return response()->json([
            'success' => true,
            'message' => 'Giriş reddedildi!',
            'reason' => $reason,
            'denied_at' => Carbon::now()->format('H:i:s'),
        ]);
    }
}
