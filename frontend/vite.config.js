import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import { createSvgIconsPlugin } from 'vite-plugin-svg-icons'

export default defineConfig({
  plugins: [
    vue(),
    createSvgIconsPlugin({
      // Specify the icon folder to be cached
      iconDirs: [path.resolve(process.cwd(), 'src/assets/icons/SVG')],
      // Specify symbolId format
      symbolId: 'icon-[dir]-[name]',
      inject: 'body-last' | 'body-first',
      customDomId: '__svg__icons__dom__',
    }),
  ],
  "globals": {"__DEV__": true},
  server: {
    host: '0.0.0.0',
    port: 8080
  },

  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
    }
  },
})