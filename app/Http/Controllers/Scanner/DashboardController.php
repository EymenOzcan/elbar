<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Scanner Dashboard
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

        // Bugünkü tarama sayısı (eğer scan tablosu varsa)
        $todayScans = 0;
        try {
            if (class_exists('\App\Models\Scan')) {
                $todayScans = \App\Models\Scan::where('scanner_user_id', $user->id)
                    ->whereDate('created_at', today())
                    ->count();
            }
        } catch (\Exception $e) {
            // Scan tablosu yoksa 0 olarak kalır
        }

        return view('scanner.dashboard', compact('user', 'todayScans'));
    }
}