#!/bin/bash

echo "Run functional test"
docker exec budgetcontrol-services bash -c "vendor/bin/phpunit"