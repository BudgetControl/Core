#!/bin/bash

echo "Install application"
cp /var/www/conf/proxy/proxy.conf cp /var/www/app/bin/nginx/default.conf
docker exec budgetcontrol-services bash -c "composer install"
docker exec budgetcontrol-services bash -c "php artisan migrate"
docker exec budgetcontrol-services bash -c "cd /var/www/workdir && chown -R www-data:www-data *" #apache group
docker exec budgetcontrol-services bash -c "service apache2 restart"
cp /var/www/.env /var/www/app/.env