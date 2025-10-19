<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Tarama geçmişi
     */
    public function index()
    {
        // Session'dan kullanıcı ID'sini al
        $userId = session('scanner_user.id');

        if (!$userId) {
            return redirect()->route('scanner.login');
        }

        // Kullanıcıyı veritabanından al
        $user = \App\Models\ScannerUser::find($userId);

        if (!$user) {
            session()->forget('scanner_user');
            return redirect()->route('scanner.login');
        }

        // Tarama geçmişi (eğer Scan modeli varsa)
        $scans = collect([]); // Boş collection
        
        try {
            if (class_exists('\App\Models\Scan')) {
                $scans = \App\Models\Scan::where('scanner_user_id', $user->id)
                    ->with('qrCode')
                    ->latest()
                    ->paginate(20);
            }
        } catch (\Exception $e) {
            // Scan tablosu yoksa boş collection
            $scans = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
        }

        return view('scanner.history', compact('user', 'scans'));
    }
}