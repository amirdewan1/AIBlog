/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{js,jsx,ts,tsx}"], // Ensure Tailwind scans your files
  theme: {
    extend: {
      fontFamily: {
        dosis: ["Dosis", "sans-serif"], // Add your custom font
      },
    },
  },
  plugins: [],
};
