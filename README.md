# Statistics Restful Api


### Installation steps: 
    composer install
    ----------------
    Add DATABASE_URL to .env
    ------------------------
    bin/console doctrine:migrations:migrate
    ---------------------------------------
    bin/console hautelook:fixtures:load
    -----------------------------------
    run php unit tests - vendor/bin/phpunit
    
