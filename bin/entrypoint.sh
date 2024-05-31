#!/usr/bin/env bash

# Directory dove si trova il file .env
WORKDIR="/var/www/workdir"

# Naviga nella directory di lavoro
cd "$WORKDIR" || { echo "Directory $WORKDIR not found"; exit 1; }

# Funzione per caricare le variabili dal file .env
load_env() {
  if [ -f .env ]; then
    export $(grep -v '^#' .env | xargs)
  else
    echo ".env file not found in $WORKDIR"
    exit 1
  fi
}

# Carica le variabili dal file .env
load_env

# Debug: Stampa tutte le variabili ambiente
env | grep LOGTAIL_API_KEY

# Verifica che la variabile sia stata caricata
if [ -z "$LOGTAIL_API_KEY" ]; then
  echo "The variable LOGTAIL_API_KEY was not found in the .env file"
  exit 1
fi

# Esegui i comandi
composer install --ignore-platform-reqs --optimize-autoloader

# INSTALL VECTOR better stack
curl -sSL https://logs.betterstack.com/setup-vector/docker/$LOGTAIL_API_KEY -o /tmp/setup-vector.sh && bash /tmp/setup-vector.sh

# Verifica se si tratta di un progetto Laravel
if [ -f artisan ]; then
  echo "Laravel project detected, running php artisan optimize"
  php artisan optimize
else
  echo "Not a Laravel project, skipping php artisan optimize"
fi

service apache2 restart

tail -F -n 100 /var/www/workdir/storage/logs/error.log