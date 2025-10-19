<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QrCodeController;
use App\Http\Controllers\Api\PersonelController;
use App\Http\Controllers\Api\StaticPageController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SecretWallController;

// API v1 Routes
Route::prefix('v1')->group(function () {

    // QR API Routes
    Route::prefix('qr')->name('api.qr.')->group(function () {
        Route::post('/generate', [QrCodeController::class, 'generate'])->name('generate');
        Route::get('/check/{code}', [QrCodeController::class, 'check'])->name('check');
    });

    // Personel API Routes
    Route::prefix('personel')->name('api.personel.')->group(function () {
        Route::get('/', [PersonelController::class, 'index'])->name('index');
        Route::get('/{qrCode}', [PersonelController::class, 'show'])->name('show');
    });

    // Static Pages API Routes
    Route::prefix('static-pages')->name('api.static-pages.')->group(function () {
        Route::get('/', [StaticPageController::class, 'index'])->name('index');
        Route::get('/{type}', [StaticPageController::class, 'show'])->name('show');
    });

    // Galleries API Routes
    Route::prefix('galleries')->name('api.galleries.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::get('/{id}', [GalleryController::class, 'show'])->name('show');
    });

    // Modules API Routes
    Route::prefix('modules')->name('api.modules.')->group(function () {
        Route::get('/active', [ModuleController::class, 'active'])->name('active');
        Route::get('/', [ModuleController::class, 'index'])->name('index');
    });

    // Languages API Routes
    Route::prefix('languages')->name('api.languages.')->group(function () {
        Route::get('/', [LanguageController::class, 'index'])->name('index');
    });

    // Pages API Routes
    Route::prefix('pages')->name('api.pages.')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('index');
        Route::get('/{slug}', [PageController::class, 'show'])->name('show');
    });

    // Secret Wall API Routes
      Route::prefix('secret-wall')->name('api.secret-wall.')->group(function
   () {
          Route::get('/', [SecretWallController::class,
  'index'])->name('index'); // Onaylı kayıtları getir
          Route::post('/', [SecretWallController::class,
  'store'])->name('store'); // Yeni kayıt oluştur
          Route::get('/statistics', [SecretWallController::class,
  'statistics'])->name('statistics'); // İstatistikler
          Route::get('/{id}', [SecretWallController::class,
  'show'])->name('show'); // Tek kayıt detayı
      });



});
