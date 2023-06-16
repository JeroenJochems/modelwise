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
            fontFamily: {
                sans: ['Futura', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'green': '#34E179'
            },
            aspectRatio: {
                'portrait': '3 / 4',
                'landscape': '4 / 3',
            },

        },
    },

    plugins: [forms],
};
