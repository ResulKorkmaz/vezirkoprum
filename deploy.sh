#!/bin/bash

# Sunucu bilgileri
HOST="vezirkoprum.com.tr"
USER="u983381576" # Hostinger kullanıcı adı (hostinger.env'den alındı)
SSH_PORT="65002" # Hostinger SSH portu
SSH_KEY="$HOME/.ssh/hostinger_key" # SSH private key
REMOTE_DIR="/home/$USER/domains/$HOST/public_html"
REMOTE_ROOT="/home/$USER/domains/$HOST"
LOCAL_DIR="$(pwd)"

echo "🚀 Hostinger'a deploy başlıyor..."

# Git pull ile son değişiklikleri çek
echo "📥 GitHub'dan son değişiklikler çekiliyor..."
ssh -i $SSH_KEY -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && git pull origin main"

# Composer install
echo "📦 Composer dependencies kuruluyor..."
ssh -i $SSH_KEY -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && composer install --no-dev --optimize-autoloader"

# Migration'ları çalıştır
echo "🗄️ Database migration'ları çalıştırılıyor..."
ssh -i $SSH_KEY -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && php artisan migrate --force"

# Cache'leri temizle ve oluştur
echo "🧹 Cache'ler temizleniyor ve oluşturuluyor..."
ssh -i $SSH_KEY -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && \
    php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache"

# Storage link oluştur
echo "🔗 Storage link oluşturuluyor..."
ssh -i $SSH_KEY -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && php artisan storage:link"

# .env dosyasını güncelle
echo "⚙️ Environment dosyası güncelleniyor..."
ssh -i $SSH_KEY -p $SSH_PORT $USER@$HOST "cd $REMOTE_ROOT && cp hostinger.env .env"

echo "✅ Deployment tamamlandı!"
echo "🌐 Site: https://vezirkoprum.com.tr"
echo "🔧 Admin: https://vezirkoprum.com.tr/admin/login" 