#!/bin/bash

# Sunucu bilgileri
HOST="vezirkoprum.com.tr"
USER="u983381576" # Hostinger kullanıcı adı (hostinger.env'den alındı)
SSH_PORT="65002" # Hostinger SSH portu
PASSWORD="Rk.056914032" # SSH şifresi
REMOTE_DIR="/home/$USER/domains/$HOST/public_html"
REMOTE_ROOT="/home/$USER/domains/$HOST"
LOCAL_DIR="$(pwd)"

echo "🚀 Hostinger'a deploy başlıyor..."

# Local'de build yap
echo "🔨 Local'de CSS/JS build ediliyor..."
npm run build

# Git pull ile son değişiklikleri çek
echo "📥 GitHub'dan son değişiklikler çekiliyor..."
sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && git pull origin main"

# Public klasörünün tüm içeriğini senkronize et
echo "📁 Public klasörü senkronize ediliyor..."
sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && rsync -av --delete public/ public_html/"

# Build dosyalarını upload et
echo "📤 Build dosyaları upload ediliyor..."
sshpass -p "$PASSWORD" scp -o StrictHostKeyChecking=no -P $SSH_PORT -r public/build/* $USER@$HOST:$REMOTE_DIR/build/

# Composer install (platform requirements ignore)
echo "📦 Composer dependencies kuruluyor..."
sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && composer install --no-dev --optimize-autoloader --ignore-platform-reqs"

# Migration'ları çalıştır
echo "🗄️ Database migration'ları çalıştırılıyor..."
sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && php artisan migrate --force"

# Cache'leri temizle ve oluştur
echo "🧹 Cache'ler temizleniyor ve oluşturuyor..."
sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && \
    php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache"

# Storage link oluştur (manuel)
echo "🔗 Storage link oluşturuluyor..."
sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && ln -sf $REMOTE_ROOT/storage/app/public $REMOTE_ROOT/public_html/storage"

# .env dosyasını güncelle
echo "⚙️ Environment dosyası güncelleniyor..."
sshpass -p "$PASSWORD" ssh -o StrictHostKeyChecking=no -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && cp hostinger.env .env"

echo "✅ Deployment tamamlandı!"
echo "🌐 Site: https://vezirkoprum.com.tr"
echo "🔧 Admin: https://vezirkoprum.com.tr/admin/login"
echo "👤 Admin Kullanıcı: rslkrkmz"
echo "🔑 Admin Şifre: Rr123456" 