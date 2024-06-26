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
            colors: {
                'primary': '#669DAE',
                'ground': '#24373C',
                'surface': '#324C53',
                'border': '#607176',
                'heading': '#ffffff',
                'paragraph': '#dee1e2'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                yellowtail: ['Yellowtail', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
