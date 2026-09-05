#!/bin/bash
set -e

echo "Starting Application..."

mkdir -p /var/www/resources/views
mkdir -p /var/www/storage
mkdir -p /var/www/bootstrap/cache

php artisan optimize:clear

php artisan migrate --force --no-interaction

php artisan config:cache
php artisan route:cache

php artisan storage:link 2>/dev/null || true

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "Setup complete. Starting services..."

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf