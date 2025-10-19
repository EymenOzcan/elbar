<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Benzersiz QR kodu
            $table->string('target_url'); // QR'ın yönlendireceği URL
            $table->string('qr_image_path')->nullable(); // QR görsel yolu
            $table->timestamp('expires_at'); // Geçerlilik süresi (2 dakika)
            $table->boolean('is_used')->default(false); // Kullanıldı mı?
            $table->timestamp('used_at')->nullable(); // Kullanım zamanı
            $table->string('user_agent')->nullable(); // Tarayıcı bilgisi
            $table->string('ip_address')->nullable(); // IP adresi
            $table->integer('scan_count')->default(0); // Kaç kez tarandı
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // İndeksler
            $table->index('code');
            $table->index('expires_at');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('qr_codes');
    }
};