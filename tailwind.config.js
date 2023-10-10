const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/power-components/livewire-powergrid/resources/views/**/*.php",
        "./vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php",
        "./app/Http/Livewire/*.php",
        "./vendor/wire-elements/pro/config/wire-elements-pro.php",
        "./vendor/wire-elements/pro/**/*.blade.php",
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
                    medium: "#828C85",
                },
                green: {
                    ...defaultTheme.colors.green,
                    DEFAULT: "#13B05B",
                    light: "#52D3A233",
                    light2: "#9edfc6",
                    dark: "#52D3A2",
                },
                red: {
                    ...defaultTheme.colors.red,
                    DEFAULT: "#C22929",
                },
            },
            fontSize: {
                xs: "10px",
                sm: "12px",
                base: "14px",
                md: "16px",
                lg: "20px",
                xl: "24px",
            },
            borderRadius: {
                sm2: "4px",
            },
            screens: {
                ...defaultTheme.screens,
                xs: "430px",
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
