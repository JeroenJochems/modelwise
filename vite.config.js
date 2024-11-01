import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import { sentryVitePlugin } from "@sentry/vite-plugin";

export default defineConfig({
    build: {
        sourcemap: true,
    },
    plugins: [
        sentryVitePlugin({
            org: "modelwise",
            project: "frontend",
            authToken: process.env.SENTRY_AUTH_TOKEN,
        }),
        laravel({
            input: 'resources/js/app.tsx',
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
        }),
        react(),
    ],
});
