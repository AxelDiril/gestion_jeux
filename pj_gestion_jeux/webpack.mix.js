// webpack.mix.js

const mix = require('laravel-mix');

mix
  .js('resources/js/app.js', 'public/js') // Compile JavaScript
  .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'), // Make sure imports are handled correctly
    // Tailwind is optional if you're using it, remove if not
    require('tailwindcss') // Optional, only needed if you're using Tailwind
  ]);
