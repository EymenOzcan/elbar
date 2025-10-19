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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('location'); // header, footer, sidebar
            $table->integer('parent_id')->nullable();
            $table->string('type')->default('page'); // page, link, category
            $table->string('url')->nullable();
            $table->foreignId('page_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('target')->default('_self');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Menü çevirileri
        Schema::create('menu_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->timestamps();
            
            $table->unique(['menu_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::dropIfExists('menu_translations');
        Schema::dropIfExists('menus');
    }
};
