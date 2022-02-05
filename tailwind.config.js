const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    content: [
        './packages/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                gray: colors.stone,
                primary: colors.yellow,
                success: colors.green,
                warning: colors.amber,
            },
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
            height: {
                '[4rem]': '4rem'
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
