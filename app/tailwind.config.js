/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./**/*.php'],
  theme: {
    extend: {
      fontFamily: {
        changa: ['Changa', 'sans-serif'],
        orbitron: ['Orbitron', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif'],
        pixelify: ['Pixelify Sans', 'sans-serif'],
        syne: ["Syne Mono", "monospace"],
        vt323: ["VT323", "monospace"],
      },
      dropShadow: {
        glow: [
          "0 0px 30px rgba(255, 255, 255, 0.4)",
          "0 0px 80px rgba(255, 255, 255, 0.2)"
        ]
      },
      colors: {
        eerie_black: {
          DEFAULT: '#1c1d18',
          100: '#050605',
          200: '#0b0b09',
          300: '#10110e',
          400: '#161613',
          500: '#1c1d18',
          600: '#4b4e41',
          700: '#7c806b',
          800: '#a8ab9b',
          900: '#d4d5cd',
        },
        glow_green: {
          DEFAULT: '#00ef5d',
        },
        rev_red: {
          DEFAULT: '#a60201',
          100: '#210000',
          200: '#430000',
          300: '#640101',
          400: '#860101',
          500: '#a60201',
          600: '#eb0101',
          700: '#fe3333',
          800: '#fe7777',
          900: '#ffbbbb',
        },
        amber: {
          DEFAULT: '#ffc003',
          100: '#342700',
          200: '#684e00',
          300: '#9c7500',
          400: '#d09c00',
          500: '#ffc003',
          600: '#ffcd37',
          700: '#ffda69',
          800: '#ffe69b',
          900: '#fff3cd',
        },
        black: {
          DEFAULT: '#000000',
          100: '#000000',
          200: '#000000',
          300: '#000000',
          400: '#000000',
          500: '#000000',
          600: '#333333',
          700: '#666666',
          800: '#999999',
          900: '#cccccc',
        },
      },
    },
  },
  plugins: [],
};
