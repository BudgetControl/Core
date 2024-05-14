#!/bin/bash
ehco "Instal DEV enviroment"
docker-compose -f docker-compose.yml -f
docker container cp bin/apache/api.budgetcontrol.cloud.conf budgetcontrol-core:/etc/apache2/sites-available/budgetcontrol.cloud.conf
docker container exec budgetcontrol-core service apache2 restart

echo "Build Gateway"
docker container cp microservices/Gateway/bin/apache/default.conf budgetcontrol-gateway:/etc/apache2/sites-available/budgetcontrol.cloud.conf
docker container exec budgetcontrol-gateway service apache2 restart

echo "Build ms Authtentication"
docker container cp microservices/Authtentication/bin/apache/default.conf budgetcontrol-ms-authtentication:/etc/apache2/sites-available/budgetcontrol.cloud.conf
docker container exec budgetcontrol-ms-authtentication service apache2 restart

echo "Build ms Workspace"
docker container cp microservices/Workspace/bin/apache/default.conf budgetcontrol-ms-workspace:/etc/apache2/sites-available/budgetcontrol.cloud.conf
docker container exec budgetcontrol-ms-workspace service apache2 restart

echo "Build ms Stats"
docker container cp microservices/Stats/bin/apache/default.conf budgetcontrol-ms-stats:/etc/apache2/sites-available/budgetcontrol.cloud.conf
docker container exec budgetcontrol-ms-stats service apache2 restart

echo "Build ms Budget"
docker container cp microservices/Budget/bin/apache/default.conf budgetcontrol-ms-budget:/etc/apache2/sites-available/budgetcontrol.cloud.conf
docker container exec budgetcontrol-ms-budget service apache2 restart

echo "Install composer"
docker exec budgetcontrol-core composer install
docker exec budgetcontrol-core php artisan migrate
docker exec budgetcontrol-core php artisan optimize

docker exec budgetcontrol-gateway composer install
docker exec budgetcontrol-gateway php artisan optimize

docker exec budgetcontrol-ms-stats composer install
docker exec budgetcontrol-ms-authtentication composer install
docker exec budgetcontrol-ms-jobs composer install
docker exec budgetcontrol-ms-workspace composer install
docker exec budgetcontrol-ms-budget composer install

echo "All done! enjoy"


