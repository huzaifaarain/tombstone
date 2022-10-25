## Tombstone Orders App

## Docker Setup ( Optional )

If you would like to run the application using docker, please follow the steps below.  

Navigate to the root directory of the application and run the following commands.

```sh
docker-compose build
docker-compose up -d
docker exec tombstone_app composer install
docker exec tombstone_app php artisan migrate
docker exec tombstone_app php artisan db:seed
docker exec tombstone_app php artisan test

```
