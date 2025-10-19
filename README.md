# 🎯 EL-BAR Yönetim Sistemi

Modern ve kapsamlı etkinlik, içerik ve personel yönetim sistemi.

## 📌 Özellikler

### 🎨 İçerik Yönetimi
- **Kategoriler:** Hiyerarşik kategori yapısı
- **Sayfalar:** Çok dilli dinamik sayfa yönetimi
- **Sabit Sayfalar:** İletişim, Hakkımızda, Gizlilik vb. (CKEditor ile zengin metin)
- **Galeriler:** Resim galerisi yönetimi

### 👥 Personel Yönetimi
- Personel bilgileri (Ad, Soyad, Pozisyon, Açıklama)
- QR Kod ile personel tanıtımı
- Sosyal medya entegrasyonu
- Çok dilli pozisyon ve açıklama
- Takipçi istatistikleri

### 🎫 Etkinlik Modülleri
- **QR Kod Sistemi:** Etkinlik giriş kontrolü
- **Görsel Show:** Medya slayt gösterimi
- Modül bazlı aktif/pasif sistem

### 🌐 Çok Dil Desteği
- Tüm içerikler için dil desteği
- Türkçe, İngilizce ve daha fazlası
- Dil bazlı içerik yönetimi

### 🔐 Kullanıcı ve Yetki Yönetimi
- Rol tabanlı erişim kontrolü (Super Admin, Admin, Editor)
- Kullanıcı yönetimi
- Etkinlik görevlileri için özel panel

### 📊 İstatistikler ve Raporlama
- Personel takipçi istatistikleri
- Etkinlik giriş raporları
- Detaylı analiz panelleri

### 🎭 Etkileşim Özellikleri
- **Gizli Duvar:** Kullanıcı mesajları ve onay sistemi
- Sosyal medya entegrasyonu
- WhatsApp, Instagram, Facebook, Twitter, LinkedIn, YouTube

---

## 🚀 Hızlı Başlangıç

### Gereksinimler
- PHP 8.2+
- Composer
- MySQL/MariaDB 8.0+
- Node.js 18+ (opsiyonel)

### Otomatik Kurulum (Linux/Mac)
```bash
chmod +x install.sh
sudo bash install.sh
```

### Manuel Kurulum
Detaylı kurulum adımları için [KURULUM_DOKUMANI.md](KURULUM_DOKUMANI.md) dosyasına bakın.

```bash
# 1. Bağımlılıkları yükle
composer install

# 2. Environment dosyası oluştur
cp .env.example .env

# 3. Uygulama anahtarı oluştur
php artisan key:generate

# 4. Veritabanını yapılandır (.env dosyasını düzenle)
nano .env

# 5. Migration'ları çalıştır
php artisan migrate

# 6. Başlangıç verilerini yükle
php artisan db:seed

# 7. Storage link oluştur
php artisan storage:link

# 8. Geliştirme sunucusunu başlat
php artisan serve
```

---

## 📁 Proje Yapısı

```
el-bar/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/              # Admin panel controller'ları
│   │   └── Scanner/            # Etkinlik görevlisi controller'ları
│   ├── Models/                 # Eloquent modeller
│   └── ...
├── database/
│   ├── migrations/             # Veritabanı migration'ları
│   └── seeders/                # Başlangıç verileri
├── public/
│   ├── images/                 # Statik görseller
│   └── storage/                # Yüklenen dosyalar (link)
├── resources/
│   └── views/
│       ├── admin/              # Admin panel view'ları
│       ├── scanner/            # Etkinlik görevlisi view'ları
│       └── layouts/            # Layout dosyaları
├── routes/
│   └── web.php                 # Route tanımları
├── storage/
│   ├── app/public/             # Public dosyalar
│   └── logs/                   # Log dosyaları
├── .env.example                # Environment örnek dosyası
├── install.sh                  # Otomatik kurulum script'i
├── KURULUM_DOKUMANI.md        # Detaylı kurulum kılavuzu
└── README.md                   # Bu dosya
```

---

## 🔧 Yapılandırma

### Veritabanı
`.env` dosyasında veritabanı ayarlarını yapın:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=el_bar_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Dosya Sistemi
Public dosyalar için:
```env
FILESYSTEM_DISK=public
```

### Mail Ayarları
E-posta gönderimleri için (opsiyonel):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

---

## 👤 İlk Kullanıcı Oluşturma

### Tinker ile:
```bash
php artisan tinker
```

```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@elbar.com';
$user->password = Hash::make('admin123');
$user->save();
```

### Veya SQL ile:
```sql
INSERT INTO users (name, email, password, created_at, updated_at)
VALUES ('Admin', 'admin@elbar.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());
```
**Not:** Yukarıdaki şifre `password` kelimesidir.

---

## 📚 Kullanım

### Admin Paneli
```
http://yourdomain.com/admin
```

**Modüller:**
- **İçerikler:** Kategoriler, Sayfalar, Sabit Sayfalar, Galeriler
- **Takipçiler:** Gizli Duvar yönetimi
- **Etkinlikler:** QR Kodlar, Görsel Show
- **Yönetimler:** Kullanıcılar, Roller, Personel, Ayarlar

### Etkinlik Görevlisi Paneli
```
http://yourdomain.com/etkinlik-gorevlisi/giris
```

### Public Sayfalar
- **Görsel Show:** `http://yourdomain.com/gorsel-show`
- **Personel Profili:** `http://yourdomain.com/personel/{qr_code}`

---

## 🔄 Güncelleme

Projeyi güncellemek için:

```bash
# Git'ten çek
git pull origin main

# Bağımlılıkları güncelle
composer install --optimize-autoloader --no-dev

# Migration'ları çalıştır
php artisan migrate --force

# Cache'leri temizle
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache'leri yeniden oluştur
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🐛 Sorun Giderme

### Debug Modu
Geliştirme ortamında `.env` dosyasında:
```env
APP_DEBUG=true
```

### Log Dosyaları
```bash
tail -f storage/logs/laravel.log
```

### Cache Temizleme
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### İzin Sorunları
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 📖 API Dokümantasyonu

API dokümantasyonu için `API_DOCUMENTATION.md` dosyasına bakın. *(Yakında)*

---

## 🔒 Güvenlik

- Production ortamında `APP_DEBUG=false` olmalı
- Güçlü `APP_KEY` kullanın
- `.env` dosyasını asla paylaşmayın
- Düzenli güvenlik güncellemeleri yapın
- SSL sertifikası kullanın

Güvenlik açığı bildirmek için: security@yourdomain.com

---

## 📝 Lisans

Bu proje özel bir projedir. Kullanım hakları saklıdır.

---

## 👨‍💻 Geliştirici

**EL-BAR Development Team**

---

## 📞 Destek

- **Dokümantasyon:** [KURULUM_DOKUMANI.md](KURULUM_DOKUMANI.md)
- **E-posta:** support@yourdomain.com
- **Web:** https://yourdomain.com

---

## ✨ Özellikler (Detaylı)

### Modül Sistemi
Etkinlik modüllerini tek noktadan yönetin:
- Aynı anda sadece bir modül aktif olabilir
- Modüller: QR Kodlar, Görsel Show
- Önyüz ana panelde otomatik gösterim

### Sabit Sayfalar
- İletişim (İletişim bilgileri, harita, sosyal medya)
- Hakkımızda (Resim ve banner desteği)
- Gizlilik Politikası
- Kullanım Koşulları
- SSS (Sıkça Sorulan Sorular)
- CKEditor ile zengin metin editörü
- Çok dilli içerik desteği

### Personel Sistemi
- QR kod ile personel profili
- Sosyal medya takibi
- İstatistikler ve raporlar
- Çok dilli pozisyon/açıklama

### QR Kod Sistemi
- Etkinlik giriş kontrolü
- Süre sınırlı QR kodlar
- Görevli paneli
- Giriş geçmişi

---

**Başarılar Dileriz! 🎉**
