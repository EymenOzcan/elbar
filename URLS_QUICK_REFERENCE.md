# 🌐 Tüm Sistem URL'leri - Hızlı Referans

## 🔓 PUBLIC (Herkes Erişebilir)

```
GET  https://apiv2.el-bar.com/gorsel-show
GET  https://apiv2.el-bar.com/personel/{qrCode}
GET  https://apiv2.el-bar.com/gizli-duvar
POST https://apiv2.el-bar.com/gizli-duvar
GET  https://apiv2.el-bar.com/qr-olustur
POST https://apiv2.el-bar.com/qr-olustur
GET  https://apiv2.el-bar.com/qr/{code}
```

---

## 🔐 AUTH (Login Gerekli)

```
GET  https://apiv2.el-bar.com/login
POST https://apiv2.el-bar.com/login
GET  https://apiv2.el-bar.com/register
POST https://apiv2.el-bar.com/register
POST https://apiv2.el-bar.com/logout
```

---

## 👤 USER PANEL (Authenticated)

```
GET  https://apiv2.el-bar.com/dashboard
GET  https://apiv2.el-bar.com/profile
PATCH https://apiv2.el-bar.com/profile
DELETE https://apiv2.el-bar.com/profile
```

---

## 👨‍💼 ADMIN PANEL (Admin/Super-Admin)

### Dashboard
```
GET https://apiv2.el-bar.com/admin/dashboard
```

### Kullanıcılar
```
GET    https://apiv2.el-bar.com/admin/users
GET    https://apiv2.el-bar.com/admin/users/create
POST   https://apiv2.el-bar.com/admin/users
GET    https://apiv2.el-bar.com/admin/users/{id}
GET    https://apiv2.el-bar.com/admin/users/{id}/edit
PUT    https://apiv2.el-bar.com/admin/users/{id}
DELETE https://apiv2.el-bar.com/admin/users/{id}
```

### Roller
```
GET    https://apiv2.el-bar.com/admin/roles
GET    https://apiv2.el-bar.com/admin/roles/create
POST   https://apiv2.el-bar.com/admin/roles
GET    https://apiv2.el-bar.com/admin/roles/{id}
GET    https://apiv2.el-bar.com/admin/roles/{id}/edit
PUT    https://apiv2.el-bar.com/admin/roles/{id}
DELETE https://apiv2.el-bar.com/admin/roles/{id}
```

### Kategoriler
```
GET    https://apiv2.el-bar.com/admin/categories
GET    https://apiv2.el-bar.com/admin/categories/create
POST   https://apiv2.el-bar.com/admin/categories
GET    https://apiv2.el-bar.com/admin/categories/{id}
GET    https://apiv2.el-bar.com/admin/categories/{id}/edit
PUT    https://apiv2.el-bar.com/admin/categories/{id}
DELETE https://apiv2.el-bar.com/admin/categories/{id}
```

### Sayfalar
```
GET    https://apiv2.el-bar.com/admin/pages
GET    https://apiv2.el-bar.com/admin/pages/create
POST   https://apiv2.el-bar.com/admin/pages
GET    https://apiv2.el-bar.com/admin/pages/{id}
GET    https://apiv2.el-bar.com/admin/pages/{id}/edit
PUT    https://apiv2.el-bar.com/admin/pages/{id}
DELETE https://apiv2.el-bar.com/admin/pages/{id}
```

### Galeriler
```
GET    https://apiv2.el-bar.com/admin/galleries
GET    https://apiv2.el-bar.com/admin/galleries/create
POST   https://apiv2.el-bar.com/admin/galleries
GET    https://apiv2.el-bar.com/admin/galleries/{id}
GET    https://apiv2.el-bar.com/admin/galleries/{id}/edit
PUT    https://apiv2.el-bar.com/admin/galleries/{id}
DELETE https://apiv2.el-bar.com/admin/galleries/{id}
POST   https://apiv2.el-bar.com/admin/galleries/{id}/upload
DELETE https://apiv2.el-bar.com/admin/galleries/media/{id}
```

### Sabit Sayfalar
```
GET    https://apiv2.el-bar.com/admin/static-pages
GET    https://apiv2.el-bar.com/admin/static-pages/create
POST   https://apiv2.el-bar.com/admin/static-pages
GET    https://apiv2.el-bar.com/admin/static-pages/{id}
GET    https://apiv2.el-bar.com/admin/static-pages/{id}/edit
PUT    https://apiv2.el-bar.com/admin/static-pages/{id}
DELETE https://apiv2.el-bar.com/admin/static-pages/{id}
```

### Gizli Duvar
```
GET    https://apiv2.el-bar.com/admin/secret-wall
GET    https://apiv2.el-bar.com/admin/secret-wall/statistics
GET    https://apiv2.el-bar.com/admin/secret-wall/create
POST   https://apiv2.el-bar.com/admin/secret-wall
GET    https://apiv2.el-bar.com/admin/secret-wall/{id}
GET    https://apiv2.el-bar.com/admin/secret-wall/{id}/edit
PUT    https://apiv2.el-bar.com/admin/secret-wall/{id}
DELETE https://apiv2.el-bar.com/admin/secret-wall/{id}
POST   https://apiv2.el-bar.com/admin/secret-wall/{id}/approve
DELETE https://apiv2.el-bar.com/admin/secret-wall/{id}/reject
POST   https://apiv2.el-bar.com/admin/secret-wall/{id}/restore
POST   https://apiv2.el-bar.com/admin/secret-wall/bulk/approve
POST   https://apiv2.el-bar.com/admin/secret-wall/bulk/delete
```

### QR Sistemi
```
GET    https://apiv2.el-bar.com/admin/qr-system
GET    https://apiv2.el-bar.com/admin/qr-system/create
POST   https://apiv2.el-bar.com/admin/qr-system
GET    https://apiv2.el-bar.com/admin/qr-system/{code}
DELETE https://apiv2.el-bar.com/admin/qr-system/{code}
POST   https://apiv2.el-bar.com/admin/qr-system/clean-expired
```

### Etkinlik Görevlileri (Scanner)
```
GET    https://apiv2.el-bar.com/admin/scanner-users
GET    https://apiv2.el-bar.com/admin/scanner-users/create
POST   https://apiv2.el-bar.com/admin/scanner-users
GET    https://apiv2.el-bar.com/admin/scanner-users/{id}
GET    https://apiv2.el-bar.com/admin/scanner-users/{id}/edit
PUT    https://apiv2.el-bar.com/admin/scanner-users/{id}
DELETE https://apiv2.el-bar.com/admin/scanner-users/{id}
POST   https://apiv2.el-bar.com/admin/scanner-users/{id}/toggle-status
```

### Medya Ayarları
```
GET  https://apiv2.el-bar.com/admin/media-settings
POST https://apiv2.el-bar.com/admin/media-settings
POST https://apiv2.el-bar.com/admin/media-settings/test-connection
```

### Görsel Show
```
GET    https://apiv2.el-bar.com/admin/visual-show
GET    https://apiv2.el-bar.com/admin/visual-show/create
POST   https://apiv2.el-bar.com/admin/visual-show
GET    https://apiv2.el-bar.com/admin/visual-show/{id}
GET    https://apiv2.el-bar.com/admin/visual-show/{id}/edit
PUT    https://apiv2.el-bar.com/admin/visual-show/{id}
DELETE https://apiv2.el-bar.com/admin/visual-show/{id}
```

### Personel Yönetimi
```
GET https://apiv2.el-bar.com/admin/personel
GET https://apiv2.el-bar.com/admin/personel/create
POST https://apiv2.el-bar.com/admin/personel
GET https://apiv2.el-bar.com/admin/personel/{id}
GET https://apiv2.el-bar.com/admin/personel/{id}/edit
PUT https://apiv2.el-bar.com/admin/personel/{id}
DELETE https://apiv2.el-bar.com/admin/personel/{id}
GET https://apiv2.el-bar.com/admin/personel-statistics
```

### Şirket Sosyal Medya
```
GET https://apiv2.el-bar.com/admin/company-social-media
PUT https://apiv2.el-bar.com/admin/company-social-media
```

### Modül Yönetimi
```
GET  https://apiv2.el-bar.com/admin/modules
POST https://apiv2.el-bar.com/admin/modules/{id}/toggle-status
```

### 🆕 Ekip Yönetimi (YENİ!)
```
GET    https://apiv2.el-bar.com/admin/teams
GET    https://apiv2.el-bar.com/admin/teams/create
POST   https://apiv2.el-bar.com/admin/teams
GET    https://apiv2.el-bar.com/admin/teams/{id}
GET    https://apiv2.el-bar.com/admin/teams/{id}/edit
PUT    https://apiv2.el-bar.com/admin/teams/{id}
DELETE https://apiv2.el-bar.com/admin/teams/{id}
POST   https://apiv2.el-bar.com/admin/teams/{id}/personels
DELETE https://apiv2.el-bar.com/admin/teams/{id}/personels/{teamPersonelId}
POST   https://apiv2.el-bar.com/admin/teams/{id}/reorder-personels
```

---

## 📱 ETKINLIK GÖREVLISI (Scanner)

```
GET  https://apiv2.el-bar.com/etkinlik-gorevlisi/giris
POST https://apiv2.el-bar.com/etkinlik-gorevlisi/giris
GET  https://apiv2.el-bar.com/etkinlik-gorevlisi/panel
GET  https://apiv2.el-bar.com/etkinlik-gorevlisi/gecmis
GET  https://apiv2.el-bar.com/etkinlik-gorevlisi/qr-tara
POST https://apiv2.el-bar.com/etkinlik-gorevlisi/qr-dogrula
POST https://apiv2.el-bar.com/etkinlik-gorevlisi/giris-izni-ver/{qrCode}
POST https://apiv2.el-bar.com/etkinlik-gorevlisi/giris-reddet/{qrCode}
POST https://apiv2.el-bar.com/etkinlik-gorevlisi/cikis
```

---

## 📡 REST API (/api/v1)

### Personel
```
GET https://apiv2.el-bar.com/api/v1/personel
GET https://apiv2.el-bar.com/api/v1/personel/{qrCode}
```

### Sayfalar
```
GET https://apiv2.el-bar.com/api/v1/pages
GET https://apiv2.el-bar.com/api/v1/pages/{slug}
```

### Galeriler
```
GET https://apiv2.el-bar.com/api/v1/galleries
GET https://apiv2.el-bar.com/api/v1/galleries/{id}
```

### Modüller
```
GET https://apiv2.el-bar.com/api/v1/modules/active
GET https://apiv2.el-bar.com/api/v1/modules
```

### Diller
```
GET https://apiv2.el-bar.com/api/v1/languages
```

### Gizli Duvar
```
GET  https://apiv2.el-bar.com/api/v1/secret-wall
POST https://apiv2.el-bar.com/api/v1/secret-wall
GET  https://apiv2.el-bar.com/api/v1/secret-wall/statistics
GET  https://apiv2.el-bar.com/api/v1/secret-wall/{id}
```

### Sabit Sayfalar
```
GET https://apiv2.el-bar.com/api/v1/static-pages
GET https://apiv2.el-bar.com/api/v1/static-pages/{type}
```

### QR
```
POST https://apiv2.el-bar.com/api/v1/qr/generate
GET  https://apiv2.el-bar.com/api/v1/qr/check/{code}
```

---

## 🚀 Hızlı Linkler

| Sayfa | URL |
|-------|-----|
| Admin Dashboard | https://apiv2.el-bar.com/admin/dashboard |
| **Ekip Yönetimi** 🆕 | **https://apiv2.el-bar.com/admin/teams** |
| Personel Yönetimi | https://apiv2.el-bar.com/admin/personel |
| Kullanıcılar | https://apiv2.el-bar.com/admin/users |
| Gizli Duvar (Admin) | https://apiv2.el-bar.com/admin/secret-wall |
| Gizli Duvar (Public) | https://apiv2.el-bar.com/gizli-duvar |
| Etkinlik Görevlisi | https://apiv2.el-bar.com/etkinlik-gorevlisi/giris |

---

**Güncelleme:** 18 Ekim 2025  
**Total Endpoints:** 150+  
**Status:** ✅ Aktif
