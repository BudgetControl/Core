#!/bin/bash

echo "Run functional test"
docker exec budgetcontrol-services bash -c "service apache2 restart"
docker exec budgetcontrol-services bash -c "php artisan test"