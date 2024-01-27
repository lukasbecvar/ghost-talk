#!/bin/bash

php artisan migrate
php artisan migrate --env=testing
