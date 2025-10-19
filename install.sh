#!/bin/bash

# EL-BAR Yönetim Sistemi - Otomatik Kurulum Script'i
# Bu script'i root yetkisi ile çalıştırın: sudo bash install.sh

set -e  # Hata durumunda dur

echo "=================================="
echo "EL-BAR Kurulum Başlatılıyor..."
echo "=================================="

# Renkler
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Hata fonksiyonu
error() {
    echo -e "${RED}HATA: $1${NC}"
    exit 1
}

# Başarı fonksiyonu
success() {
    echo -e "${GREEN}✓ $1${NC}"
}

# Uyarı fonksiyonu
warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

# PHP versiyonunu kontrol et
echo ""
echo "1. PHP Versiyonu Kontrolü..."
PHP_VERSION=$(php -r "echo PHP_VERSION;" | cut -d. -f1,2)
if (( $(echo "$PHP_VERSION < 8.2" | bc -l) )); then
    error "PHP 8.2 veya üzeri gerekli. Mevcut versiyon: $PHP_VERSION"
else
    success "PHP Versiyonu: $PHP_VERSION"
fi

# Composer kontrolü
echo ""
echo "2. Composer Kontrolü..."
if ! command -v composer &> /dev/null; then
    error "Composer yüklü değil. Lütfen önce Composer'ı yükleyin."
else
    success "Composer yüklü"
fi

# Proje dizinine git
PROJECT_DIR=$(pwd)
echo ""
echo "3. Proje Dizini: $PROJECT_DIR"

# Bağımlılıkları yükle
echo ""
echo "4. Composer Bağımlılıkları Yükleniyor..."
composer install --optimize-autoloader --no-dev || error "Composer install başarısız"
success "Composer bağımlılıkları yüklendi"

# .env dosyasını oluştur
echo ""
echo "5. Environment Dosyası Oluşturuluyor..."
if [ ! -f .env ]; then
    cp .env.example .env || error ".env dosyası oluşturulamadı"
    success ".env dosyası oluşturuldu"
else
    warning ".env dosyası zaten mevcut, atlanıyor"
fi

# Uygulama anahtarı oluştur
echo ""
echo "6. Uygulama Anahtarı Oluşturuluyor..."
php artisan key:generate --force || error "Key generate başarısız"
success "Uygulama anahtarı oluşturuldu"

# Veritabanı bilgilerini al
echo ""
echo "7. Veritabanı Ayarları..."
read -p "Veritabanı adı [el_bar_db]: " DB_NAME
DB_NAME=${DB_NAME:-el_bar_db}

read -p "Veritabanı kullanıcı adı [root]: " DB_USER
DB_USER=${DB_USER:-root}

read -sp "Veritabanı şifresi: " DB_PASS
echo ""

# .env dosyasını güncelle
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env

success "Veritabanı ayarları .env dosyasına kaydedildi"

# Migration'ları çalıştır
echo ""
read -p "Migration'ları çalıştırmak istiyor musunuz? (y/n): " RUN_MIGRATE
if [ "$RUN_MIGRATE" = "y" ]; then
    echo "8. Migration'lar Çalıştırılıyor..."
    php artisan migrate --force || error "Migration başarısız"
    success "Migration'lar tamamlandı"

    # Seed verilerini yükle
    echo ""
    read -p "Başlangıç verilerini (seed) yüklemek istiyor musunuz? (y/n): " RUN_SEED
    if [ "$RUN_SEED" = "y" ]; then
        echo "9. Seed Verileri Yükleniyor..."
        php artisan db:seed --force || error "Seed başarısız"
        success "Seed verileri yüklendi"
    fi
fi

# Storage link oluştur
echo ""
echo "10. Storage Link Oluşturuluyor..."
php artisan storage:link || warning "Storage link zaten mevcut olabilir"
success "Storage link oluşturuldu"

# İzinleri ayarla
echo ""
echo "11. Dosya İzinleri Ayarlanıyor..."
chmod -R 775 storage bootstrap/cache || error "chmod başarısız"

# Web sunucu kullanıcısını belirle
if id "www-data" &>/dev/null; then
    WEB_USER="www-data"
elif id "nginx" &>/dev/null; then
    WEB_USER="nginx"
elif id "apache" &>/dev/null; then
    WEB_USER="apache"
else
    warning "Web sunucu kullanıcısı bulunamadı. Manuel olarak ayarlamanız gerekebilir."
    WEB_USER=$(whoami)
fi

chown -R $WEB_USER:$WEB_USER storage bootstrap/cache || warning "chown başarısız (sudo gerekebilir)"
success "İzinler ayarlandı (Kullanıcı: $WEB_USER)"

# Cache oluştur
echo ""
echo "12. Cache Oluşturuluyor..."
php artisan config:cache || error "Config cache başarısız"
php artisan route:cache || error "Route cache başarısız"
php artisan view:cache || error "View cache başarısız"
success "Cache dosyaları oluşturuldu"

# İlk kullanıcı oluşturma teklifi
echo ""
echo "=================================="
echo "Kurulum Tamamlandı! 🎉"
echo "=================================="
echo ""
echo "Sonraki Adımlar:"
echo "1. Web sunucunuzu yapılandırın (Apache/Nginx)"
echo "2. SSL sertifikası yükleyin (Let's Encrypt önerilir)"
echo "3. Admin kullanıcısı oluşturun:"
echo "   php artisan tinker"
echo "   Ardından kullanıcı oluşturma komutlarını çalıştırın"
echo ""
echo "Detaylı bilgi için KURULUM_DOKUMANI.md dosyasına bakın."
echo ""
echo "Proje Dizini: $PROJECT_DIR"
echo "Public Dizini: $PROJECT_DIR/public (DocumentRoot burası olmalı)"
echo ""

read -p "İlk admin kullanıcısını şimdi oluşturmak istiyor musunuz? (y/n): " CREATE_USER
if [ "$CREATE_USER" = "y" ]; then
    echo ""
    read -p "Admin Adı: " ADMIN_NAME
    read -p "Admin Email: " ADMIN_EMAIL
    read -sp "Admin Şifresi: " ADMIN_PASS
    echo ""

    php artisan tinker --execute="
        \$user = new App\Models\User();
        \$user->name = '$ADMIN_NAME';
        \$user->email = '$ADMIN_EMAIL';
        \$user->password = Hash::make('$ADMIN_PASS');
        \$user->save();
        echo 'Kullanıcı oluşturuldu! ID: ' . \$user->id;
    "

    success "Admin kullanıcısı oluşturuldu!"
    echo ""
    echo "Giriş Bilgileri:"
    echo "Email: $ADMIN_EMAIL"
    echo "Şifre: (girdiğiniz şifre)"
fi

echo ""
echo "=================================="
echo "Kurulum Başarılı! ✨"
echo "=================================="
