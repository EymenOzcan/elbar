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
            $table->string('user_name')->nullable()->after('personel_id'); // Kullanıcının adı soyadı
            $table->string('user_social_username')->nullable()->after('user_name'); // Kullanıcının o platformdaki kullanıcı adı
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_media_follows', function (Blueprint $table) {
            $table->dropColumn(['user_name', 'user_social_username']);
        });
    }
};
