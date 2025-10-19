# 📡 EL-BAR API Dokümantasyonu

Modern ve kapsamlı EL-BAR Yönetim Sistemi REST API dokümantasyonu.

---

## 🌐 Herkese Açık Sayfalar

Aşağıdaki sayfalar herhangi bir kimlik doğrulama gerektirmeden erişilebilir:

### Gizli Duvar Kayıt Formu
```
https://yourdomain.com/gizli-duvar
```
Kullanıcıların fotoğraf ve sosyal medya bilgilerini paylaşabildiği kayıt formu. Admin onayından sonra gizli duvarda görüntülenir.

### QR Kod Oluşturma
```
https://yourdomain.com/qr-olustur
```
Herkesin kullanabileceği QR kod oluşturma aracı. Metin, URL, telefon numarası gibi bilgilerden QR kod üretebilirsiniz.

### Görsel Show (Slayt Gösterisi)
```
https://yourdomain.com/gorsel-show
```
Sistemdeki aktif medya içeriklerinin otomatik slayt gösterimi.

### Personel Profili (QR ile Erişim)
```
https://yourdomain.com/personel/{qr_code}
```
QR kod tarayarak personel profiline erişim ve sosyal medya takip sayfası.

---

## 📋 İçindekiler

- [Genel Bilgiler](#genel-bilgiler)
- [Kimlik Doğrulama](#kimlik-doğrulama)
- [Endpoint'ler](#endpointler)
  - [Personel API](#personel-api)
  - [Sabit Sayfalar API](#sabit-sayfalar-api)
  - [Galeriler API](#galeriler-api)
  - [Modüller API](#modüller-api)
  - [Diller API](#diller-api)
  - [Sayfalar API](#sayfalar-api)
  - [QR Kodlar API](#qr-kodlar-api)
- [Hata Kodları](#hata-kodları)
- [Örnekler](#örnekler)

---

## 🌐 Genel Bilgiler

### Base URL
```
https://yourdomain.com/api/v1
```

### İstek Formatı
- **Content-Type:** `application/json`
- **Accept:** `application/json`

### Yanıt Formatı
Tüm API yanıtları aşağıdaki JSON formatını kullanır:

```json
{
  "success": true,
  "data": {},
  "message": "İşlem başarıyla tamamlandı."
}
```

**Hata Durumunda:**
```json
{
  "success": false,
  "message": "Hata mesajı"
}
```

---

## 🔐 Kimlik Doğrulama

Şu anda API endpoint'leri **public** erişime açıktır. Gelecek versiyonlarda API token tabanlı kimlik doğrulama eklenecektir.

---

## 📚 Endpoint'ler

### Personel API

#### 1. Tüm Personelleri Listele

**Endpoint:** `GET /api/v1/personel`

**Açıklama:** Tüm personel listesini getirir.

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/personel" \
  -H "Accept: application/json"
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Ahmet",
      "surname": "Yılmaz",
      "qr_code": "PER123456",
      "image": "https://yourdomain.com/storage/personel/image.jpg",
      "whatsapp": "+905551234567",
      "instagram": "ahmetyilmaz",
      "facebook": null,
      "twitter": null,
      "linkedin": null,
      "youtube": null,
      "followers_count": 150,
      "translations": [
        {
          "id": 1,
          "language_id": 1,
          "language_code": "tr",
          "language_name": "Türkçe",
          "position": "Yazılım Geliştirici",
          "description": "5 yıllık deneyimli yazılım geliştirici"
        },
        {
          "id": 2,
          "language_id": 2,
          "language_code": "en",
          "language_name": "English",
          "position": "Software Developer",
          "description": "Software developer with 5 years experience"
        }
      ],
      "created_at": "2025-01-15T10:30:00.000000Z",
      "updated_at": "2025-01-20T14:45:00.000000Z"
    }
  ],
  "message": "Personel listesi başarıyla getirildi."
}
```

---

#### 2. QR Koda Göre Personel Getir

**Endpoint:** `GET /api/v1/personel/{qr_code}`

**Açıklama:** Belirtilen QR koda sahip personel bilgilerini getirir ve takipçi sayısını artırır.

**Parametreler:**
- `qr_code` (string, path) - Personelin QR kodu

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/personel/PER123456" \
  -H "Accept: application/json"
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Ahmet",
    "surname": "Yılmaz",
    "qr_code": "PER123456",
    "image": "https://yourdomain.com/storage/personel/image.jpg",
    "whatsapp": "+905551234567",
    "instagram": "ahmetyilmaz",
    "facebook": null,
    "twitter": null,
    "linkedin": null,
    "youtube": null,
    "followers_count": 151,
    "translations": [
      {
        "id": 1,
        "language_id": 1,
        "language_code": "tr",
        "language_name": "Türkçe",
        "position": "Yazılım Geliştirici",
        "description": "5 yıllık deneyimli yazılım geliştirici"
      }
    ],
    "created_at": "2025-01-15T10:30:00.000000Z",
    "updated_at": "2025-01-20T14:45:00.000000Z"
  },
  "message": "Personel bilgileri başarıyla getirildi."
}
```

**Response (404 Not Found):**
```json
{
  "success": false,
  "message": "Personel bulunamadı."
}
```

---

### Sabit Sayfalar API

#### 1. Tüm Sabit Sayfaları Listele

**Endpoint:** `GET /api/v1/static-pages`

**Açıklama:** Tüm aktif sabit sayfaları getirir.

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/static-pages" \
  -H "Accept: application/json"
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "page_type": "contact",
      "title": "İletişim",
      "slug": "iletisim",
      "image": "https://yourdomain.com/storage/static-pages/contact.jpg",
      "banner_image": "https://yourdomain.com/storage/static-pages/contact-banner.jpg",
      "is_active": true,
      "translations": [
        {
          "id": 1,
          "language_id": 1,
          "language_code": "tr",
          "language_name": "Türkçe",
          "title": "İletişim",
          "content": "<p>Bize ulaşın...</p>",
          "meta_description": "İletişim sayfası",
          "custom_fields": null
        }
      ],
      "contact": {
        "id": 1,
        "phone": "+905551234567",
        "email": "info@elbar.com",
        "address": "123 Sokak, No: 45",
        "city": "İstanbul",
        "country": "Türkiye",
        "postal_code": "34000",
        "latitude": "41.0082",
        "longitude": "28.9784",
        "whatsapp": "+905551234567",
        "facebook_url": "https://facebook.com/elbar",
        "instagram_url": "https://instagram.com/elbar",
        "twitter_url": null,
        "linkedin_url": null,
        "youtube_url": null,
        "working_hours": {
          "monday": "09:00 - 18:00",
          "friday": "09:00 - 17:00"
        }
      },
      "created_at": "2025-01-15T10:30:00.000000Z",
      "updated_at": "2025-01-20T14:45:00.000000Z"
    }
  ],
  "message": "Sabit sayfalar başarıyla getirildi."
}
```

---

#### 2. Sayfa Türüne veya Slug'a Göre Sayfa Getir

**Endpoint:** `GET /api/v1/static-pages/{type}`

**Açıklama:** Belirtilen türe veya slug'a sahip sabit sayfa bilgilerini getirir.

**Parametreler:**
- `type` (string, path) - Sayfa türü (`contact`, `about`, `privacy`, `terms`, `faq`) veya slug

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/static-pages/contact" \
  -H "Accept: application/json"
```

**Response:** Yukarıdaki listele endpoint'inin tek bir sayfa için yanıtı ile aynı.

**Response (404 Not Found):**
```json
{
  "success": false,
  "message": "Sayfa bulunamadı."
}
```

---

### Galeriler API

#### 1. Tüm Galerileri Listele

**Endpoint:** `GET /api/v1/galleries`

**Açıklama:** Tüm aktif galerileri ve resimlerini getirir.

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/galleries" \
  -H "Accept: application/json"
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Etkinlik 2025",
      "description": "2025 yılı etkinlik fotoğrafları",
      "is_active": true,
      "images": [
        {
          "id": 1,
          "image": "https://yourdomain.com/storage/galleries/img1.jpg",
          "title": "Açılış",
          "description": "Etkinlik açılış töreni",
          "sort_order": 1,
          "created_at": "2025-01-15T10:30:00.000000Z"
        },
        {
          "id": 2,
          "image": "https://yourdomain.com/storage/galleries/img2.jpg",
          "title": "Sunum",
          "description": null,
          "sort_order": 2,
          "created_at": "2025-01-15T11:00:00.000000Z"
        }
      ],
      "images_count": 2,
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-20T14:00:00.000000Z"
    }
  ],
  "message": "Galeriler başarıyla getirildi."
}
```

---

#### 2. ID'ye Göre Galeri Getir

**Endpoint:** `GET /api/v1/galleries/{id}`

**Açıklama:** Belirtilen ID'ye sahip galeri ve tüm resimlerini getirir.

**Parametreler:**
- `id` (integer, path) - Galeri ID'si

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/galleries/1" \
  -H "Accept: application/json"
```

**Response:** Yukarıdaki listele endpoint'inin tek bir galeri için yanıtı ile aynı.

**Response (404 Not Found):**
```json
{
  "success": false,
  "message": "Galeri bulunamadı."
}
```

---

### Modüller API

#### 1. Tüm Modülleri Listele

**Endpoint:** `GET /api/v1/modules`

**Açıklama:** Tüm etkinlik modüllerini getirir.

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/modules" \
  -H "Accept: application/json"
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "qr-system",
      "label": "QR Kodlar",
      "is_active": true,
      "sort_order": 1,
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-20T14:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "visual-show",
      "label": "Görsel Show",
      "is_active": false,
      "sort_order": 2,
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-20T14:00:00.000000Z"
    }
  ],
  "message": "Modül listesi başarıyla getirildi."
}
```

---

#### 2. Aktif Modülü Getir

**Endpoint:** `GET /api/v1/modules/active`

**Açıklama:** Şu anda aktif olan modülü getirir.

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/modules/active" \
  -H "Accept: application/json"
```

**Response (200 OK - Aktif Modül Var):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "qr-system",
    "label": "QR Kodlar",
    "is_active": true,
    "sort_order": 1,
    "created_at": "2025-01-15T10:00:00.000000Z",
    "updated_at": "2025-01-20T14:00:00.000000Z"
  },
  "message": "Aktif modül başarıyla getirildi."
}
```

**Response (200 OK - Aktif Modül Yok):**
```json
{
  "success": true,
  "data": null,
  "message": "Aktif modül bulunamadı."
}
```

---

### Diller API

#### Tüm Aktif Dilleri Listele

**Endpoint:** `GET /api/v1/languages`

**Açıklama:** Sistemde tanımlı tüm aktif dilleri getirir.

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/languages" \
  -H "Accept: application/json"
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "code": "tr",
      "name": "Türkçe",
      "is_active": true,
      "is_default": true,
      "flag": "🇹🇷",
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-20T14:00:00.000000Z"
    },
    {
      "id": 2,
      "code": "en",
      "name": "English",
      "is_active": true,
      "is_default": false,
      "flag": "🇬🇧",
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-20T14:00:00.000000Z"
    }
  ],
  "message": "Dil listesi başarıyla getirildi."
}
```

---

### Sayfalar API

#### 1. Tüm Aktif Sayfaları Listele

**Endpoint:** `GET /api/v1/pages`

**Açıklama:** Tüm aktif dinamik sayfaları getirir.

**Query Parametreleri:**
- `category_id` (integer, optional) - Kategoriye göre filtrele

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/pages" \
  -H "Accept: application/json"

# Kategoriye göre filtrele
curl -X GET "https://yourdomain.com/api/v1/pages?category_id=1" \
  -H "Accept: application/json"
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "category_id": 1,
      "category_name": "Haberler",
      "image": "https://yourdomain.com/storage/pages/news1.jpg",
      "is_active": true,
      "translations": [
        {
          "id": 1,
          "language_id": 1,
          "language_code": "tr",
          "language_name": "Türkçe",
          "title": "Yeni Ürün Lansmanı",
          "slug": "yeni-urun-lansmani",
          "content": "<p>Yeni ürünümüzü tanıtıyoruz...</p>",
          "meta_description": "Yeni ürün lansmanı haberi",
          "meta_keywords": "ürün, lansman, haber"
        }
      ],
      "created_at": "2025-01-15T10:00:00.000000Z",
      "updated_at": "2025-01-20T14:00:00.000000Z"
    }
  ],
  "message": "Sayfa listesi başarıyla getirildi."
}
```

---

#### 2. Slug'a Göre Sayfa Getir

**Endpoint:** `GET /api/v1/pages/{slug}`

**Açıklama:** Belirtilen slug'a sahip sayfayı getirir.

**Parametreler:**
- `slug` (string, path) - Sayfa slug'ı

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/pages/yeni-urun-lansmani" \
  -H "Accept: application/json"
```

**Response:** Yukarıdaki listele endpoint'inin tek bir sayfa için yanıtı ile aynı.

**Response (404 Not Found):**
```json
{
  "success": false,
  "message": "Sayfa bulunamadı."
}
```

---

### QR Kodlar API

#### 1. QR Kod Oluştur

**Endpoint:** `POST /api/v1/qr/generate`

**Açıklama:** Yeni QR kod oluşturur.

**Request Body:**
```json
{
  "event_id": 1,
  "valid_from": "2025-02-01 10:00:00",
  "valid_until": "2025-02-01 22:00:00"
}
```

**Request:**
```bash
curl -X POST "https://yourdomain.com/api/v1/qr/generate" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "valid_from": "2025-02-01 10:00:00",
    "valid_until": "2025-02-01 22:00:00"
  }'
```

---

#### 2. QR Kod Kontrol Et

**Endpoint:** `GET /api/v1/qr/check/{code}`

**Açıklama:** QR kod geçerliliğini kontrol eder.

**Parametreler:**
- `code` (string, path) - Kontrol edilecek QR kod

**Request:**
```bash
curl -X GET "https://yourdomain.com/api/v1/qr/check/QR123456" \
  -H "Accept: application/json"
```

---

## ⚠️ Hata Kodları

API aşağıdaki HTTP durum kodlarını kullanır:

| Kod | Açıklama |
|-----|----------|
| 200 | OK - İstek başarılı |
| 201 | Created - Kaynak başarıyla oluşturuldu |
| 400 | Bad Request - Geçersiz istek |
| 401 | Unauthorized - Kimlik doğrulama gerekli |
| 403 | Forbidden - Erişim izni yok |
| 404 | Not Found - Kaynak bulunamadı |
| 422 | Unprocessable Entity - Doğrulama hatası |
| 500 | Internal Server Error - Sunucu hatası |

---

## 📝 Örnekler

### JavaScript ile API Kullanımı

```javascript
// Personel listesini getir
async function getPersonelList() {
  try {
    const response = await fetch('https://yourdomain.com/api/v1/personel', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      }
    });

    const data = await response.json();

    if (data.success) {
      console.log('Personel listesi:', data.data);
    } else {
      console.error('Hata:', data.message);
    }
  } catch (error) {
    console.error('İstek hatası:', error);
  }
}

// QR koda göre personel getir
async function getPersonelByQR(qrCode) {
  try {
    const response = await fetch(`https://yourdomain.com/api/v1/personel/${qrCode}`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      }
    });

    const data = await response.json();

    if (data.success) {
      console.log('Personel:', data.data);
      return data.data;
    } else {
      console.error('Hata:', data.message);
      return null;
    }
  } catch (error) {
    console.error('İstek hatası:', error);
    return null;
  }
}

// Aktif modülü getir
async function getActiveModule() {
  try {
    const response = await fetch('https://yourdomain.com/api/v1/modules/active', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      }
    });

    const data = await response.json();

    if (data.success && data.data) {
      console.log('Aktif modül:', data.data.name);
      return data.data;
    } else {
      console.log('Aktif modül yok');
      return null;
    }
  } catch (error) {
    console.error('İstek hatası:', error);
    return null;
  }
}
```

---

### PHP ile API Kullanımı

```php
<?php

// Personel listesini getir
function getPersonelList() {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://yourdomain.com/api/v1/personel',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
        ],
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        return $data['data'];
    }

    return null;
}

// QR koda göre personel getir
function getPersonelByQR($qrCode) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://yourdomain.com/api/v1/personel/{$qrCode}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
        ],
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        return $data['data'];
    }

    return null;
}

// Kullanım
$personelList = getPersonelList();
if ($personelList) {
    foreach ($personelList as $personel) {
        echo $personel['name'] . ' ' . $personel['surname'] . "\n";
    }
}

$personel = getPersonelByQR('PER123456');
if ($personel) {
    echo "Personel: {$personel['name']} {$personel['surname']}\n";
    echo "Takipçi: {$personel['followers_count']}\n";
}
?>
```

---

### Python ile API Kullanımı

```python
import requests

# Base URL
BASE_URL = "https://yourdomain.com/api/v1"

# Personel listesini getir
def get_personel_list():
    response = requests.get(
        f"{BASE_URL}/personel",
        headers={"Accept": "application/json"}
    )

    if response.status_code == 200:
        data = response.json()
        if data['success']:
            return data['data']

    return None

# QR koda göre personel getir
def get_personel_by_qr(qr_code):
    response = requests.get(
        f"{BASE_URL}/personel/{qr_code}",
        headers={"Accept": "application/json"}
    )

    if response.status_code == 200:
        data = response.json()
        if data['success']:
            return data['data']

    return None

# Aktif modülü getir
def get_active_module():
    response = requests.get(
        f"{BASE_URL}/modules/active",
        headers={"Accept": "application/json"}
    )

    if response.status_code == 200:
        data = response.json()
        if data['success']:
            return data['data']

    return None

# Kullanım
personel_list = get_personel_list()
if personel_list:
    for personel in personel_list:
        print(f"{personel['name']} {personel['surname']}")

personel = get_personel_by_qr('PER123456')
if personel:
    print(f"Personel: {personel['name']} {personel['surname']}")
    print(f"Takipçi: {personel['followers_count']}")

active_module = get_active_module()
if active_module:
    print(f"Aktif modül: {active_module['label']}")
else:
    print("Aktif modül yok")
```

---

## 🔄 Sürüm Geçmişi

### v1.0.0 (2025-01-20)
- İlk API versiyonu
- Personel, Sabit Sayfalar, Galeriler, Modüller, Diller ve Sayfalar endpoint'leri eklendi
- Çok dilli içerik desteği
- QR kod sistemi entegrasyonu

---

## 📞 Destek

API ile ilgili sorularınız için:
- **E-posta:** api-support@yourdomain.com
- **Dokümantasyon:** https://yourdomain.com/api/docs
- **GitHub:** https://github.com/yourusername/el-bar

---

## 📄 Lisans

Bu API özel bir projedir. Kullanım hakları saklıdır.

---

**Son Güncelleme:** 2025-01-20
**API Versiyonu:** v1.0.0
