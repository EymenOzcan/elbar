<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_social_media_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Örn: 'instagram_url', 'facebook_url'
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Default değerler ekle
        DB::table('company_social_media_settings')->insert([
            ['key' => 'instagram_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'facebook_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'tiktok_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'x_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'linkedin_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'youtube_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'whatsapp_number', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_social_media_settings');
    }
};
