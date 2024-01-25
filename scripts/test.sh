#!/bin/bash

clear

yellow_echo () { echo "\033[33m\033[1m$1\033[0m"; }

# PHPstan run tests
yellow_echo 'PHPstan: testing...'
php vendor/bin/phpstan analyze

# PHPUnit run tests
yellow_echo 'PHPUnit: testing...'
php artisan test
