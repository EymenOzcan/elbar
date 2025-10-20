# El Bar - Docker & CI/CD Setup

Bu döküman Docker containerization ve GitHub Actions CI/CD setup'ı açıklar.

## Dosya Yapısı

```
docker/
├── nginx/
│   ├── nginx.conf          # Nginx ana konfigürasyonu
│   └── default.conf        # Laravel site konfigürasyonu
├── php/
│   ├── php.ini             # PHP ayarları
│   └── php-fpm.conf        # PHP-FPM konfigürasyonu
└── supervisor/
    └── supervisord.conf    # Supervisor (PHP-FPM, Nginx) yönetimi

.github/
└── workflows/
    └── build-and-push.yml  # GitHub Actions CI/CD pipeline

Dockerfile                  # Production Docker image
docker-compose.yml         # Local development ortamı
.dockerignore             # Docker build'den hariç tutulacak dosyalar
```

## GitHub Secrets Setup

Docker Hub'a push etmek için aşağıdaki secrets'i ayarlayın:

1. **DOCKER_USERNAME**: Docker Hub kullanıcı adı
2. **DOCKER_PASSWORD**: Docker Hub erişim token'ı

### Docker Hub Token Oluşturma

1. [Docker Hub](https://hub.docker.com) giriş yapın
2. **Account Settings** → **Security** → **New Access Token**
3. Token'ı kopyalayın

### GitHub Secrets Ekleme

1. Repository → **Settings** → **Secrets and variables** → **Actions**
2. **New repository secret** tıklayın
3. `DOCKER_USERNAME` ve `DOCKER_PASSWORD` ekleyin

## CI/CD Pipeline

### Trigger Olayları

- **Push to master/main**: Otomatik olarak image build ve push
- **Merged Pull Request**: PR merge edilirse otomatik build

### Pipeline Adımları

1. ✅ Kodu checkout et
2. ✅ Docker Buildx kur
3. ✅ Docker Hub'a login ol
4. ✅ Metadata çıkar (tag, label)
5. ✅ Image build ve push et (caching ile)

### Generated Tags

```
yourdockerhubusername/el-bar:latest
yourdockerhubusername/el-bar:build-abc123def
```

## Local Development

### Başlatma

```bash
# Ortam değişkenleri
cp .env.example .env
# Gerekli ayarları yapın (.env.docker'ı referans alın)

# Containers başlat
docker-compose up -d

# Database migrations
docker-compose exec app php artisan migrate --seed

# Yetkilendirme setup
docker-compose exec app bash create_roles.php
```

### Containers

| Service | Port | URL |
|---------|------|-----|
| Laravel App | 8000 | http://localhost:8000 |
| PHP-FPM | 9000 | 127.0.0.1:9000 |
| PostgreSQL | 5432 | localhost:5432 |
| Redis | 6379 | localhost:6379 |

### Useful Commands

```bash
# Logs görüntüle
docker-compose logs -f app

# Database console
docker-compose exec postgres psql -U laravel -d el_bar

# Artisan komut
docker-compose exec app php artisan tinker

# Container'a giriş
docker-compose exec app bash

# Durdur
docker-compose down

# Volume silme (data reset)
docker-compose down -v
```

## Production Deployment

### Image Pull ve Çalıştırma

```bash
# Login
docker login -u yourusername -p yourtoken

# Image pull
docker pull yourdockerhubusername/el-bar:latest

# Container run
docker run -d \
  --name el-bar \
  -p 80:80 \
  -p 443:443 \
  -e APP_KEY=base64:... \
  -e DB_HOST=your-db-host \
  -e DB_PASSWORD=your-db-pass \
  -v /path/to/storage:/app/storage \
  yourdockerhubusername/el-bar:latest
```

### Environment Variables (Production)

`.env.docker` dosyasını referans alıp tüm sensitive değerleri update edin:

- `APP_KEY`: `php artisan key:generate --show` ile üret
- `DB_PASSWORD`: Güçlü bir şifre belirleyin
- `REDIS_PASSWORD`: Redis için şifre
- `MAIL_*`: Email servis ayarları
- `AWS_*`: Dosya storage (S3, vb.)

### Health Check

Container'ın sağlığı şu endpoint'le kontrol edilir:

```
http://your-server/health
```

Dönen response: `healthy`

## Optimization Tips

### Build Performance

1. **Layer Caching**: `docker/` klasörü ve dependencies sık değişmediği için cache'ten load edilir
2. **Multi-stage Build**: Builder stage ile final image boyutu azaltılır
3. **Alpine Linux**: Küçük base image kullanımı (48MB vs 500MB+)

### Runtime Performance

1. **OPCache**: PHP bytecode caching aktif
2. **Gzip Compression**: Nginx'te aktif
3. **Static Asset Caching**: 1 yıl cache header'ı
4. **Connection Pooling**: PHP-FPM worker pool

## Troubleshooting

### Image build başarısız

```bash
docker build --no-cache -t yourdockerhubusername/el-bar:latest .
```

### Database bağlantı hatası

```bash
# Container'ı kontrol et
docker-compose ps

# Postgres logs
docker-compose logs postgres

# Network kontrol
docker network inspect el-bar_el-bar-network
```

### Permission denied errors

```bash
# Docker daemon'a izin ver (Linux'ta)
sudo usermod -aG docker $USER
newgrp docker
```

## Next Steps

- [ ] Docker Hub repository oluştur
- [ ] GitHub Secrets ekle (DOCKER_USERNAME, DOCKER_PASSWORD)
- [ ] Ilk push ile workflow'u test et
- [ ] Production sunucu setup'ı tamamla
- [ ] SSL/TLS sertifikası kur (Let's Encrypt, vb.)
- [ ] Database backups schedule'ı kur
- [ ] Monitoring (Prometheus, Grafana) setup et
- [ ] Log aggregation (ELK, Loki) kur

---

**Last Updated**: 2025-10-20  
**Laravel Version**: 12.x  
**PHP Version**: 8.2  
**PostgreSQL**: 16
