<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QrCodeController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Yeni QR kod oluştur
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request)
    {
        // Validasyon
        $validator = Validator::make($request->all(), [
            'target_url' => 'required|url',
            'logo_path' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasyon hatası',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // QR kod oluştur
            $qrCode = $this->qrCodeService->generate(
                $request->target_url,
                $request->logo_path
            );

            return response()->json([
                'success' => true,
                'message' => 'QR kod başarıyla oluşturuldu',
                'data' => [
                    'code' => $qrCode->code,
                    'qr_url' => route('qr.redirect', ['code' => $qrCode->code]),
                    'qr_image' => asset('storage/' . $qrCode->qr_image_path),
                    'target_url' => $qrCode->target_url,
                    'expires_at' => $qrCode->expires_at->toIso8601String(),
                    'expires_in_seconds' => $qrCode->expires_at->diffInSeconds(now()),
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'QR kod oluşturulurken hata oluştu',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * QR kod durumunu kontrol et
     * 
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(string $code)
    {
        $qrCode = \App\Models\QrCode::where('code', $code)->first();

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'message' => 'QR kod bulunamadı',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'code' => $qrCode->code,
                'is_valid' => $qrCode->isValid(),
                'is_expired' => $qrCode->isExpired(),
                'is_used' => $qrCode->is_used,
                'scan_count' => $qrCode->scan_count,
                'expires_at' => $qrCode->expires_at->toIso8601String(),
                'remaining_seconds' => max(0, $qrCode->expires_at->diffInSeconds(now())),
            ],
        ]);
    }
}