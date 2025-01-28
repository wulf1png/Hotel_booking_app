const mix = require('laravel-mix');

// Укажите путь к вашему исходному CSS файлу и путь, куда он должен быть скомпилирован
mix.styles('resources/css/styles.css', 'public/css/styles.css');
