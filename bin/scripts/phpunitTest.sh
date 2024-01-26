cp ../../.env.testing ../../.env
docker exec budgetcontrol-core php artisan config:cache
docker exec budgetcontrol-core php artisan migrate:fresh
docker exec budgetcontrol-core php artisan db:seed
docker exec budgetcontrol-core vendor/bin/phpunit
cp ../../.env.bk ../../.env
docker exec budgetcontrol-core php artisan config:cache