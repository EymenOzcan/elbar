<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('qr_scanner_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('full_name');
            $table->boolean('is_active')->default(true);
            $table->integer('scan_count')->default(0); // Toplam tarama sayısı
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // QR Tarama Logları
        Schema::create('qr_scan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scanner_user_id')->constrained('qr_scanner_users')->onDelete('cascade');
            $table->foreignId('qr_code_id')->constrained('qr_codes')->onDelete('cascade');
            $table->boolean('is_valid'); // QR geçerli miydi?
            $table->string('status'); // 'valid', 'expired', 'invalid'
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qr_scan_logs');
        Schema::dropIfExists('qr_scanner_users');
    }
};