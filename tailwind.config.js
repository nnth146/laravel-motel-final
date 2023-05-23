/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        'yellow' : '#FEFF86',
        'light-blue' : '#B0DAFF',
        'navy-blue' : '#19A7CE',
        'dark-blue' : '#146C94',
      }
    },
  },
  plugins: [
    require('tailwind-scrollbar-hide'),
  ],
}

