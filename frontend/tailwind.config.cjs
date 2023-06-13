module.exports = {
    safelist: [],
    preserveHtmlElements: true,
    content: [
        './src/**/*.({vue, js})',
        './src/**/*.html',
    ],
    theme: {},
    variants: {},
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
