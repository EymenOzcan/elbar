<?php

namespace App\Services;

use App\Models\QrCode;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use chillerlan\QRCode\QRCode as QRCodeGenerator;
use chillerlan\QRCode\QROptions;

class QrCodeService
{
    public function generate(string $targetUrl, string $logoPath = null): QrCode
    {
        $code = $this->generateUniqueCode();
        $qrImagePath = $this->createQrImage($code);
        
        $qrCode = QrCode::create([
            'code' => $code,
            'target_url' => $targetUrl,
            'qr_image_path' => $qrImagePath,
            'expires_at' => Carbon::now()->addMinutes(2),
            'is_active' => true,
        ]);
        
        return $qrCode;
    }

    private function generateUniqueCode(): string
    {
        do {
            $code = Str::random(12);
        } while (QrCode::where('code', $code)->exists());
        
        return $code;
    }

    private function createQrImage(string $code): string
    {
        $qrUrl = route('qr.redirect', ['code' => $code]);
        
        // QR ayarları
        $options = new QROptions([
            'version'      => 5,
            'outputType'   => QRCodeGenerator::OUTPUT_IMAGE_PNG,
            'eccLevel'     => QRCodeGenerator::ECC_H,
            'scale'        => 10,
            'imageBase64'  => false,
        ]);
        
        // QR oluştur
        $qrcode = new QRCodeGenerator($options);
        $qrImageData = $qrcode->render($qrUrl);
        
        $filename = 'qr_' . $code . '.png';
        $path = 'qr-codes/' . $filename;
        
        Storage::disk('public')->put($path, $qrImageData);
        
        \Log::info('QR kod oluşturuldu: ' . $path);
        
        return $path;
    }

    public function validateAndRedirect(string $code, $request = null): array
    {
        $qrCode = QrCode::where('code', $code)->first();
        
        if (!$qrCode) {
            return ['success' => false, 'message' => 'QR kod bulunamadı.'];
        }
        
        if ($qrCode->isExpired()) {
            return ['success' => false, 'message' => 'QR kod süresi dolmuş.'];
        }
        
        if (!$qrCode->is_active) {
            return ['success' => false, 'message' => 'QR kod aktif değil.'];
        }
        
        if ($request) {
            $qrCode->markAsUsed($request->userAgent(), $request->ip());
        } else {
            $qrCode->incrementScan();
        }
        
        return ['success' => true, 'target_url' => $qrCode->target_url];
    }

    public function cleanExpiredQrCodes(): int
    {
        $expiredQrCodes = QrCode::expired()->get();
        
        foreach ($expiredQrCodes as $qrCode) {
            if ($qrCode->qr_image_path) {
                Storage::disk('public')->delete($qrCode->qr_image_path);
            }
            $qrCode->delete();
        }
        
        return $expiredQrCodes->count();
    }
}