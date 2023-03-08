
# Laravel Test
This is a Laravel app with Profile and Reports Crud.

### Installation
Clone Repository
```sh
git clone https://github.com/BrunoSantanaDeveloper/laravel-test.git laravel-test
```
```sh
cd laravel-test/
```


Switch to main branch
```sh
git checkout main
```


Remove versioning (optional)
```sh
rm -rf .git/
```


Create the .env File
```sh
cp .env.example .env
```


Update .env file environment variables
```dosini
APP_NAME="Laravel-Test"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```


Upload the project containers
```sh
docker-compose up -d
```


Access the app container with bash
```sh
docker-compose exec app bash
```


Install project dependencies
```sh
composer install
```


Generate the Laravel project key
```sh
php artisan key:generate
```


It's done, Access the project:
[http://localhost:8989](http://localhost:8989)
