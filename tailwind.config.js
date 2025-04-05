/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './templates/**/*.html.twig', // All Twig templates
    './assets/**/*.js',           // JavaScript files
    './assets/**/*.vue',          // Vue files (if applicable)
    './assets/**/*.css',          // Include any CSS files
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

