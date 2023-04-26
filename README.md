# Pokemon test App
Piccola e preve applicazione di TEST per permettere la creazione e modifica di un team polemon

## Requisiti
php versione >= 8.2

Installazione
* Clona il repository sul tuo computer con il comando git clone https://github.com/NOME-REPOSITORY.git.
* Entra nella directory del repository con il comando cd NOME-REPOSITORY.
* Creazione del container dockerfile
  docker-compose up -d

## Utilizzo
* Lancia il server su http://localhost:8888
* Accedi alla pagina di creazione delle squadre.
* Seleziona i Pokémon che desideri aggiungere alla tua squadra cliccando sul bottone GottaCatch.
* Visualizza la tua squadra nella pagina delle squadre salvate.

## API
* GET /api/getPokemons ritorna in modo randomico un pokemon
* POST /api/savePokemon aggiorna o crea un nuovo dato
* DELETE /api/savePokemon elimina il dato specifico

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
