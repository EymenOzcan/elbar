<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personel_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personel_id')->constrained('personels')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->string('position')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['personel_id', 'language_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personel_translations');
    }
};
