export default {
  content: [
    './src/resources/views/**/*.blade.php',
    './src/resources/js/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        ink: '#172026',
        leaf: '#22715f',
        ember: '#c7663f',
        mist: '#eef3f0',
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
