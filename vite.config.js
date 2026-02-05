import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/css/app-rtl.scss',
                'resources/js/app.js',
                'resources/js/scripts/tables/table-datatables-basic.js',
                'resources/js/scripts/tables/table-datatables-advanced.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@sass': path.resolve(__dirname, 'resources/sass'),
            '@assets': path.resolve(__dirname, 'resources/assets'),
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                includePaths: [
                    path.resolve(__dirname, 'node_modules'),
                    path.resolve(__dirname, 'resources/assets'),
                    path.resolve(__dirname, 'resources/sass/base'),
                ],
                // Silencia deprecaciones de Sass (Bootstrap 5.0.1 y tema Vuexy usan sintaxis antigua)
                silenceDeprecations: [
                    'legacy-js-api',
                    'import',
                    'if-function',
                    'global-builtin',
                    'slash-div',
                    'color-functions',
                    'function-units',
                    'abs-percent',
                ],
            },
        },
    },
});
