import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    plugins: [forms],

    theme: {
        extend: {
            colors: {
                lightest: '#f2f2f2',
                darkest: '#202020',
                darker: '#555555',
                lighter: '#dddddd',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                jetbrains: ['JetBrains', 'monospace'],
            },
        },
    },
};
