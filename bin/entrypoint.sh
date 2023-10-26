#!/usr/bin/env bash
composer install --ignore-platform-reqs --optimize-autoloader

php artisan serve --host 0.0.0.0 --port=3000
php artisan config:cache
php artisan optimize:clear