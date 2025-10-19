<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScannerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ScannerUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scannerUsers = ScannerUser::latest()->paginate(15);

        // İstatistikler
        $stats = [
            'total' => ScannerUser::count(),
            'active' => ScannerUser::where('is_active', true)->count(),
            'inactive' => ScannerUser::where('is_active', false)->count(),
            'total_scans' => ScannerUser::sum('scan_count'),
        ];

        return view('admin.scanner-users.index', compact('scannerUsers', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.scanner-users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:scanner_users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['password'] = Hash::make($validated['password']); // Manuel hash

        ScannerUser::create($validated);

        return redirect()
            ->route('admin.scanner-users.index')
            ->with('success', 'Scanner kullanıcısı başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ScannerUser $scannerUser)
    {
        return view('admin.scanner-users.show', compact('scannerUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScannerUser $scannerUser)
    {
        return view('admin.scanner-users.edit', compact('scannerUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ScannerUser $scannerUser)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:scanner_users,username,' . $scannerUser->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Eğer şifre girilmemişse, güncelleme verilerinden çıkar
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $scannerUser->update($validated);

        return redirect()
            ->route('admin.scanner-users.index')
            ->with('success', 'Scanner kullanıcısı başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScannerUser $scannerUser)
    {
        $scannerUser->delete();

        return redirect()
            ->route('admin.scanner-users.index')
            ->with('success', 'Scanner kullanıcısı başarıyla silindi.');
    }
}