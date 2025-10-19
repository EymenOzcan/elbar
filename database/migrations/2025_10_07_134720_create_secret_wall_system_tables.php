<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Sır Duvarı Kayıtları Tablosu
        Schema::create('secret_wall_entries', function (Blueprint $table) {
            $table->id();
            
            // Kişisel Bilgiler
            $table->string('isimsoyisim', 255);
            $table->longText('resim_base64')->nullable(); // Base64 encoded image
            
            // Sosyal Medya Linkleri
            $table->string('facebook_link', 500)->nullable();
            $table->string('instagram_link', 500)->nullable();
            $table->string('linkedin_link', 500)->nullable();
            $table->string('tiktok_link', 500)->nullable();
            $table->string('whatsapp_link', 500)->nullable();
            $table->string('x_link', 500)->nullable(); // Twitter/X
            $table->string('youtube_link', 500)->nullable();
            
            // Durum ve Onay
            $table->boolean('is_active')->default(false); // Admin onayı
            $table->timestamp('approved_at')->nullable(); // Onay tarihi
            $table->unsignedBigInteger('approved_by')->nullable(); // Onaylayan admin ID
            
            // Güvenlik ve İstatistik
            $table->string('ip_address', 45)->nullable(); // IPv6 desteği için 45 karakter
            $table->text('user_agent')->nullable();
            $table->string('session_id', 100)->nullable();
            $table->integer('view_count')->default(0); // Görüntülenme sayısı
            
            // Zaman Damgaları
            $table->timestamps();
            $table->softDeletes(); // Soft delete desteği
            
            // İndeksler
            $table->index('is_active');
            $table->index('created_at');
            $table->index('approved_at');
            $table->index('ip_address');
            
            // Foreign Key
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('secret_wall_entries');
    }
};