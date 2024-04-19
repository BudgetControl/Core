# Budget Control V3 Core Application
Opens Source MIT license project. Your Finances in One Place Set unlimited daily, weekly, monthly, or one-time budgets See every transaction, categorized automatically with tags or categories.

![version](https://img.shields.io/badge/version-2.2.2-blue.svg) ![license](https://img.shields.io/badge/license-MIT-blue.svg) <a 
href="https://github.com/budgetcontrol/services/issues?q=is%3Aopen+is%3Aissue" target="_blank">![GitHub issues](https://img.shields.io/github/issues/budgetcontrol/Services)
</a> <a href="https://github.com/budgetcontrol/services/issues?q=is%3Aissue+is%3Aclosed" target="_blank">![GitHub closed issues](https://img.shields.io/github/issues-closed/budgetcontrol/Services?color=green)
</a> <a href="https://github.com/budgetcontrol/services/issues?q=is%3Aissue+is%3Aopen+label%3Abug" target="_blank">![GitHub issues by-label](https://img.shields.io/github/issues/budgetcontrol/Services/bug?color=red)
</a><a href="https://discord.gg/TtMTeUbSpW" target="_blank">![Chat](https://img.shields.io/badge/chat-on%20discord-7289da.svg)</a>

## Microservice Architecture
The Budget Control V3.0 is designed using a microservice architecture, which allows for better scalability, flexibility, and maintainability of the application. The application is divided into multiple independent services, each responsible for a specific functionality.

## Requirment
php version >= 8.2

### Installations
* Clone the repository on your computer with the command git clone git@github.com:BudgetControl/Core.git.
* Enter the repository directory with the command cd Core.
* Checkout on the last stable version branch for dev environment or last tag version
* Copy file .env.example on .env 
* Creation of the dockerfile container
   run task build:dev for dev enviroment
* Wait composer install into docker container are finished
* Generate cache file
   docker exec budgetcontrol-core php artisan config:cache
* Make migrations
   docker exec budgetcontrol-core php artisan migrate --seed
* Clean cache files
   docker exec budgetcontrol-core php artisan optimize
* Enjoy
   insert url http://localhost:3000/ ( api/incoming )

"budgetcontrol-proxy" is not mandatory for dev installation
   
### Usage
Go to http://localhost or your desidered domain and enjoy the application
* Make migration DB docker exec budgetcontrol-core php artisan migrate --seed

### About budget control
BudgetControl is developed by Marco De Felice, like a Open Source project


### Contributing
Thank you for considering contributing to the Budget tracker The contribution guide can be found in the Budget tracker documentation.

### Security Vulnerabilities
If you discover a security vulnerability within Budget tracker, please send an e-mail to marco.defelice890@gmail.com. All security vulnerabilities will be promptly addressed.

### License
The Budget Control is open-sourced software licensed under the MIT license.

### Some develop information
Front-end is developed with Vue Notus template Back-end is developed with laravel
- **FE-REPO** https://github.com/BudgetControl/Pwa

## Tecnology
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"$
<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Key Features
- **Improved Performance**: The microservice architecture enables better performance by allowing each service to scale independently based on its specific needs.
- **Enhanced Scalability**: With the microservice architecture, it is easier to scale individual services based on demand, ensuring optimal performance even during high traffic periods.
- **Modular Development**: Each service in the microservice architecture can be developed and deployed independently, enabling faster development cycles and easier maintenance.
- **Service Independence**: The microservice architecture allows for independent deployment and scaling of services, reducing the impact of failures and enabling seamless updates and maintenance.
- **Flexibility**: The microservice architecture provides the flexibility to use different technologies and programming languages for each service, based on their specific requirements.
- **Improved Fault Isolation**: With the microservice architecture, failures in one service do not affect the entire application, ensuring better fault isolation and improved overall reliability.

## Microservice list
/**
 * This section contains the following components:
 * - Gateway: Handles communication between the application and external systems.
 * - Authentication: Manages user authentication and authorization.
 * - Stats: Provides statistical data and analytics for the application.
 * - Workspace: Handles the creation and management of user workspaces.
 */

## DEBUG MODE WITH Xdebug
You can set-up xdebug interactive debuging mode

1. configure your IDE for every microservice

### Xdebug configuration to insert in your IDE ( visual-studio )
{
    "name": "Listen for Xdebug",
    "type": "php",
    "request": "launch",
    "port": 9003,
    "pathMappings": {
        "/var/www/workdir": "${workspaceRoot}",
    }
}

### Xdebug configuration for IDE ( php storm )
https://www.jetbrains.com/help/phpstorm/troubleshooting-php-debugging.html#no-debug-server-is-configured% 

### Test with mailhog service
You can use an fake mailhog server
- docker run --rm -d --name mailhog -p 8025:8025 -p 1025:1025 mailhog/mailhog
- docker network connect [network_name] mailhog

## Author
* Marco De Felice

## Contributing
We welcome contributions to Budget tracker V3.0. Please refer to the contribution guide in the project documentation for more information on how to contribute.

## Security Vulnerabilities
If you discover any security vulnerabilities in Budget tracker V3.0, please report them to the project team immediately. We take security seriously and will address any vulnerabilities promptly.

## License
Budget tracker V3.0 is open-source software licensed under the MIT license.
