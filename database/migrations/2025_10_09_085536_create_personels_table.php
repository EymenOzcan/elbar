<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->enum('employment_type', ['primli', 'kadrolu']); // Primli veya Kadrolu
            $table->string('position')->nullable(); // Pozisyon/Görev
            $table->text('qr_code')->unique(); // QR kod unique string
            $table->boolean('is_active')->default(true);

            // Sosyal Medya Kullanıcı Adları
            $table->string('instagram_username')->nullable();
            $table->string('facebook_username')->nullable();
            $table->string('tiktok_username')->nullable();
            $table->string('x_username')->nullable(); // Twitter/X
            $table->string('linkedin_username')->nullable();
            $table->string('youtube_username')->nullable();
            $table->string('whatsapp_number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personels');
    }
};
