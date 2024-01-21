#!/bin/bash

clear

yellow_echo () { echo "\033[33m\033[1m$1\033[0m"; }

# PHPUnit run tests
yellow_echo 'PHPUnit: testing...'
php artisan test

