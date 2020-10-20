# Statistics Restful Api


### Installation steps: 

    add a host name http://statistics-api.local
    ---------------
    composer install
    ----------------
    Add DATABASE_URL to .env
    ------------------------
    bin/console doctrine:migrations:migrate
    ---------------------------------------
    bin/console hautelook:fixtures:load
    -----------------------------------
    run php unit tests - vendor/bin/phpunit 

    
