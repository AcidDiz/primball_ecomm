/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './src/**/*.{html,js}',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './node_modules/tw-elements/dist/js/**/*.js'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'progress': 'progress 1s ease-in-out infinite',
            },
            keyframes: {
                progress: {
                    '0%': { width:'0%' , marginLeft:'0%' },
                    '25%': { marginLeft:'0%' },
                    '100%': { width:'35%' , marginLeft:'65%' },

                }
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('tw-elements/dist/plugin')],
};
