<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QrSystemController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * QR kodları listele
     */
    public function index(Request $request)
    {
        $query = QrCode::query()->orderBy('created_at', 'desc');

        // Filtreleme
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->valid();
                    break;
                case 'expired':
                    $query->expired();
                    break;
                case 'used':
                    $query->where('is_used', true);
                    break;
            }
        }

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('target_url', 'like', "%{$search}%");
            });
        }

        $qrCodes = $query->paginate(20);

        // İstatistikler
        $stats = [
            'total' => QrCode::count(),
            'active' => QrCode::valid()->count(),
            'expired' => QrCode::expired()->count(),
            'used' => QrCode::where('is_used', true)->count(),
            'total_scans' => QrCode::sum('scan_count'),
        ];

        return view('admin.qr-system.index', compact('qrCodes', 'stats'));
    }

    /**
     * Yeni QR kod oluşturma formu
     */
    public function create()
    {
        return view('admin.qr-system.create');
    }

    /**
     * Yeni QR kod kaydet
     */
    public function store(Request $request)
    {
        $request->validate([
            'target_url' => 'required|url',
        ]);

        try {
            // Logo yolunu belirle (public klasöründe olmalı)
            $logoPath = public_path('images/el-bar-logo.png');
            
            // Logo yoksa null gönder
            if (!file_exists($logoPath)) {
                \Log::warning('Logo dosyası bulunamadı: ' . $logoPath);
                $logoPath = null;
            }

            $qrCode = $this->qrCodeService->generate(
                $request->target_url,
                $logoPath ? 'images/el-bar-logo.png' : null
            );

            return redirect()
                ->route('admin.qr-system.show', $qrCode)
                ->with('success', 'QR kod başarıyla oluşturuldu!');

        } catch (\Exception $e) {
            \Log::error('QR kod oluşturma hatası: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'QR kod oluşturulurken hata: ' . $e->getMessage());
        }
    }

    /**
     * QR kod detayları
     */
    public function show(QrCode $qrCode)
    {
        return view('admin.qr-system.show', compact('qrCode'));
    }

    /**
     * QR kodu sil
     */
    public function destroy(QrCode $qrCode)
    {
        try {
            // Görseli sil
            if ($qrCode->qr_image_path) {
                \Storage::disk('public')->delete($qrCode->qr_image_path);
            }

            $qrCode->delete();

            return redirect()
                ->route('admin.qr-system.index')
                ->with('success', 'QR kod başarıyla silindi!');

        } catch (\Exception $e) {
            return back()->with('error', 'Silme işlemi başarısız: ' . $e->getMessage());
        }
    }

    /**
     * Toplu silme
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:qr_codes,id',
        ]);

        try {
            $qrCodes = QrCode::whereIn('id', $request->ids)->get();

            foreach ($qrCodes as $qrCode) {
                if ($qrCode->qr_image_path) {
                    \Storage::disk('public')->delete($qrCode->qr_image_path);
                }
                $qrCode->delete();
            }

            return back()->with('success', count($request->ids) . ' QR kod silindi!');

        } catch (\Exception $e) {
            return back()->with('error', 'Toplu silme başarısız: ' . $e->getMessage());
        }
    }

    /**
     * Süresi dolmuş QR kodları temizle
     */
    public function cleanExpired()
    {
        try {
            $count = $this->qrCodeService->cleanExpiredQrCodes();

            return back()->with('success', "{$count} adet süresi dolmuş QR kod temizlendi!");

        } catch (\Exception $e) {
            return back()->with('error', 'Temizleme başarısız: ' . $e->getMessage());
        }
    }
}