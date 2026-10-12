#!/bin/sh
set -eu
: "${APP_KEY:?Set APP_KEY in Render}"
export APP_URL="${APP_URL:-${RENDER_EXTERNAL_URL:-}}"
: "${APP_URL:?Set APP_URL to your HTTPS website address}"
sed -i "s/^Listen 80$/Listen ${PORT:-10000}/" /etc/apache2/ports.conf
sed -i "s/:10000>/:${PORT:-10000}>/" /etc/apache2/sites-available/000-default.conf
php artisan config:clear
php deploy/initialize.php
php artisan migrate --force
php deploy/create-owner.php
php artisan config:cache
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache
exec apache2-foreground
