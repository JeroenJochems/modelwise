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
        {
            pattern: /grid-cols-.+/,
            variants: ['sm'],
        },
        {
            pattern: /grid-cols-.+/,
        },
        {
            pattern: /line-clamp-.+/,
        },
    ],

    theme: {
        extend: {
            "boxShadow": {
                "outline": "0 4px 34px 10px rgb(0 0 0 / 0.07)",
            },
            fontFamily: {
                sans: ['Futura', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                green: '#34E179',
                teal: '#0D4F5E',
                'teal-light': '#0F5767',
                'teal-200': '#CFDCDF',
                'teal-100': '#E7EDEF',
            },
            width: {
                '128': '32rem',
                '144': '36rem',
            }
        },
    },

    plugins: [forms],
};
