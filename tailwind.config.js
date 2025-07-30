/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
        'space-grotesk': ['Space Grotesk', 'sans-serif'],
      },
      colors: {
        primary: '#468B97',
        background: '#E0E8E9',
        accent: '#FEE500',
        'badge-superadmin': '#B22222',
        'badge-pembimbing': '#4169E1',
        'badge-asisten': '#228B22',
        'badge-praktikan': '#FFA500',
      },
      backgroundColor: {
        primary: '#468B97',
        background: '#E0E8E9',
        accent: '#FEE500',
      },
      borderColor: {
        primary: '#468B97',
      },
      animation: {
        fadeIn: 'fadeIn 0.5s',
        bounce: 'bounce 2s infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        bounce: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-20px)' },
        },
      },
    },
  },
  plugins: [],
}