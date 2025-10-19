<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_type')->unique(); // contact, about, privacy, terms, faq
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('static_page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('static_page_id')->constrained('static_pages')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('custom_fields')->nullable(); // Dinamik alanlar için JSON
            $table->timestamps();

            $table->unique(['static_page_id', 'language_id']);
        });

        Schema::create('static_page_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('static_page_id')->constrained('static_pages')->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->json('working_hours')->nullable(); // {"monday": "09:00-18:00", ...}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('static_page_contacts');
        Schema::dropIfExists('static_page_translations');
        Schema::dropIfExists('static_pages');
    }
};
