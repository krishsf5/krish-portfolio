#!/usr/bin/env bash
set -e

PORT="${PORT:-10000}"
echo "Listen ${PORT}" > /etc/apache2/ports.conf

php artisan config:clear --no-interaction
php artisan route:clear --no-interaction
php artisan view:clear --no-interaction
php artisan storage:link --no-interaction || true

if [ "${RUN_MIGRATIONS:-true}" != "false" ]; then
    php artisan migrate --force --no-interaction
fi

php artisan config:cache --no-interaction
php artisan view:cache --no-interaction

exec apache2-foreground
