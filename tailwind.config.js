const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    content: [
        '../laravel-filament-admin/resources/**/*.blade.php',
        '../laravel-filament-forms/resources/**/*.blade.php',
        '../laravel-filament-tables/resources/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                error: colors.red,
                danger: colors.rose,
                gray: colors.stone,
                primary: colors.teal,
                secondary: colors.amber,
                accent: colors.pink,
                success: colors.green,
                warning: colors.amber,
            },
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
