import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            '$': 'jQuery',
            '@': '/resources/js',
            'assets': path.resolve(__dirname, 'resources/js/argon/assets'),
            'components': path.resolve(__dirname, 'resources/js/argon/components'),
            'context': path.resolve(__dirname, 'resources/js/argon/context'),
            'examples': path.resolve(__dirname, 'resources/js/argon/examples'),
            'layouts': path.resolve(__dirname, 'resources/js/argon/layouts'),
        },
    },
});

