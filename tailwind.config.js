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
    safelist: [
        'grid-cols-1',
        'grid-cols-2',
        'grid-cols-3',
        'grid-cols-4',
        'grid-cols-5',
        'grid-cols-6',
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
            width: {
                '128': '32rem',
                '144': '36rem',
            }
        },
    },

    plugins: [forms],
};
