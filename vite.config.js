import { defineConfig } from 'vite';

import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server:{
        hmr:{
            host:'192.168.1.27',
            port:8000,
            
        }
    },
    plugins: [
       
          

    
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});