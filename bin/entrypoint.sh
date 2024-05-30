#!/usr/bin/env bash

# Carica le variabili dal file .env
if [ -f .env ]; then
  export $(cat .env | grep -v '^#' | xargs)
fi

# Verifica che la variabile sia stata caricata
if [ -z "$BETTERSTACK_TOKEN" ]; then
echo "The variable BETTERSTACK_TOKEN was not found in the .env file"
  exit 1
fi

# Esegui i comandi
composer install --ignore-platform-reqs --optimize-autoloader

# INSTALL VECTOR better stack
curl -sSL https://logs.betterstack.com/setup-vector/docker/$BETTERSTACK_TOKEN -o /tmp/setup-vector.sh && bash /tmp/setup-vector.sh

php artisan optimize
tail -F -n 100 /var/www/workdir/storage/logs/laravel.log
