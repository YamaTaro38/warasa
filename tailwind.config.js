/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                // Warasa Primary Colors (Shopee Inspired)
                'warasa': {
                    orange: '#ee4d2d',
                    'orange-dark': '#c63d22',
                    'orange-light': '#ff5722',
                    blue: '#0055aa',
                    green: '#00aa5e',
                    yellow: '#f5a623',
                },
                // Light Mode Colors
                'light': {
                    bg: '#f5f5f5',
                    card: '#ffffff',
                    text: '#333333',
                    textMuted: '#666666',
                    border: '#e5e5e5',
                },
            },
            fontFamily: {
                'poppins': ['Poppins', 'sans-serif'],
                'inter': ['Inter', 'sans-serif'],
            },
            boxShadow: {
                'warasa': '0 2px 8px rgba(0,0,0,0.1)',
                'warasa-hover': '0 4px 12px rgba(238,77,45,0.2)',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
    corePlugins: {
        preflight: true,
    },
}