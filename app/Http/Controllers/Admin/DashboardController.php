<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SecretWall;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        // İstatistikler
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'active_users' => User::whereHas('roles')->count(),
            'pending_secret_wall' => 0,
        ];

        // SecretWall modelini güvenli şekilde kontrol et
        try {
            if (class_exists(SecretWall::class)) {
                $stats['pending_secret_wall'] = SecretWall::where('is_active', false)
                    ->whereNull('deleted_at')
                    ->count();
            }
        } catch (\Exception $e) {
            // Tablo yoksa veya hata varsa 0 olarak devam et
            $stats['pending_secret_wall'] = 0;
        }

        return view('admin.dashboard', compact('stats'));
    }
}