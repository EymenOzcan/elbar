<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up()
    {
        // Temp klasörlerini oluştur
        Storage::makeDirectory('temp');
        Storage::makeDirectory('temp/uploads');
        Storage::makeDirectory('temp/chunks');
    }

    public function down()
    {
        // Klasörleri sil
        Storage::deleteDirectory('temp');
    }
};