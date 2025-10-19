<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // kategori ikonu
            $table->string('image')->nullable(); // kategori görseli
            $table->string('color')->nullable(); // tema rengi
            $table->integer('parent_id')->nullable(); // alt kategoriler için
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_menu')->default(true);
            $table->boolean('show_in_home')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Kategori çevirileri
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();
            
            $table->unique(['category_id', 'language_id']);
        });

        // Sayfa-Kategori ilişki tablosu (çoka çok)
        Schema::create('page_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['page_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_categories');
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('categories');
    }
};