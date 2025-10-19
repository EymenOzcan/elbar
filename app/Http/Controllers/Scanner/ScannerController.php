<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrCode;
use App\Models\QrScanLog;
use Illuminate\Support\Facades\Auth;

class ScannerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('scanner')->user();
        
        // Kullanıcının son taramalarını getir
        $recentScans = QrScanLog::where('scanner_user_id', $user->id)
            ->with('qrCode')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        return view('scanner.dashboard', compact('user', 'recentScans'));
    }

    public function scan(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = Auth::guard('scanner')->user();
        $qrCode = QrCode::where('code', $request->code)->first();

        if (!$qrCode) {
            // Log kaydet
            QrScanLog::create([
                'scanner_user_id' => $user->id,
                'qr_code_id' => null,
                'is_valid' => false,
                'status' => 'not_found',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'success' => false,
                'status' => 'not_found',
                'message' => 'QR kod bulunamadı!',
                'color' => 'red',
            ]);
        }

        // QR durumunu kontrol et
        if ($qrCode->isExpired()) {
            $status = 'expired';
            $message = 'QR kod süresi dolmuş!';
            $isValid = false;
            $color = 'orange';
        } elseif (!$qrCode->is_active) {
            $status = 'inactive';
            $message = 'QR kod aktif değil!';
            $isValid = false;
            $color = 'red';
        } else {
            $status = 'valid';
            $message = 'QR kod geçerli!';
            $isValid = true;
            $color = 'green';
            
            // Tarama sayısını artır
            $qrCode->incrementScan();
        }

        // Log kaydet
        QrScanLog::create([
            'scanner_user_id' => $user->id,
            'qr_code_id' => $qrCode->id,
            'is_valid' => $isValid,
            'status' => $status,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Kullanıcının tarama sayısını artır
        $user->incrementScanCount();

        return response()->json([
            'success' => true,
            'status' => $status,
            'is_valid' => $isValid,
            'message' => $message,
            'color' => $color,
            'qr_data' => [
                'code' => $qrCode->code,
                'target_url' => $qrCode->target_url,
                'expires_at' => $qrCode->expires_at->format('d.m.Y H:i'),
                'scan_count' => $qrCode->scan_count,
            ],
        ]);
    }

    public function history()
    {
        $user = Auth::guard('scanner')->user();
        
        $scans = QrScanLog::where('scanner_user_id', $user->id)
            ->with('qrCode')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('scanner.history', compact('user', 'scans'));
    }
}