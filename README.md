# Vezirköprüm.com.tr

Vezirköprüm topluluk rehberi MVP projesi.

## Özellikler

- Kullanıcı kaydı ve profil yönetimi
- Şehir/ilçe bazlı meslek listesi
- Site içi mesajlaşma sistemi
- WhatsApp grup yönetimi

## Kurulum

1. Repository'yi klonlayın:
```bash
git clone https://github.com/ResulKorkmaz/vezirkoprum.git
cd vezirkoprum
```

2. Composer bağımlılıklarını yükleyin:
```bash
composer install
```

3. .env dosyasını oluşturun:
```bash
cp .env.example .env
```

4. Uygulama anahtarını oluşturun:
```bash
php artisan key:generate
```

5. Veritabanını oluşturun ve migration'ları çalıştırın:
```bash
php artisan migrate
```

6. NPM bağımlılıklarını yükleyin ve asset'leri derleyin:
```bash
npm install
npm run build
```

## Geliştirme

- PHP 8.2+
- MySQL 8.0+
- Node.js 18+

## Lisans

MIT
