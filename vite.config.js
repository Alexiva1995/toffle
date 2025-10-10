import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/scss/style-rtl.scss',
                'resources/assets/scss/style.scss',
                'resources/sass/base/custom-rtl.scss',
                'resources/sass/core.scss',
                'resources/sass/overrides.scss',
                'resources/assets/js/scripts.js',
                'resources/js/core/app-menu.js',
                'resources/js/core/app.js',
            ],
            refresh: true,
        }),
    ],
});
