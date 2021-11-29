# Agrabah Wharf

This project contains 3 main services, Reverse Bidding, Auction and Marketplace. The goal is to connect all the services together as one complete application.

**Reverse Bidding** allows clients to post their purchase orders and let our community leaders bid for the best possible price.

**Auction** posted by the community leaders the products are from our own farmers and will make sure that the transaction will be on the same day, fresh.

**Marketplace** is a simplified ecommerce like application that are listed by the community leaders with a simple and informative order tracking system.

#Requirements

1. Composer - https://getcomposer.org/
1. PHP 7.2^ - preferred tools (ex: xampp, laragon, docker)
1. Pusher Credentials -  https://pusher.com/

# Getting Started

###Cloning from Repo

1. Open Git Bash
1. Change the current working directory to the location where you want the cloned directory.
1. Type in "git clone https://github.com/agrabah-ph/marketplace.git"

### Config ENV 

1. Copy .env.example and name it as .env
1. Update the DB_* configuration with your current DB setting
1. Update the APP_URL with your current url
1. Update pusher configuration with PUSHER_APP_*

### Installing Dependency

1. composer install
1. php artisan key:generate
1. php artisan migrate
1. php artisan db:seed

### Unit/Feature Test

>php unit test

