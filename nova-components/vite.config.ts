import { defineConfig } from 'vite';
import { resolve } from "path";
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
// import fs from 'fs';
import path from 'path';

// const getAllFiles = (directory): string[] => {
//   const paths: string[] = [];
//   const throughDirectory = (directoryOrFile) => {
//     fs.readdirSync(directoryOrFile).forEach((File) => {
//       const absolute = path.join(directoryOrFile, File);
//       if (fs.statSync(absolute).isDirectory())
//         return throughDirectory(absolute);
//       else return paths.push(absolute);
//     });
//   };
//
//   throughDirectory(directory);
//
//   return paths;
// };

export default defineConfig({
  define: {
    "process.env": process.env, // Vite ditched process.env, so we need to pass it in
  },
  build: {
    outDir: resolve(__dirname, "dist"),
    emptyOutDir: true,
    target: "ES2022",
    manifest: true,
    lib: {
      entry: resolve(__dirname, "main.js"),
      name: "field",
      formats: ["umd"],
      fileName: () => "main.js",
    },
    rollupOptions: {
      input: resolve(__dirname, "main.js"),
      external: [
        "vue",
        "Nova",
        'laravel-nova',
        'laravel-nova-ui',
        'laravel-nova-util',
        'inflector-js',
      ],
      output: {
        globals: {
          vue: "Vue",
          nova: "Nova",
          'laravel-nova': 'window.LaravelNova',
          'laravel-nova-ui': 'window.LaravelNovaUi',
          'laravel-nova-util': 'window.LaravelNovaUtil',
        },
      },
    },
    copyPublicDir: false,
    chunkSizeWarningLimit: 2000,
    minify: false,
  },
  optimizeDeps: {
    include: ["vue", "@inertiajs/vue3"],
  },
  server: {
    hmr: {
      host: 'localhost',
    },
    port: 3000,
    host: 'workspace',
  },
  plugins: [
    vue({
      isProduction: true,
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  resolve: {
    alias: {
      '@fanswoo/core': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/core/src',
      ),
      '@fanswoo/ajax-submit': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/ajax-submit/src',
      ),
      '@fanswoo/component-loader': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/component-loader/src',
      ),
      '@fanswoo/control-center': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/control-center/src',
      ),
      '@fanswoo/controller': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/controller/src',
      ),
      '@fanswoo/embed': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/embed/src',
      ),
      '@fanswoo/touch': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/touch/src',
      ),
      '@fanswoo/message': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/message/src',
      ),
      '@fanswoo/shop': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/shop/src',
      ),
      '@fanswoo/html-editor': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/html-editor/src',
      ),
      '@fanswoo/editor': path.resolve(
        __dirname,
        '../node_modules/@fanswoo/editor/src',
      ),
      'vue': 'vue/dist/vue.esm-bundler.js',
      '@': '/../vendor/laravel/nova/resources/js',
    },
  },
});
