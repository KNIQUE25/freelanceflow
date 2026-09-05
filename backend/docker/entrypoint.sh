#!/bin/bash
set -e

echo "Starting FreelanceFlow on Render..."

# Ensure required directories exist
mkdir -p /var/www/resources/views
mkdir -p /var/www/storage
mkdir -p /var/www/bootstrap/cache

# Clear stale caches (use optimize:clear to be safe)
php artisan optimize:clear

# Run migrations if database is ready
php artisan migrate --force --no-interaction

# Cache config and routes (this helps performance)
php artisan config:cache
php artisan route:cache

# Link storage
php artisan storage:link 2>/dev/null || true

# Set proper permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "Setup complete. Starting supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf