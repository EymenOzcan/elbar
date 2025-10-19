<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Galeri Tablosu
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'photo' veya 'video'
            $table->string('slug')->unique();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Galeri Çevirileri
        Schema::create('gallery_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->onDelete('cascade');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->unique(['gallery_id', 'language_id']);
        });

        // Medya Dosyaları (Resimler & Videolar)
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'image' veya 'video'
            $table->string('storage_type'); // 'local', 's3', 'cloudinary', 'custom'
            $table->string('file_path'); // Yerel yol veya tam URL
            $table->string('thumbnail')->nullable(); // Video için thumbnail
            $table->string('file_name');
            $table->integer('file_size')->nullable(); // bytes
            $table->string('mime_type')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('duration')->nullable(); // Video süresi (saniye)
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Medya Dosya Çevirileri
        Schema::create('media_file_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_file_id')->constrained()->onDelete('cascade');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('alt_text')->nullable(); // Resimler için alt text
            $table->timestamps();
            $table->unique(['media_file_id', 'language_id']);
        });

        // Galeri-Kategori İlişkisi
        Schema::create('gallery_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['gallery_id', 'category_id']);
        });

        // Medya Ayarları (Global Settings)
        Schema::create('media_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gallery_categories');
        Schema::dropIfExists('media_file_translations');
        Schema::dropIfExists('media_files');
        Schema::dropIfExists('gallery_translations');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('media_settings');
    }
};