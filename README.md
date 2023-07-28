# Budget tracker V2 App - BackAnd application
Opens Source MIT license project. Your Finances in One Place Set unlimited daily, weekly, monthly, or one-time budgets See every transaction, categorized automatically with tags or categories.

![version](https://img.shields.io/badge/version-1.0-blue.svg) ![license](https://img.shields.io/badge/license-MIT-blue.svg) <a href="https://github.com/marcodefelice/budgetcontrol-service/issues?q=is%3Aopen+is%3Aissue" target="_blank">![GitHub issues open](https://img.shields.io/github/issues/creativetimofficial/vue-notus.svg)</a> <a href="https://github.com/marcodefelice/budgetcontrol-service/issues?q=is%3Aissue+is%3Aclosed" target="_blank">![GitHub issues closed](https://img.shields.io/github/issues-closed-raw/creativetimofficial/vue-notus.svg)</a>  <a href="https://discord.gg/jv3RayP9" target="_blank">![Chat](https://img.shields.io/badge/chat-on%20discord-7289da.svg)</a>

## Requirment
php version >= 8.2

###Installations
* Clone the repository on your computer with the command git clone https://github.com/REPOSITORY-NAME.git.
* Enter the repository directory with the command cd REPOSITORY-NAME.
* Copy file .env.example on .env 
* Creation of the dockerfile container
   docker-compose up -d
* Generate cache file
   docker exec budgettrackerv2_bemodule_1 php artisan confic:cache
* Make migrations
   docker exec budgettrackerv2_bemodule_1 php artisan migrate --seed
* Enjoy
   insert utl http://localhost:3333/ ( api/incoming )
   
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

### Struttura delle directory
_ node_modules: contiene tutte le dipendenze del progetto installate tramite npm.
_ public: contiene file statici accessibili direttamente dal client (es. immagini, file CSS, JavaScript).
_ data: contiene i dati salvati dall'applicazione in formato JSON
_ components: contiene i componenti dell'applicazione.
__ buttons: contiene i pulsanti e le action dell'applicazione.
__ cards: contiene le card specifiche e stilizzate
__ table: contiene tabelle ed elementi tabellari per le pagine
_ pages: contiene le views dell'applicazione
_ services: qui vengono implementati tutti i vari servizi

## Tecnologie utilizzate
php - laravel 10

## Autori
* Marco De Felice

## Licenza
Apache License, Version 2.0
