# Ekip Yönetim Sistemi Kurulum Kılavuzu

## 📋 Genel Bakış

Bu rehber, mevcut Laravel uygulamasına Ekip Yönetim Sistemi'ni kurma adımlarını içermektedir.

## ✅ Kurulumu Tamamlanmış Dosyalar

### 1. **Veritabanı Migrasyonları**
```
database/migrations/2025_10_18_001_create_teams_table.php
database/migrations/2025_10_18_002_create_team_personels_table.php
```

İşlevler:
- `teams` tablosu: Ekipleri saklar (ad, açıklama, lider, durum)
- `team_personels` tablosu: Ekip-Personel ilişkisini saklar (sıralama desteği)

### 2. **Model Sınıfları**
```
app/Models/Team.php
app/Models/TeamPersonel.php
app/Models/Personel.php (güncellenmiş - teams ilişkisi eklendi)
```

### 3. **Controller**
```
app/Http/Controllers/Admin/TeamController.php
```

İşlevler:
- `index()` - Tüm ekipleri listele
- `create()` - Ekip oluştur sayfası
- `store()` - Ekip kaydet
- `show()` - Ekip detaylarını görüntüle
- `edit()` - Ekip düzenle sayfası
- `update()` - Ekip güncelle
- `destroy()` - Ekip sil
- `addPersonel()` - Personel ekle
- `removePersonel()` - Personel çıkar
- `reorderPersonels()` - Personel sırasını değiştir (API)

### 4. **Blade Görünümleri**
```
resources/views/admin/teams/index.blade.php     - Ekip listesi
resources/views/admin/teams/create.blade.php    - Yeni ekip oluştur
resources/views/admin/teams/show.blade.php      - Ekip detayları
resources/views/admin/teams/edit.blade.php      - Ekip düzenle
```

### 5. **Rotalar**
```
routes/web.php
```

Eklenen rotalar:
```php
Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);
Route::post('teams/{team}/personels', [TeamController::class, 'addPersonel'])->name('teams.add-personel');
Route::delete('teams/{team}/personels/{teamPersonel}', [TeamController::class, 'removePersonel'])->name('teams.remove-personel');
Route::post('teams/{team}/reorder-personels', [TeamController::class, 'reorderPersonels'])->name('teams.reorder-personels');
```

### 6. **Dashboard Menüsü**
```
resources/views/admin/dashboard.blade.php
```

Admin dashboard'a "Ekip Yönetimi" linki eklendi.

## 🚀 Kurulum Adımları

### 1. Migration'ları Çalıştır

```bash
php artisan migrate
```

Bu komut `teams` ve `team_personels` tablolarını oluşturacaktır.

### 2. Dosyaların Konumu Doğru mu?

Tüm dosyaların aşağıdaki yollar altında olduğundan emin olun:

✅ Migration dosyaları → `database/migrations/`
✅ Model dosyaları → `app/Models/`
✅ Controller → `app/Http/Controllers/Admin/`
✅ Blade dosyaları → `resources/views/admin/teams/`

### 3. Admin Panelde Kontrol Et

1. Admin paneline giriş yap
2. Dashboard'da "Ekip Yönetimi" kartını gör
3. Tıkla ve ekip listesine erişim sağla

## 📊 Veritabanı Şeması

### Teams Tablosu
```sql
CREATE TABLE teams (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) UNIQUE NOT NULL,
  description TEXT,
  leader_id BIGINT FOREIGN KEY -> users(id),
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  INDEX leader_id
);
```

### Team Personels Tablosu
```sql
CREATE TABLE team_personels (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  team_id BIGINT FOREIGN KEY -> teams(id) ON DELETE CASCADE,
  personel_id BIGINT FOREIGN KEY -> personels(id) ON DELETE CASCADE,
  order INT DEFAULT 0,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  UNIQUE (team_id, personel_id),
  INDEX (team_id, order)
);
```

## 🔍 Kullanım Örnekleri

### Ekip Oluştur (Controller'da)
```php
$team = Team::create([
    'name' => 'Pazarlama Ekibi',
    'description' => 'Pazarlama ve reklam faaliyetleri',
    'leader_id' => 1,
    'is_active' => true,
]);

// Personel ekle
foreach ($personelIds as $index => $personelId) {
    TeamPersonel::create([
        'team_id' => $team->id,
        'personel_id' => $personelId,
        'order' => $index,
    ]);
}
```

### İlişkileri Kullan (Model'de)
```php
// Ekipin tüm personellerini getir
$team->personels; // TeamPersonel collection
$team->personels->personel; // Personel objeleri

// Ekip liderini getir
$team->leader; // User objesi

// Personelin tüm ekiplerini getir
$personel->teams; // TeamPersonel collection
```

### Ekip Sorgula
```php
// Aktif ekipleri getir
$activeTeams = Team::where('is_active', true)->get();

// Belirli liderun ekiplerini getir
$leaderTeams = Team::where('leader_id', $userId)->get();

// Personeli içeren ekipler
$personelTeams = TeamPersonel::where('personel_id', $personelId)
    ->with('team')
    ->get();
```

## 🛣️ Rota Özeti

| Yöntem | Rota | İşlem |
|--------|------|-------|
| GET | `/admin/teams` | Ekip listesi |
| GET | `/admin/teams/create` | Ekip oluştur |
| POST | `/admin/teams` | Ekip kaydet |
| GET | `/admin/teams/{id}` | Ekip detayları |
| GET | `/admin/teams/{id}/edit` | Ekip düzenle |
| PUT | `/admin/teams/{id}` | Ekip güncelle |
| DELETE | `/admin/teams/{id}` | Ekip sil |
| POST | `/admin/teams/{id}/personels` | Personel ekle |
| DELETE | `/admin/teams/{id}/personels/{teamPersonelId}` | Personel çıkar |
| POST | `/admin/teams/{id}/reorder-personels` | Personel sırasını değiştir |

## 🔐 Yetki Kontrolü

Tüm ekip yönetimi rotaları `admin` middleware'i tarafından korunmaktadır:

```php
Route::middleware(['auth', 'role:super-admin|admin'])->prefix('admin')->group(...)
```

Sadece `super-admin` ve `admin` rolüne sahip kullanıcılar erişebilir.

## 🎯 Özellikler

✅ Admin tüm ekipleri görüntüleyebilir
✅ Admin ekip oluşturabilir/düzenleyebilir/silebilir
✅ Admin ekip liderine personel atayabilir
✅ Admin personel ekleyip çıkarabilir
✅ Ekip personelleri sıralanabilir
✅ Ekip lideri kendi ekibine personel ekleyebilir (ileride)
✅ İstatistikler ve filtreleme (ileride genişletilebilir)
✅ Tamamen responsive tasarım

## 📝 İleriye Dönük Geliştirmeler

- [ ] Ekip liderine kendi panel eklemek
- [ ] Toplu işlem özellikleri
- [ ] Ekip performans istatistikleri
- [ ] E-mail bildirimler
- [ ] Ekip detaylarında aktivite logu
- [ ] Personel transfer işlemler
- [ ] Ekip hiyerarşisi

## 🆘 Sorun Giderme

### Migration hatası
```bash
# Migrate'i rollback et
php artisan migrate:rollback

# Veya spesifik bir step
php artisan migrate:rollback --step=2

# Tekrar çalıştır
php artisan migrate
```

### Route not found
1. Cache'i temizle: `php artisan route:clear`
2. Config cache'i temizle: `php artisan config:clear`
3. Composer autoload: `composer dump-autoload`

### Permission denied
1. Kullanıcının `admin` veya `super-admin` rolü olduğunu kontrol et
2. Middleware kontrolü: `auth`, `role` middleware'lerinin doğru olduğunu kontrol et

## 📞 Destek

Sorunlar veya öneriler için lütfen admin tarafından kontrol edin.

---
**Kurulum Tarihi:** 18 Ekim 2025
