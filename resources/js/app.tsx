import './bootstrap';
import '../css/app.css';
import LogRocket from 'logrocket';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { installTwicpics } from "@twicpics/components/react";
import "@twicpics/components/style.css";

LogRocket.init('ovxwul/modelwise');

installTwicpics( {
    "domain": "https://mdlws.twic.pics"
} );

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Modelwise';

const app = createInertiaApp({
    title: (title) => `${appName} 📸 ${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

