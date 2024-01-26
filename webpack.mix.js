const mix = require('laravel-mix');

// build css
mix.css('resources/assets/css/main.css', 'public/build/css');
mix.css('resources/assets/css/scrollbar.css', 'public/build/css');
mix.css('resources/assets/css/error-page.css', 'public/build/css');

// copy static assets
mix.copy('resources/assets/images/*', 'public/build/images');
