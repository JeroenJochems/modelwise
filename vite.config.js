import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import flareSourcemapUploader from "@flareapp/vite";

export default defineConfig({
    plugins: [
        flareSourcemapUploader({
            key: '5fidD5ZckQKP2DVYtjzfXF7gDZAV5ylS'
        }),
        laravel({
            input: 'resources/js/app.tsx',
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
        }),
        react(),
    ],
});
