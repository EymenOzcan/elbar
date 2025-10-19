# EL-BAR Yönetim Sistemi - Sunucu Kurulum Kılavuzu

## 📋 Gereksinimler

### Sunucu Gereksinimleri:
- **PHP:** 8.2 veya üzeri
- **Composer:** 2.x
- **Node.js:** 18.x veya üzeri
- **MySQL/MariaDB:** 8.0 veya üzeri
- **Web Sunucu:** Apache veya Nginx

### PHP Eklentileri:
```bash
php-mbstring
php-xml
php-pdo
php-mysql
php-zip
php-gd
php-curl
php-fileinfo
php-bcmath
php-tokenizer
```

---

## 🚀 Kurulum Adımları

### 1. Projeyi Sunucuya Yükleme

#### A) Git ile (Önerilen):
```bash
cd /var/www
git clone [REPO_URL] el-bar
cd el-bar
```

#### B) FTP/SFTP ile:
- Tüm dosyaları `/var/www/el-bar` dizinine yükleyin
- `.git` klasörü isteğe bağlıdır

---

### 2. Dosya İzinlerini Ayarlama

```bash
cd /var/www/el-bar

# Storage ve cache dizinlerine yazma izni ver
chmod -R 775 storage bootstrap/cache

# Sunucu kullanıcısına sahiplik ver (Apache için www-data, Nginx için nginx)
chown -R www-data:www-data storage bootstrap/cache

# Tüm proje için kullanıcı grubunu ayarla
chown -R www-data:www-data /var/www/el-bar
```

---

### 3. Composer Bağımlılıklarını Yükleme

```bash
cd /var/www/el-bar

# Composer bağımlılıklarını yükle (production modu)
composer install --optimize-autoloader --no-dev

# VEYA development için:
composer install
```

---

### 4. Environment (.env) Dosyasını Yapılandırma

```bash
# .env.example dosyasını kopyala
cp .env.example .env

# .env dosyasını düzenle
nano .env
```

#### Gerekli Ayarlar:

```env
# Uygulama Ayarları
APP_NAME="EL-BAR"
APP_ENV=production
APP_KEY=                    # php artisan key:generate ile oluşturulacak
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Veritabanı Ayarları
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=el_bar_db
DB_USERNAME=db_username
DB_PASSWORD=db_password

# Oturum Ayarları
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache Ayarları
CACHE_DRIVER=file
QUEUE_CONNECTION=database

# Mail Ayarları (İsteğe bağlı)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Dosya Sistemi
FILESYSTEM_DISK=public
```

---

### 5. Uygulama Anahtarı Oluşturma

```bash
php artisan key:generate
```

---

### 6. Veritabanı Kurulumu

#### A) Veritabanı Oluşturma:
```sql
CREATE DATABASE el_bar_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'db_username'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON el_bar_db.* TO 'db_username'@'localhost';
FLUSH PRIVILEGES;
```

#### B) Migration'ları Çalıştırma:
```bash
php artisan migrate --force
```

#### C) Seed Verilerini Yükleme:
```bash
# Dil verilerini yükle
php artisan db:seed --class=LanguageSeeder

# Modül verilerini yükle
php artisan db:seed --class=ModuleSeeder

# VEYA tümünü birden:
php artisan db:seed --force
```

---

### 7. Storage Link Oluşturma

```bash
php artisan storage:link
```

Bu komut `public/storage` -> `storage/app/public` sembolik linkini oluşturur.

---

### 8. Cache ve Optimizasyon

```bash
# Config cache oluştur
php artisan config:cache

# Route cache oluştur
php artisan route:cache

# View cache oluştur
php artisan view:cache

# Autoload optimize et
composer dump-autoload --optimize
```

---

### 9. İlk Kullanıcıyı Oluşturma

#### A) Tinker ile:
```bash
php artisan tinker
```

Tinker içinde:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@elbar.com';
$user->password = Hash::make('admin123');
$user->save();

// Süper admin rolü ver
$user->roles()->attach(1); // veya uygun role_id
exit
```

#### B) Manuel olarak database'e ekleyerek:
```sql
INSERT INTO users (name, email, password, created_at, updated_at)
VALUES ('Admin', 'admin@elbar.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Role atama (roles tablosunda super-admin id'sini bulun)
INSERT INTO role_user (user_id, role_id) VALUES (1, 1);
```

**Not:** Yukarıdaki şifre hash'i `password` kelimesidir. Mutlaka değiştirin!

---

## 🌐 Web Sunucu Konfigürasyonu

### Apache (.htaccess zaten mevcut)

Virtual Host örneği:
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/el-bar/public

    <Directory /var/www/el-bar/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/el-bar-error.log
    CustomLog ${APACHE_LOG_DIR}/el-bar-access.log combined
</VirtualHost>
```

Siteyi etkinleştir:
```bash
sudo a2ensite el-bar.conf
sudo systemctl reload apache2
```

---

### Nginx

Nginx config örneği:
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/el-bar/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Siteyi etkinleştir:
```bash
sudo ln -s /etc/nginx/sites-available/el-bar /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 🔒 SSL Sertifikası (Let's Encrypt)

```bash
# Certbot kur
sudo apt install certbot python3-certbot-apache  # Apache için
# VEYA
sudo apt install certbot python3-certbot-nginx   # Nginx için

# SSL sertifikası al
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com
# VEYA
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

---

## 📂 Dizin Yapısı

```
/var/www/el-bar/
├── app/                    # Uygulama mantığı
├── bootstrap/              # Framework başlatma
├── config/                 # Yapılandırma dosyaları
├── database/              # Migration ve seeder'lar
├── public/                # Web root (DocumentRoot burası olmalı!)
│   ├── index.php         # Giriş noktası
│   ├── storage/          # Public storage linki
│   └── images/           # Statik görseller
├── resources/             # Views, CSS, JS
├── routes/                # Route tanımları
├── storage/               # Yüklenen dosyalar, cache, logs
│   ├── app/
│   │   └── public/       # Public erişilebilir dosyalar
│   ├── framework/
│   └── logs/             # Log dosyaları
├── .env                   # Environment ayarları (GÜVENLİ TUTUN!)
└── composer.json          # PHP bağımlılıkları
```

---

## ✅ Kurulum Sonrası Kontroller

### 1. Sağlık Kontrolü:
```bash
php artisan about
```

### 2. Veritabanı Bağlantısı:
```bash
php artisan db:show
```

### 3. Log Dosyalarını Kontrol Et:
```bash
tail -f storage/logs/laravel.log
```

### 4. İzinleri Kontrol Et:
```bash
ls -la storage/
ls -la bootstrap/cache/
```

### 5. Web'den Test Et:
- Ana sayfa: `https://yourdomain.com`
- Admin girişi: `https://yourdomain.com/login`
- Görsel şov: `https://yourdomain.com/gorsel-show`

---

## 🔧 Güncelleme (Update) Adımları

Proje güncellendiğinde:

```bash
cd /var/www/el-bar

# 1. Git'ten son değişiklikleri çek
git pull origin main

# 2. Composer bağımlılıklarını güncelle
composer install --optimize-autoloader --no-dev

# 3. Migration'ları çalıştır
php artisan migrate --force

# 4. Cache'leri temizle ve yeniden oluştur
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Storage linkini kontrol et
php artisan storage:link

# 6. İzinleri kontrol et
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🐛 Sorun Giderme

### 1. "500 Internal Server Error"
```bash
# Log'lara bak
tail -f storage/logs/laravel.log

# Debug modunu geçici olarak aç (.env)
APP_DEBUG=true

# Cache'leri temizle
php artisan cache:clear
php artisan config:clear
```

### 2. "Permission Denied" Hataları
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 3. "Class not found" Hataları
```bash
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
```

### 4. Resimler Görünmüyor
```bash
# Storage linkini yeniden oluştur
php artisan storage:link

# İzinleri kontrol et
chmod -R 775 storage/app/public
```

### 5. Database Connection Hatası
```bash
# .env dosyasını kontrol et
cat .env | grep DB_

# MySQL bağlantısını test et
php artisan db:show
```

---

## 📊 Cronjob Ayarları (İsteğe Bağlı)

Laravel scheduler'ı kullanıyorsanız:

```bash
crontab -e
```

Ekle:
```cron
* * * * * cd /var/www/el-bar && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔐 Güvenlik Önerileri

1. **`.env` dosyasını güvenli tut:**
   ```bash
   chmod 600 .env
   ```

2. **Production'da debug'ı kapat:**
   ```env
   APP_DEBUG=false
   ```

3. **Güçlü APP_KEY kullan:**
   ```bash
   php artisan key:generate
   ```

4. **Gereksiz dosyaları sil:**
   ```bash
   rm -rf .git tests
   ```

5. **Firewall kuralları ayarla:**
   ```bash
   sudo ufw allow 80/tcp
   sudo ufw allow 443/tcp
   sudo ufw enable
   ```

6. **Düzenli yedekleme:**
   - Veritabanı yedeği (günlük)
   - `storage/app/public` klasörü yedeği
   - `.env` dosyası yedeği

---

## 📞 Destek

Sorun yaşarsanız:
1. `storage/logs/laravel.log` dosyasını kontrol edin
2. `php artisan about` çıktısını inceleyin
3. Sunucu log'larını kontrol edin (`/var/log/apache2/` veya `/var/log/nginx/`)

---

## 📝 Önemli Notlar

- **İlk kurulumda mutlaka güçlü bir admin şifresi belirleyin!**
- **`.env` dosyasını asla git'e yüklemeyin**
- **Production'da `APP_DEBUG=false` olmalı**
- **Düzenli yedekleme yapın**
- **SSL sertifikası kullanın (Let's Encrypt ücretsiz)**

---

## ✨ Kurulum Tamamlandı!

Başarılı kurulum sonrası:
- Admin paneline giriş yapabilirsiniz: `https://yourdomain.com/login`
- Modül yönetiminden aktif modülü seçin: `https://yourdomain.com/admin/modules`
- Sabit sayfaları oluşturun: `https://yourdomain.com/admin/static-pages`

**Başarılar dileriz! 🎉**
