import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': '/src',
    },
  },
  server: {
    host: 'localhost',
    port: 5173,
    proxy: {
      '/api': {
        target: 'https://freelanceflow-6smh.onrender.com',
        changeOrigin: true,
        secure: false,
      },
      '/sanctum': {
        target: 'https://freelanceflow-6smh.onrender.com',
        changeOrigin: true,
        secure: false,
      },
    },
  },
})