/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./public/**/*.php",
    "./src/Views/**/*.php",
    "./public/assets/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        'nebatech-blue': '#002060',
        'nebatech-orange': '#FFA500',
        primary: {
          DEFAULT: '#002060',
          dark: '#3b82f6',
        },
        secondary: {
          DEFAULT: '#FFA500',
          dark: '#fb923c',
        },
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
