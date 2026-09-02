#!/bin/bash
set -e

echo "Starting Application..."

# Ensure the views directory exists (fixes "View path not found")
if [ ! -d "/var/www/resources/views" ]; then
    mkdir -p /var/www/resources/views
    echo "Created /var/www/resources/views"
fi

# Generate app key only if .env exists AND APP_KEY is empty
if [ -z "$APP_KEY" ] && [ -f /var/www/.env ]; then
    php artisan key:generate --force
fi

# Clear any stale caches (skip view:clear to avoid error)
php artisan config:clear
php artisan route:clear
# php artisan view:clear   # <-- REMOVE this line

# Run migrations (if database is ready)
php artisan migrate --force --no-interaction

# Cache for performance (skip view:cache as well)
php artisan config:cache
php artisan route:cache
# php artisan view:cache   # <-- REMOVE this line

# Storage link
php artisan storage:link 2>/dev/null || true

# Fix permissions again (in case they changed)
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

echo "Setup complete. Starting services..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf