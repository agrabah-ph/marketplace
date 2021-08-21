# Agrabah Traceability

Agrabah Traceability allows community leaders to trace the delivery of a produce from the farmer to the market.

Agrabah was created to empower Filipino Farmers & Fisherfolks to steadily earn fair profit through online platforms that connect them to partners and consumers.

Products are directly sourced from more than 5,000 farmers and fisherfolks nationwide across the Philippines and growing. Agrabah provides farmers with a stable market channel which allows for inclusive economic growth.

Agrabah knows that with a better marketplace, we can help our Filipino farmers and fisher folks enjoy a sustained and rewarding livelihood.

# Getting Started - Local Development

**INSTALL THE FOLLOWING GLOBAL DEPENDENCIES**

* **laradock

## Laradock usage
1. in the agrabah parent folder, run ```git clone https://github.com/Laradock/laradock.git```
1. add ```127.0.0.1 agrabah-trace.test``` in hosts
1. update agrabah-trace/.env
    ```
    DB_HOST=mysql
    DB_PASSWORD=root
    ```
1. create agrabah-trace.conf in laradock/apache2
    ```
      ServerName agrabah-trace.test
      DocumentRoot /var/www/agrabah/public/
    ```
1. change to PHP v7.3 rename laradock/.env.example to .env and update laradock/.env
    ```
    PHP_VERSION=7.3
    ```
    run ```docker-compose build php-fpm``` 
1. run ```docker-compose build workspace```
1. go to laradock folder and run ```docker-compose up -d apache2 mysql```
1. run ```docker-compose exec workspace bash```
1. go to /var/www/agrabah-trace
1. install dependencies with ```composer install```    
1. if database is empty, install migration with ```artisan migrate:install```
1. run migration ```artisan migrate```
1. browse to http://agrabah-trace.test