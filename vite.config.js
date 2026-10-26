import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'

export default defineConfig({
  plugins: [
    laravel({
      input: ['src/resources/js/app.js'],
      publicDirectory: 'src/public',
      buildDirectory: 'build',
      refresh: ['src/resources/views/**/*.blade.php', 'src/resources/js/**/*.vue'],
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  build: {
    outDir: 'src/public/build',
    emptyOutDir: true,
    manifest: true,
  },
})
