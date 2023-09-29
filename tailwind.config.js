const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php',
        './app/Http/Livewire/*.php', 
        './vendor/wire-elements/pro/config/wire-elements-pro.php',
        './vendor/wire-elements/pro/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: { 
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
                blue: {...colors.blue, DEFAULT: '#3561E7' },
                lightDark: '#464E49',
                lightBackground: '#828c851a',
                lightGreen: '#52d3a233',
            }, 
        },
    },

    darkMode: 'class',

    plugins: [require('@tailwindcss/forms')({
        strategy: 'class',
      }), require('@tailwindcss/typography'),
      function({ addBase, theme }) {
        function extractColorVars(colorObj, colorGroup = '') {
          return Object.keys(colorObj).reduce((vars, colorKey) => {
            const value = colorObj[colorKey];
  
            const newVars =
              typeof value === 'string'
                ? { [`--color${colorGroup}-${colorKey}`]: value }
                : extractColorVars(value, `-${colorKey}`);
  
            return { ...vars, ...newVars };
          }, {});
        }
  
        addBase({
          ':root': extractColorVars(theme('colors')),
        });
      }],
};
