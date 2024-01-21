#!/bin/bash

# clean app & cache
php artisan schedule:clear-cache  
php artisan optimize:clear  
php artisan session:clear 
php artisan config:clear  
php artisan cache:clear  
php artisan event:clear  
php artisan route:clear  
php artisan view:clear 
php artisan log:clear 
