# Budget tracker V2 App - BackAnd application
Opens Source MIT license project. Your Finances in One Place Set unlimited daily, weekly, monthly, or one-time budgets See every transaction, categorized automatically with tags or categories.

![version](https://img.shields.io/badge/version-1.1.1-blue.svg) ![license](https://img.shields.io/badge/license-MIT-blue.svg) <a 
href="https://github.com/budgetcontrol/services/issues?q=is%3Aopen+is%3Aissue" target="_blank">![GitHub issues](https://img.shields.io/github/issues/budgetcontrol/Services)
</a> <a href="https://github.com/budgetcontrol/services/issues?q=is%3Aissue+is%3Aclosed" target="_blank">![GitHub closed issues](https://img.shields.io/github/issues-closed/budgetcontrol/Services?color=green)
</a> <a href="https://github.com/budgetcontrol/services/issues?q=is%3Aissue+is%3Aopen+label%3Abug" target="_blank">![GitHub issues by-label](https://img.shields.io/github/issues/budgetcontrol/Services/bug?color=red)
</a><a href="https://discord.gg/jv3RayP9" target="_blank">![Chat](https://img.shields.io/badge/chat-on%20discord-7289da.svg)</a>

## Requirment
php version >= 8.2

### Installations
* Clone the repository on your computer with the command git clone git@github.com:BudgetControl/Core.git.
* Enter the repository directory with the command cd Core.
* checkout on the last stable version branch for dev environment
* Copy file .env.example on .env 
* Creation of the dockerfile container
   docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d
* Wait composer install into docker container are finished
* Restart apache
   docker exec budgetcontrol-core service apache2 restart
* Generate cache file
   docker exec budgetcontrol-core php artisan config:cache
* Make migrations
   docker exec budgetcontrol-core php artisan migrate --seed
* Enjoy
   insert url http://localhost:3000/ ( api/incoming )

"budgetcontrol-proxy" is not mandatory for dev installation
   
### Usage
* Make migration DB docker exec budget_tracker_v2-be-bemodule-1 php artisan migrate --seed

### About budget traker
BudgetTracker is developed by Marco De Felice, like a Open Source project

### Contributing
Thank you for considering contributing to the Budget tracker The contribution guide can be found in the Budget tracker documentation.

### Security Vulnerabilities
If you discover a security vulnerability within Budget tracker, please send an e-mail to marco.defelice890@gmail.com. All security vulnerabilities will be promptly addressed.

### License
The Budget tracker is open-sourced software licensed under the MIT license.

### Some develop information
Front-end is developed with Vue Notus template Back-end is developed with laravel

## Tecnology
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"$
<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
    
## Directoy
- App
 - BudgetTracker --> all methods of budget applications
  - Constants
  - Enums
  - Excpetions
  - Factories
  - Helpers
  - Http
  - Interfaces
  - Jobs
  - Models
  - Providers
  - Services
  - Rules
 - FuleTracker --> all methods of fuel tracker


## API
* GET /api/incoming 
* GET /api/expenses 
* GET /api/debit 
* GET /api/transfer 
* GET /api/planning-recursively
* GET /api/payee 
* GET /api/entry
* GET /api/categories 
* GET /api/accounts
* GET /api/labels 
* GET /api/currencies
* GET /api/model 
* GET /api/paymentstype
* GET /api/account/{id} --> retrivei nformation by account ID

* DELETE /api/entry 
* DELETE /api/planning-recursively
* DELETE /api/payee 


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

## Author
* Marco De Felice

## License
Apache License, Version 2.0
