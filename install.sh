#!/bin/bash

# Set the default environment and pwa serving mode
env="dev"
pwa="apache"

# Check if the ../Pwa directory exists at the parent level
if [ ! -d "../Pwa" ]; then
  echo "Directory ../Pwa not found. Cloning the project from GitHub..."
  git clone git@github.com:BudgetControl/Pwa.git ../Pwa
fi

# Function to show command usage
usage() {
  echo "Usage: $0 [-e environment | --env environment] [-p pwa serving mode | --pwa pwa serving mode]"
  echo "Environments: dev, prod"
  echo "Serving modes: apache, node"
  exit 1
}

# Parsing command line arguments
while [[ "$#" -gt 0 ]]; do
  case $1 in
    -e|--env)
      if [ -n "$2" ] && [[ $2 != -* ]]; then
        env="$2"
        shift 2
      else
        echo "Error: Missing value for $1"
        usage
      fi
      ;;
    -p|--pwa)
      if [ -n "$2" ] && [[ $2 != -* ]]; then
        pwa="$2"
        shift 2
      else
        echo "Error: Missing value for $1"
        usage
      fi
      ;;
    *)
      echo "Error: Unknown parameter: $1"
      usage
      ;;
  esac
done

# Destroy all containers
docker-compose down

# Function to wait for all containers to be running
docker-compose.yaml() {
  local container_names=(
    "budgetcontrol-core"
    "budgetcontrol-gateway"
    "budgetcontrol-ms-authentication"
    "budgetcontrol-ms-workspace"
    "budgetcontrol-ms-stats"
    "budgetcontrol-ms-budget"
    "budgetcontrol-ms-entries"
    "budgetcontrol-ms-wallets"
    "budgetcontrol-ms-searchengine"
    "budgetcontrol-pwa"
  )

  all_running=true
  for container_name in "${container_names[@]}"; do
    status=$(docker inspect -f '{{.State.Status}}' $container_name)
    echo "Container $container_name status: $status"
    if [ "$status" != "running" ]; then
      all_running=false
      break
    fi
  done

  if [ "$all_running" = true ]; then
    echo "All containers are running."
  else
    echo "Not all containers are running."
  fi
}

# Show the selected environment
echo "Installing $env environment"

# Add logic for specific environment
case $env in
  dev)
    echo "Setting up DEV environment"
    docker-compose -f docker-compose.yml -f docker-compose.database.yml -f docker-compose.dev.yml up -d
    
    docker container cp bin/apache/default.conf budgetcontrol-core:/etc/apache2/sites-available/budgetcontrol.cloud.conf
    ;;
  prod)
    echo "Setting up PROD environment"
    docker-compose -f docker-compose.yml -f docker-compose.database.yml up -d
    
    docker container cp bin/apache/default.conf budgetcontrol-core:/etc/apache2/sites-available/budgetcontrol.cloud.conf
    ;;
  *)
    echo "Unknown environment: $env"
    usage
    ;;
esac

echo "Build Gateway"
docker container cp microservices/Gateway/bin/apache/default.conf budgetcontrol-gateway:/etc/apache2/sites-available/budgetcontrol.cloud.conf

echo "Build ms Authentication"
docker container cp microservices/Authentication/bin/apache/default.conf budgetcontrol-ms-authentication:/etc/apache2/sites-available/budgetcontrol.cloud.conf

echo "Build ms Workspace"
docker container cp microservices/Workspace/bin/apache/default.conf budgetcontrol-ms-workspace:/etc/apache2/sites-available/budgetcontrol.cloud.conf

echo "Build ms Stats"
docker container cp microservices/Stats/bin/apache/default.conf budgetcontrol-ms-stats:/etc/apache2/sites-available/budgetcontrol.cloud.conf

echo "Build ms Budget"
docker container cp microservices/Budget/bin/apache/default.conf budgetcontrol-ms-budget:/etc/apache2/sites-available/budgetcontrol.cloud.conf

echo "Build ms Entries"
docker container cp microservices/Entries/bin/apache/default.conf budgetcontrol-ms-entries:/etc/apache2/sites-available/budgetcontrol.cloud.conf

echo "Build ms Wallets"
docker container cp microservices/Wallets/bin/apache/default.conf budgetcontrol-ms-wallets:/etc/apache2/sites-available/budgetcontrol.cloud.conf

echo "Build ms Search Engine"
docker container cp microservices/SearchEngine/bin/apache/default.conf budgetcontrol-ms-searchengine:/etc/apache2/sites-available/budgetcontrol.cloud.conf

echo "Install composer and run migrations"
docker exec budgetcontrol-core composer install
docker exec budgetcontrol-core php artisan migrate
docker exec budgetcontrol-core php artisan optimize

docker exec budgetcontrol-gateway composer install
docker exec budgetcontrol-gateway php artisan optimize

docker exec budgetcontrol-ms-stats composer install
docker exec budgetcontrol-ms-authentication composer install
docker exec budgetcontrol-ms-jobs composer install
docker exec budgetcontrol-ms-workspace composer install
docker exec budgetcontrol-ms-budget composer install
docker exec budgetcontrol-ms-entries composer install
docker exec budgetcontrol-ms-wallets composer install
docker exec budgetcontrol-ms-searchengine composer install

cd ../Pwa || { echo "Directory ../Pwa not found"; exit 1; }
docker-compose down
echo "Building PWA image"

case $pwa in
  apache)
    echo "Serve PWA in Apache"
    docker-compose -f docker-compose.apache.yaml up -d
    docker container cp ../Pwa/bin/apache/default.conf budgetcontrol-pwa:/etc/apache2/sites-available/budgetcontrol.cloud.conf
    docker container exec budgetcontrol-pwa service apache2 restart
    ;;
  node)
    echo "Serve PWA in Node"
    docker-compose -f docker-compose.yaml up -d
    
    ;;
  *)
    echo "Unknown serve mode for pwa: $pwa"
    usage
    ;;
esac

echo "Restart all services"
docker container exec budgetcontrol-core service apache2 restart
docker container exec budgetcontrol-gateway service apache2 restart
docker container exec budgetcontrol-ms-authentication service apache2 restart
docker container exec budgetcontrol-ms-workspace service apache2 restart
docker container exec budgetcontrol-ms-stats service apache2 restart
docker container exec budgetcontrol-ms-budget service apache2 restart
docker container exec budgetcontrol-ms-entries service apache2 restart
docker container exec budgetcontrol-ms-wallets service apache2 restart
docker container exec budgetcontrol-ms-searchengine service apache2 restart

docker container restart budgetcontrol-proxy

echo "All done! Enjoy"

