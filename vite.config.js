import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/chosen-sprite.png', 
                'resources/css/chosen.css', 
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/chosen.jquery.js',
                'resources/js/config-km.js',
                'resources/js/unidades.js',
            ],
            refresh: true,
        }),
    ],
});
