#!/bin/bash
set -e

echo "Starting Application..."

mkdir -p /var/www/resources/views
mkdir -p /var/www/storage
mkdir -p /var/www/bootstrap/cache

echo "Clearing configuration cache..."
php artisan config:clear

echo "Clearing route cache..."
php artisan route:clear

echo "Running database migrations..."
php artisan migrate --force --no-interaction

echo "Caching configuration..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Creating storage link..."
php artisan storage:link 2>/dev/null || true

echo "Fixing permissions..."

chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache

chmod -R 775 \
    /var/www/storage \
    /var/www/bootstrap/cache

echo "Setup complete. Starting services..."

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf