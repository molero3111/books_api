#!/bin/bash

# Run migrations
php artisan migrate

# Run seeder
php artisan db:seed