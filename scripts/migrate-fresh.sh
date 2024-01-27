#!/bin/bash

php artisan migrate:fresh
php artisan migrate:fresh --env=testing
