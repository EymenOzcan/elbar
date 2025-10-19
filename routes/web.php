<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Personnel\DashboardController as PersonnelDashboardController;

// Personel Routes
Route::middleware(['auth', 'role:personnel'])->prefix('personnel')->name('personnel.')->group(function () {
    Route::get('/dashboard', [PersonnelDashboardController::class, 'index'])->name('dashboard');
    Route::get('/takima', [PersonnelDashboardController::class, 'index'])->name('team.show');
    Route::post('/team/leave', [PersonnelDashboardController::class, 'leaveTeam'])->name('team.leave');
});

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SecretWallController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Public Visual Show (Görsel Show) - Login gerektirmez
Route::get('/gorsel-show', [App\Http\Controllers\VisualShowPublicController::class, 'index'])->name('visual-show.public');

// Public Personel Social Media - QR ile erişim (Login gerektirmez)
Route::get('/personel/{qrCode}', [App\Http\Controllers\PersonelSocialMediaController::class, 'index'])->name('personel.social-media');
Route::post('/personel/{qrCode}/track', [App\Http\Controllers\PersonelSocialMediaController::class, 'trackFollow'])->name('personel.track-follow');

// Public Secret Wall (Gizli Duvar) - Herkes kayıt olabilir
Route::get('/gizli-duvar', [App\Http\Controllers\SecretWallPublicController::class, 'index'])->name('secret-wall.public');
Route::post('/gizli-duvar', [App\Http\Controllers\SecretWallPublicController::class, 'store'])->name('secret-wall.public.store');

// Public QR Code Generator - Herkes QR oluşturabilir
Route::get('/qr-olustur', [App\Http\Controllers\QrPublicController::class, 'index'])->name('qr.public');
Route::post('/qr-olustur', [App\Http\Controllers\QrPublicController::class, 'generate'])->name('qr.public.generate');

// QR Redirect Route (Admin QR System için)
Route::get('/qr/{code}', [App\Http\Controllers\QrRedirectController::class, 'redirect'])->name('qr.redirect');

// Normal authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes (super-admin ve admin rolleri erişebilir)
Route::middleware(['auth', 'role:super-admin|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management Routes
    Route::resource('users', UserController::class);
    
    // Role Management Routes
    Route::resource('roles', RoleController::class);
    
    // Category Management Routes
    Route::resource('categories', CategoryController::class);
    
    // Page Management Routes
    Route::resource('pages', PageController::class);
    
    // Gallery Management Routes
    Route::resource('galleries', GalleryController::class);
    Route::post('galleries/{gallery}/upload', [GalleryController::class, 'upload'])->name('galleries.upload');
    Route::delete('galleries/media/{media}', [GalleryController::class, 'deleteMedia'])->name('galleries.media.destroy');

    // Static Pages Routes
    Route::resource('static-pages', App\Http\Controllers\Admin\StaticPageController::class);
    
    // Secret Wall Routes
    Route::prefix('secret-wall')->name('secret-wall.')->group(function () {
        Route::get('/', [SecretWallController::class, 'index'])->name('index');
        Route::get('/statistics', [SecretWallController::class, 'statistics'])->name('statistics');
        Route::get('/create', [SecretWallController::class, 'create'])->name('create');
        Route::post('/', [SecretWallController::class, 'store'])->name('store');
        Route::get('/{secretWall}', [SecretWallController::class, 'show'])->name('show');
        Route::get('/{secretWall}/edit', [SecretWallController::class, 'edit'])->name('edit');
        Route::put('/{secretWall}', [SecretWallController::class, 'update'])->name('update');
        Route::delete('/{secretWall}', [SecretWallController::class, 'destroy'])->name('destroy');
        Route::post('/{entry}/approve', [SecretWallController::class, 'approve'])->name('approve');
        Route::delete('/{entry}/reject', [SecretWallController::class, 'reject'])->name('reject');
        Route::post('/{entry}/restore', [SecretWallController::class, 'restore'])->name('restore');
        Route::post('/bulk/approve', [SecretWallController::class, 'bulkApprove'])->name('bulk-approve');
        Route::post('/bulk/delete', [SecretWallController::class, 'bulkDelete'])->name('bulk-delete');
    });

    // QR System Routes
    Route::prefix('qr-system')->name('qr-system.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\QrSystemController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\QrSystemController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\QrSystemController::class, 'store'])->name('store');
        Route::get('/{qrCode}', [App\Http\Controllers\Admin\QrSystemController::class, 'show'])->name('show');
        Route::delete('/{qrCode}', [App\Http\Controllers\Admin\QrSystemController::class, 'destroy'])->name('destroy');
        Route::post('/clean-expired', [App\Http\Controllers\Admin\QrSystemController::class, 'cleanExpired'])->name('clean-expired');
    });

    // Scanner Users Routes
    Route::resource('scanner-users', App\Http\Controllers\Admin\ScannerUserController::class);
    Route::post('scanner-users/{scannerUser}/toggle-status', [App\Http\Controllers\Admin\ScannerUserController::class, 'toggleStatus'])->name('scanner-users.toggle-status');

    // Media Settings Routes
    Route::get('/media-settings', [App\Http\Controllers\Admin\MediaSettingController::class, 'index'])->name('media-settings.index');
    Route::post('/media-settings', [App\Http\Controllers\Admin\MediaSettingController::class, 'update'])->name('media-settings.update');
    Route::post('/media-settings/test-connection', [App\Http\Controllers\Admin\MediaSettingController::class, 'testConnection'])->name('media-settings.test-connection');

    // Visual Show Routes (Admin)
    Route::resource('visual-show', App\Http\Controllers\Admin\VisualShowController::class);

    // Personel Routes (Admin)
    Route::resource('personel', App\Http\Controllers\Admin\PersonelController::class);
    Route::get('/personel-statistics', [App\Http\Controllers\Admin\PersonelController::class, 'statistics'])->name('personel.statistics');

    // Company Social Media Settings
    Route::get('/company-social-media', [App\Http\Controllers\Admin\CompanySocialMediaController::class, 'index'])->name('company-social-media.index');
    Route::put('/company-social-media', [App\Http\Controllers\Admin\CompanySocialMediaController::class, 'update'])->name('company-social-media.update');

    // Module Management Routes
    Route::get('/modules', [App\Http\Controllers\Admin\ModuleController::class, 'index'])->name('modules.index');
    Route::post('/modules/{module}/toggle-status', [App\Http\Controllers\Admin\ModuleController::class, 'toggleStatus'])->name('modules.toggle-status');

    // Team Management Routes
    Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);
    Route::get('teams/search-personels', [App\Http\Controllers\Admin\TeamController::class, 'searchPersonels'])->name('teams.search-personels');
    Route::post('teams/{team}/personels', [App\Http\Controllers\Admin\TeamController::class, 'addPersonel'])->name('teams.add-personel');
    Route::delete('teams/{team}/personels/{teamPersonel}', [App\Http\Controllers\Admin\TeamController::class, 'removePersonel'])->name('teams.remove-personel');
    Route::post('teams/{team}/reorder-personels', [App\Http\Controllers\Admin\TeamController::class, 'reorderPersonels'])->name('teams.reorder-personels');
});

// Grup Lideri Routes
Route::middleware(['auth', 'role:group-leader'])->prefix('grup-lideri')->name('group-leader.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\GroupLeader\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('teams', App\Http\Controllers\GroupLeader\TeamController::class);
    Route::delete('teams/{team}/personels/{teamPersonel}', [App\Http\Controllers\GroupLeader\TeamController::class, 'removePersonel'])->name('teams.remove-personel');
});

// Takım Lideri Routes
Route::middleware(['auth', 'role:team-leader'])->prefix('takim-lideri')->name('team-leader.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\TeamLeader\DashboardController::class, 'index'])->name('dashboard');
    
    // Personel yönetimi
    Route::get('/personel', [App\Http\Controllers\TeamLeader\PersonelController::class, 'index'])->name('personel.index');
    Route::get('/personel/search', [App\Http\Controllers\TeamLeader\PersonelController::class, 'search'])->name('personel.search');
    
    // Takımın personel yönetimi
    Route::prefix('teams/{team}/personels')->name('team-personels.')->group(function () {
        Route::post('/', [App\Http\Controllers\TeamLeader\PersonelController::class, 'store'])->name('store');
        Route::delete('/{teamPersonel}', [App\Http\Controllers\TeamLeader\PersonelController::class, 'destroy'])->name('destroy');
    });
});

// Personel Routes
Route::middleware(['auth', 'role:personnel'])->prefix('personnel')->name('personnel.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Personnel\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/takima', [App\Http\Controllers\Personnel\DashboardController::class, 'index'])->name('team.show');
});

// Scanner Routes (Etkinlik Görevlileri)
Route::prefix('etkinlik-gorevlisi')->name('scanner.')->group(function () {
    Route::get('/giris', [App\Http\Controllers\Scanner\AuthController::class, 'showLogin'])->name('login');
    Route::post('/giris', [App\Http\Controllers\Scanner\AuthController::class, 'login'])->name('login.post');

    Route::middleware('scanner.auth')->group(function () {
        Route::get('/panel', [App\Http\Controllers\Scanner\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/gecmis', [App\Http\Controllers\Scanner\HistoryController::class, 'index'])->name('history');
        Route::get('/qr-tara', [App\Http\Controllers\Scanner\ScanController::class, 'index'])->name('scan');

        // QR Kod Doğrulama
        Route::post('/qr-dogrula', [App\Http\Controllers\Scanner\ScanController::class, 'verify'])->name('qr.verify');

        // Giriş İzni Ver/Reddet
        Route::post('/giris-izni-ver/{qrCode}', [App\Http\Controllers\Scanner\ScanController::class, 'allowEntry'])->name('entry.allow');
        Route::post('/giris-reddet/{qrCode}', [App\Http\Controllers\Scanner\ScanController::class, 'denyEntry'])->name('entry.deny');

        Route::post('/cikis', [App\Http\Controllers\Scanner\AuthController::class, 'logout'])->name('logout');
    });
});

require __DIR__.'/auth.php';