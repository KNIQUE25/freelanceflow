#!/bin/bash
set -e

echo "Starting Application..."

# Ensure Laravel directories exist
mkdir -p /var/www/resources/views
mkdir -p /var/www/storage
mkdir -p /var/www/bootstrap/cache

# Clear stale caches
php artisan optimize:clear

# Run database migrations
php artisan migrate --force --no-interaction

# Cache configuration and routes
php artisan config:cache
php artisan route:cache

# Create storage link
php artisan storage:link 2>/dev/null || true

# Permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "Setup complete. Starting services..."

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf