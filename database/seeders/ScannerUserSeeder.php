<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ScannerUser;
use Illuminate\Support\Facades\Hash;

class ScannerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScannerUser::create([
            'full_name' => 'Hasan Test',
            'username' => 'hasan',
            'password' => Hash::make('12345678'), // Şifre: 12345678
            'scan_count' => 0,
            'is_active' => true,
        ]);

        ScannerUser::create([
            'full_name' => 'Ali Yılmaz',
            'username' => 'ali',
            'password' => Hash::make('password'), // Şifre: password
            'scan_count' => 15,
            'is_active' => true,
        ]);

        ScannerUser::create([
            'full_name' => 'Ayşe Demir',
            'username' => 'ayse',
            'password' => Hash::make('password'), // Şifre: password
            'scan_count' => 0,
            'is_active' => false, // Pasif kullanıcı
        ]);
    }
}