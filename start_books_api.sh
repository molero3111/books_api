#!/bin/bash

# Run migrations
php artisan migrate

# Run seeder
php artisan db:seed

# Run laravel artisan dev server for local development
php artisan serve