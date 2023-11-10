#!/usr/bin/env bash
composer install --ignore-platform-reqs --optimize-autoloader

php artisan optimize
tail -F -n 100 /var/www/workdir/storage/logs/laravel.log
