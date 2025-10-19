<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\ScannerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('scanner_user')) {
            return redirect()->route('scanner.dashboard');
        }

        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('scanner.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $scannerUser = ScannerUser::where('username', $request->username)->first();

        if (!$scannerUser) {
            return back()->withErrors(['username' => 'Kullanıcı bulunamadı.'])->onlyInput('username');
        }

        if (!Hash::check($request->password, $scannerUser->password)) {
            return back()->withErrors(['username' => 'Şifre yanlış.'])->onlyInput('username');
        }

        if (!$scannerUser->is_active) {
            return back()->withErrors(['username' => 'Hesabınız pasif durumda.']);
        }

        session(['scanner_user' => [
            'id' => $scannerUser->id,
            'username' => $scannerUser->username,
            'full_name' => $scannerUser->full_name,
        ]]);

        return redirect()->route('scanner.dashboard');
    }

    public function logout()
    {
        session()->forget('scanner_user');
        return redirect()->route('scanner.login');
    }
}