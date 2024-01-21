const mix = require('laravel-mix');

// css builder
mix.css('resources/css/main.css', 'public/build/css');

// js builder
mix.js('resources/js/main.js', 'public/build/js')
