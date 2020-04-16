# STAYHOME Server-Side

HOSTED AT: https://api.peymen.com
## Application (Client) repository: https://github.com/MoonfireSeco/PokemonStop

Here is the back-end service for the #StayHome: The Game application, it was build with the Lumen micro-framework PHP. Why a micro-framework, because it gets rid of some unnecessary libs (optimisation they said :))

## What does every folder do?
In the /app folder you will find the brain of this whole eco-system. The controllers or the main logic is placed in the app/Http/Controllers. Also there are used some Model classes for the database communication based on the Eloquent ORM, and also a helper file in the /app folder in which we make some maths.

The /public and /bootstrap are practly the initializers for the vendor, and the app it-self.
/storage it is used for caching and other things in most part (eg. caching routes - for production)
/routes it has the web.php the place where the api routes are placed
/database it is used in this project only with the migrations, because if you want to turn on the api in localhost, this will make
the structure of your database, by using the command in any terminal:
```
php artisan migrate
```
In rest the files like composer.json are used for the PHP dependencies.

## Requires
PHP >= 7.2
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Composer PHP Dependency Manager

## How to open it in localhost
First of all use ``` composer install ``` to install the dependencies after that ``` cp .env.example .env ``` and then enter in the .env file complet your MYSQL credentials and you are ready to make the database structure ``` php artisan migrate ```. After that it should run up by using ``` php -S localhost:8000 -t public ```, and that's all check http://localhost:8000.
