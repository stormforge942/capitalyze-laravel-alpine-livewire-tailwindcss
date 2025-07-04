const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./app/Powergrid/CustomTheme.php",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/*.blade.php",
        "./vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php",
        "./app/Http/Livewire/**/*.php",
        "./vendor/wire-elements/pro/config/wire-elements-pro.php",
        "./vendor/wire-elements/pro/**/*.blade.php",
    ],

    safelist: [
        '[&>div]:justify-end',
        'text-right',
        'text-[#0000FF]',
        'border-[#0000FF]'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                danger: '#E40C0C',
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
                blue: {
                    ...defaultTheme.colors.blue,
                    DEFAULT: "#3561E7",
                    light: "#52C6FF1A",
                },
                'pg-primary': colors.gray,
                gray: {
                    ...defaultTheme.colors.gray,
                    light: "#F5F5F5",
                    medium: "#D2D6D2",
                    medium2: "#828C85",
                    dark: "#A6ACA8",
                },
                dark: {
                    DEFAULT: "#121A0F",
                    light: "#1B2718",
                    light2: "#464E49",
                    lighter: "#9DA3A8",
                },
                green: {
                    ...defaultTheme.colors.green,
                    DEFAULT: "#13B05B",
                    light: "#52D3A233",
                    light2: "#9edfc6",
                    light3: "#52D3A2",
                    light4: "#DCF6EC",
                    dark: "#52D3A2",
                    muted: "#D4DDD7",
                },
                red: {
                    ...defaultTheme.colors.red,
                    DEFAULT: "#C22929",
                },
            },
            fontSize: {
                xs: "0.625rem",
                "xs+": "0.6875rem",
                sm: "0.75rem",
                "sm+": "0.8125rem",
                base: "0.875rem",
                md: "1rem",
                lg: "1.25rem",
                xl: "1.5rem",
            },
            borderRadius: {
                sm2: "4px",
            },
            screens: {
                ...defaultTheme.screens,
                xs: "430px",
            },
            width: {
                '5/9': '55.5555556%',
                '11/15': '73.3333333%',
                '4/9': '44.4444444%',
                '4/15': '26.6666667%',
            },
            height: {
                'screen/2': '50vh',
            }
        },
    },

    darkMode: "class",

    plugins: [
        require("@tailwindcss/forms")({
            strategy: "class",
        }),
        require("@tailwindcss/typography"),
        function ({ addBase, theme }) {
            function extractColorVars(colorObj, colorGroup = "") {
                return Object.keys(colorObj).reduce((vars, colorKey) => {
                    const value = colorObj[colorKey];

                    const newVars =
                        typeof value === "string"
                            ? { [`--color${colorGroup}-${colorKey}`]: value }
                            : extractColorVars(value, `-${colorKey}`);

                    return { ...vars, ...newVars };
                }, {});
            }

            addBase({
                ":root": extractColorVars(theme("colors")),
            });
        },
    ],
};
