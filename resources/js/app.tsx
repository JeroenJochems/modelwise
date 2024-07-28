import './bootstrap';
import '../css/app.css';
import LogRocket from 'logrocket';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { installTwicpics } from "@twicpics/components/react";
import "@twicpics/components/style.css";
import { flare } from "@flareapp/js";
import { FlareErrorBoundary } from '@flareapp/react';

LogRocket.init('ovxwul/modelwise');

installTwicpics( {
    "domain": "https://mdlws.twic.pics"
} );

if (process.env.NODE_ENV === 'production') {
    flare.light('5fidD5ZckQKP2DVYtjzfXF7gDZAV5ylS');
}

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Modelwise';

const app = createInertiaApp({
    title: (title) => `${appName} ${title ? '- ' + title : ''}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(
            <FlareErrorBoundary>
                <App {...props} />
            </FlareErrorBoundary>
        );
    },
    progress: {
        color: '#4B5563',
    },
});

