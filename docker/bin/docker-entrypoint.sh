#!/bin/sh
set -e

echo "Executing docker-entrypoint.sh."

mkdir -p /var/www/storage/framework/{sessions,views,cache}
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

touch /var/www/storage/logs/laravel.log

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

find /var/www/storage -type d -exec chmod 755 {} \;
find /var/www/storage -type f -exec chmod 644 {} \;
find /var/www/bootstrap/cache -type d -exec chmod 755 {} \;
find /var/www/bootstrap/cache -type f -exec chmod 644 {} \;

chmod -R 777 /var/www/storage/logs
chmod -R 777 /var/www/storage/framework/views
chmod -R 777 /var/www/bootstrap/cache

chmod 666 /var/www/storage/logs/laravel.log

echo "Permissions configured."

exec "$@"