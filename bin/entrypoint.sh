#!/usr/bin/env bash
composer install --ignore-platform-reqs --optimize-autoloader

php artisan config:cache
php artisan optimize:clear