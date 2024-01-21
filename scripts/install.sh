#!/bin/bash

# install all application requirements
composer install
npm install --no-warnings
sh scripts/build.sh
