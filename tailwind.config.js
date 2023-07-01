import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.tsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Futura', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                green: '#34E179',
                teal: '#0D4F5E',
                'teal-light': '#0F5767',
            },
        },
    },

    plugins: [forms],
};
