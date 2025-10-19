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
        Schema::table('social_media_follows', function (Blueprint $table) {
            // Önce foreign key constraint'i kaldır
            $table->dropForeign(['approved_by']);
            // Sonra kolonları kaldır
            $table->dropColumn(['status', 'approved_at', 'approved_by']);
            // Kullanıcı bilgilerini de kaldır (artık form yok)
            $table->dropColumn(['user_name', 'user_social_username']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_media_follows', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('user_name')->nullable();
            $table->string('user_social_username')->nullable();
        });
    }
};
