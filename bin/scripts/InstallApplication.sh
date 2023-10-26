#!/bin/bash

echo "Install application"
cp /var/www/.env /var/www/app/.env #change these with AWS SM
cd /var/www/app && docker-compose up -d --build
docker exec budgetcontrol-services bash -c "php artisan migrate"
docker exec budgetcontrol-services bash -c "chown -R www-data:www-data *" #apache group