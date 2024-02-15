const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    prefix: 'tw-', // Prefix for all classes
    important: true,
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                title: ['"Exo 2"', 'sans-serif'],
                subtitle: ['"Open Sans"', 'sans-serif'],
                body: ['"Open Sans"', 'sans-serif'],
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                grass: {
                    50: '#EBF6EE',
                    100: '#D7EDDC',
                    200: '#AFDBB9',
                    300: '#87C896',
                    400: '#32AE4F',
                    500: '#269C41',
                    600: '#228C3A',
                    700: '#1B6F2E',
                    800: '#145222',
                    900: '#0D3616',
                },
                sky: {
                    50: '#E7F3F7',
                    100: '#CFE7EE',
                    200: '#9FCEDD',
                    300: '#7BBDD1',
                    400: '#3F9EBB',
                    500: '#007EA5',
                    600: '#006E90',
                    700: '#005671',
                    800: '#081837',
                    900: '#0F3B24',
                },
                gray: {
                    50: '#FFFFFF',
                    100: '#EFEFEF',
                    200: '#CCCCCC',
                    300: '#B3B3B3',
                    400: '#999999',
                    500: '#808080',
                    600: '#666666',
                    700: '#4D4D4D',
                    800: '#333333',
                    900: '#1A1A1A',
                },
                navy: {
                    50: '#E9ECF1',
                    100: '#D3D8E3',
                    200: '#A7B2C8',
                    300: '#7B8BAC',
                    400: '#4F6491',
                    500: '#102D69',
                    600: '#060F24',
                    700: '#060F24',
                    800: '#060F24',
                    900: '#060F24',
                },
                highlight: '#269C41',
                primary: '#269C41',
                secondary: '#269C41',
                accent: '#9C27B0',
                dark: '#269C41',
                positive: '#16aa1b',
                negative: '#ff0000',
                info: '#0085ff',
                warning: '#f3b900',
            }
        }
    },

    plugins: [require('@tailwindcss/forms')],
};
