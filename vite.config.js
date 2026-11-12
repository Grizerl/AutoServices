import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Auth pages (Bootstrap 5)
                'resources/sass/app.scss',
                'resources/js/app.js',
                // Public website
                'resources/scss/site.scss',
                // Admin panel overrides (on top of AdminLTE)
                'resources/scss/admin.scss',
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern',
                // Bootstrap 5 still ships deprecated Sass APIs
                quietDeps: true,
                silenceDeprecations: ['import', 'mixed-decls', 'color-functions', 'global-builtin', 'legacy-js-api'],
            },
        },
    },
});
