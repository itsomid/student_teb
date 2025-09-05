import { fileURLToPath, URL } from 'node:url'
import { splitVendorChunkPlugin } from 'vite';
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { VitePWA } from 'vite-plugin-pwa'
import { OptionsPWA } from "./src/config/pwa.config";
import vuetify from 'vite-plugin-vuetify'
import viteCompression from 'vite-plugin-compression';
// import { visualizer } from 'rollup-plugin-visualizer';
// import viteImagemin from 'vite-plugin-imagemin';


// https://vitejs.dev/config/
export default defineConfig({
  optimizeDeps: {
    include: ['@ffmpeg/ffmpeg','vue', 'vue-router'],
  },
  plugins: [
    vue(),
    vuetify({
      autoImport: true,
      styles: {
        configFile: 'src/styles/settings.scss',
      },
    }),
    VitePWA({
      ...OptionsPWA //establish VitePWA with OptionsPWA config object
    }),
    splitVendorChunkPlugin(),
    // viteImagemin({
    //   gifsicle: { optimizationLevel: 7 },
    //   optipng: { optimizationLevel: 7 },
    //   mozjpeg: { quality: 65 },
    //   pngquant: { quality: [0.65, 0.9], speed: 4 },
    //   svgo: {
    //     plugins: [
    //       { name: 'removeViewBox', active: false },
    //       { name: 'cleanupIDs', active: true },
    //     ],
    //   },
    // }),
    viteCompression({
      algorithm: 'gzip',          // Use gzip compression
      ext: '.gz',                 // Set the extension for Gzip files
      threshold: 10240,           // Compress files larger than 10KB
      compressionOptions: { level: 9 },  // Maximum compression level for Gzip (trade-off: slower)
      deleteOriginFile: false,    // Retain the original files (keep .js/.css along with .gz)
    }),
    viteCompression({
      algorithm: 'brotliCompress', // Brotli as an alternative for modern browsers
      ext: '.br',                   // Extension for Brotli files
      threshold: 10240,             // Compress files larger than 10KB
      compressionOptions: { level: 11 }, // Maximum Brotli compression level
      deleteOriginFile: false,      // Retain the original files
    }),
    // visualizer({
    //   filename: './dist/stats.html',
    //   open: true,
    //   template: 'treemap', // Can be 'sunburst', 'treemap', 'network'
    //   gzipSize: true, // Show gzip sizes
    //   brotliSize: true, // Show Brotli sizes
    // }),
    // removeConsole()
  ],
  css: {
    preprocessorOptions: {
      scss: {
        // additionalData: `@import "@/assets/styles/components/_variables.scss";` // Load global SCSS variables
      },
    },
    devSourcemap: false, // Disable source maps for CSS in production
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
      '@assets': fileURLToPath(new URL('./src/assets', import.meta.url))
    }
  },

  build: {
    cssCodeSplit: true, // Split CSS into separate files for each component
    assetsInlineLimit: 4096, // Inline assets smaller than 4KB
    sourcemap: false,  // Disable source maps in production for smaller files
    minify: 'terser',
    chunkSizeWarningLimit: 2000,  // Increase chunk size limit to prevent warnings
    rollupOptions: {
      output: {
        manualChunks(id) {
          if (id.includes('node_modules')) {
            return id.toString().split('node_modules/')[1].split('/')[0].toString();
          }
        },
        // Enable long-term caching for static assets
        // assetFileNames: '[name].[hash].[ext]',
        // chunkFileNames: '[name].[hash].js',
        // entryFileNames: '[name].[hash].js',
      },
    },
    terserOptions: {
      compress: {
        drop_console: false, // Remove console logs in production
        drop_debugger: true, // Remove debugger statements in production
      },
      format: {
        comments: false, // Remove comments to reduce bundle size
      },
    },
  },
  server: {
    hmr: {
      protocol: 'ws', // Use WebSocket for fast hot module replacement (HMR)
    },
  },
})
