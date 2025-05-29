#!/bin/bash

# Sunucu bilgileri
HOST="vezirkoprum.com.tr"
USER="u123456789" # Hostinger kullanıcı adınız
REMOTE_DIR="/home/$USER/domains/$HOST/public_html"
LOCAL_DIR="$(pwd)"

# Bakım modunu aktifleştir
ssh $USER@$HOST "cd $REMOTE_DIR && php artisan down"

# Dosyaları senkronize et (storage ve .env hariç)
rsync -avz --exclude '.git' \
    --exclude 'storage' \
    --exclude '.env' \
    --exclude 'node_modules' \
    --exclude 'vendor' \
    --exclude 'public/storage' \
    $LOCAL_DIR/ $USER@$HOST:$REMOTE_DIR/

# Sunucuda gerekli komutları çalıştır
ssh $USER@$HOST "cd $REMOTE_DIR && \
    composer install --no-dev --optimize-autoloader && \
    php artisan storage:link && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force"

# Bakım modunu kapat
ssh $USER@$HOST "cd $REMOTE_DIR && php artisan up"

echo "Deployment tamamlandı!" 