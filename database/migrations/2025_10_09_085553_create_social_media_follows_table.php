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
        Schema::create('social_media_follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personel_id')->constrained('personels')->onDelete('cascade');
            $table->enum('platform', ['instagram', 'facebook', 'tiktok', 'x', 'linkedin', 'youtube', 'whatsapp']);
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            // Index for faster queries
            $table->index(['personel_id', 'platform', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_follows');
    }
};
