import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            boxShadow: {
        'neo': '4px 4px 0px 0px rgba(0,0,0,1)', // Bayangan hitam tajam
        'neo-sm': '2px 2px 0px 0px rgba(0,0,0,1)', // Bayangan kecil untuk tombol
      },
      borderWidth: {
        '3': '3px', // Ketebalan border khas gambar
      },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
