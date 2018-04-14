#!/usr/bin/env bash



alias art='php artisan'
php artisan migrate
php artisan make:migration create_codigo_lenguaje_paises_table --path=database/migrations/catalogos
php artisan migrate --path=database/migrations/catalogos
php artisan db:seed --class=InitializeCodigoLenguajePaisesSeeder

## Para UNDO: rm -rf public/storage
php artisan storage:link
## No Olvide darle permisos de lectura y escritura a la carpeta chmod +rwx public/storage

composer require "laravelcollective/remote":"^5.6.0"
php artisan vendor:publish --provider="Collective\Remote\RemoteServiceProvider"

composer require "laravelcollective/html":"^5.6.0"
php artisan vendor:publish --provider="Collective\Html\HtmlServiceProvider"

composer require doctrine/dbal

composer require yajra/laravel-datatables-oracle
php artisan vendor:publish => 9 y 11

composer require guzzlehttp/guzzle
composer require intervention/image

## Para publicar la plantilla del Email
php artisan vendor:publish --tag=laravel-notifications

php artisan vendor:publish --tag=laravel-mail

php artisan vendor:publish --tag=laravel-pagination

## GEOCODER
composer require toin0u/geocoder-laravel
php artisan vendor:publish --provider="Geocoder\Laravel\Providers\GeocoderService" --tag="config"
composer require predis/predis
en .ENV => QUEUE_DRIVER=redis






