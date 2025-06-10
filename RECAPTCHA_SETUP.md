# Google reCAPTCHA v3 Entegrasyonu

Bu proje Google reCAPTCHA v3 ile güvenlik entegrasyonu içermektedir.

## 🔧 Kurulum

### 1. Google reCAPTCHA Anahtarları

Şu anda test anahtarları kullanılmaktadır:
- **Site Key**: `6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI`
- **Secret Key**: `6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe`

### 2. Gerçek Anahtarlar İçin

1. [Google reCAPTCHA Admin Console](https://www.google.com/recaptcha/admin)'a gidin
2. Yeni site ekleyin
3. reCAPTCHA v3 seçin
4. Domain'inizi ekleyin (örn: `vezirkoprum.com.tr`)
5. Aldığınız anahtarları `.env` dosyasına ekleyin:

```env
RECAPTCHA_SITE_KEY=your_real_site_key
RECAPTCHA_SECRET_KEY=your_real_secret_key
RECAPTCHA_ENABLED=true
RECAPTCHA_SCORE_THRESHOLD=0.5
```

## 🛡️ Güvenlik Özellikleri

### Korunan Formlar

1. **Kayıt Formu** (`/register`)
   - Action: `register`
   - Doğrulama: `RecaptchaRule`

2. **Giriş Formu** (`/login`)
   - Action: `login`
   - Doğrulama: `RecaptchaRule`

3. **İletişim Formu** (Footer modal)
   - Action: `contact`
   - Doğrulama: `RecaptchaRule`

4. **Paylaşım Formu** (Post modal)
   - Action: `post`
   - Doğrulama: `RecaptchaRule`

### Güvenlik Seviyesi

- **Score Threshold**: 0.5 (0.0-1.0 arası, 1.0 en güvenli)
- **Timeout**: 30 saniye
- **Otomatik**: Kullanıcı etkileşimi gerektirmez

## 🔍 Test Etme

### 1. Test Sayfası
`test-recaptcha.html` dosyasını tarayıcıda açarak reCAPTCHA'nın çalışıp çalışmadığını test edebilirsiniz.

### 2. Form Testleri
- Kayıt formunu test edin: `http://localhost:8000/register`
- Giriş formunu test edin: `http://localhost:8000/login`
- İletişim formunu test edin: Footer'daki "İletişim Formu" butonuna tıklayın
- Paylaşım formunu test edin: Giriş yaptıktan sonra sağ alttaki "+" butonuna tıklayın

### 3. Geliştirici Konsolu
Tarayıcı geliştirici konsolunda şu mesajları görebilirsiniz:
- `reCAPTCHA v3 loaded successfully`
- `reCAPTCHA token: [token]`

## ⚙️ Konfigürasyon

### Dosya Yapısı

```
├── config/recaptcha.php              # reCAPTCHA konfigürasyonu
├── app/Services/RecaptchaService.php # reCAPTCHA servisi
├── app/Rules/RecaptchaRule.php       # Doğrulama kuralı
└── resources/views/components/recaptcha.blade.php # Blade component
```

### Özelleştirme

#### reCAPTCHA'yı Devre Dışı Bırakma
```env
RECAPTCHA_ENABLED=false
```

#### Score Threshold Değiştirme
```env
RECAPTCHA_SCORE_THRESHOLD=0.7  # Daha sıkı güvenlik
```

#### Timeout Ayarlama
```env
RECAPTCHA_TIMEOUT=60  # 60 saniye
```

## 🎨 Frontend Entegrasyonu

### Blade Component Kullanımı

```blade
<!-- Basit kullanım -->
<x-recaptcha />

<!-- Action belirtme -->
<x-recaptcha action="custom_action" />

<!-- Callback fonksiyonu -->
<x-recaptcha action="submit" callback="myCallback" />
```

### JavaScript Fonksiyonları

```javascript
// Token alma
const token = await getRecaptchaToken('action_name');

// Forma token ekleme
await addRecaptchaToForm(formElement, 'action_name');
```

## 🔒 Güvenlik Notları

1. **Test Anahtarları**: Sadece geliştirme için kullanın
2. **Gerçek Anahtarlar**: Production'da mutlaka gerçek anahtarları kullanın
3. **Domain Kısıtlaması**: Gerçek anahtarlar sadece belirtilen domain'lerde çalışır
4. **Score Monitoring**: Düşük score'lar için log takibi yapın
5. **Rate Limiting**: reCAPTCHA ile birlikte rate limiting kullanın

## 📊 Monitoring

### Log Takibi

reCAPTCHA doğrulama logları `storage/logs/laravel.log` dosyasında:

```
[2024-01-01 12:00:00] local.WARNING: reCAPTCHA score too low {"score":0.3,"threshold":0.5,"action":"login"}
[2024-01-01 12:00:01] local.ERROR: reCAPTCHA verification error {"error":"Network error","action":"register"}
```

### Başarı Oranları

Düşük başarı oranları için:
1. Score threshold'u düşürün
2. Network bağlantısını kontrol edin
3. Domain ayarlarını kontrol edin

## 🚀 Production Hazırlığı

1. ✅ Gerçek reCAPTCHA anahtarları ekleyin
2. ✅ Domain'i Google Console'da kaydedin
3. ✅ Score threshold'u ayarlayın
4. ✅ Log monitoring kurun
5. ✅ Test anahtarlarını kaldırın

## 📞 Destek

Sorunlar için:
1. Browser console'u kontrol edin
2. Laravel log dosyalarını kontrol edin
3. Google reCAPTCHA Admin Console'u kontrol edin
4. Network bağlantısını test edin 