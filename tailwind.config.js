import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Semantic color system for reusable components
                primary: {
                    50: '#f0fdfa',   // teal-50
                    100: '#ccfbf1',  // teal-100
                    200: '#99f6e4',  // teal-200
                    300: '#5eead4',  // teal-300
                    400: '#2dd4bf',  // teal-400
                    500: '#14b8a6',  // teal-500
                    600: '#0d9488',  // teal-600
                    700: '#0f766e',  // teal-700
                    800: '#115e59',  // teal-800
                    900: '#134e4a',  // teal-900
                    950: '#042f2e',  // teal-950
                },
                accent: {
                    50: '#f0fdfa',   // teal-50 for light mode highlights
                    100: '#ccfbf1',  // teal-100
                    200: '#99f6e4',  // teal-200
                    300: '#5eead4',  // teal-300
                    400: '#2dd4bf',  // teal-400
                    500: '#14b8a6',  // teal-500
                    600: '#0d9488',  // teal-600
                    700: '#0f766e',  // teal-700
                    800: '#115e59',  // teal-800 for dark mode highlights
                    900: '#134e4a',  // teal-900
                    950: '#042f2e',  // teal-950
                },
                // Keep featured/special content colors as yellow for distinction
                featured: {
                    50: '#fefce8',   // yellow-50
                    100: '#fef3c7',  // yellow-100
                    200: '#fde68a',  // yellow-200
                    300: '#fcd34d',  // yellow-300
                    400: '#fbbf24',  // yellow-400
                    500: '#f59e0b',  // yellow-500
                    600: '#d97706',  // yellow-600
                    700: '#b45309',  // yellow-700
                    800: '#92400e',  // yellow-800
                    900: '#78350f',  // yellow-900
                    950: '#451a03',  // yellow-950
                },
            },
        },
    },

    plugins: [forms],
};
