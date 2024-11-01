import './bootstrap';
import '../css/app.css';
import LogRocket from 'logrocket';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { installTwicpics } from "@twicpics/components/react";
import "@twicpics/components/style.css";
import * as Sentry from "@sentry/react";

LogRocket.init('ovxwul/modelwise');

installTwicpics( {
    "domain": "https://mdlws.twic.pics"
} );

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Modelwise';

Sentry.init({
    dsn: "https://2cc86025a7318db4dd1b0c5cf4293238@o4508223522275328.ingest.de.sentry.io/4508223551438928",
    integrations: [
        Sentry.browserTracingIntegration(),
        Sentry.replayIntegration(),
    ],
    tracesSampleRate: 0.1,
    replaysSessionSampleRate: 0.1, // This sets the sample rate at 10%. You may want to change it to 100% while in development and then sample at a lower rate in production.
    replaysOnErrorSampleRate: 1.0, // If you're not already sampling the entire session, change the sample rate to 100% when sampling sessions where errors occur.
});

createInertiaApp({
    title: (title) => `${appName} ${title ? '- ' + title : ''}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

