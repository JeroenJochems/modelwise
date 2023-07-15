<!DOCTYPE html>
<html class="min-h-full" lang="x {{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>Modelwise</title>

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.tsx', "resources/js/Pages/{$page['component']}.tsx"])
        @inertiaHead

    </head>
    <body class="min-w-full min-h-full font-sans antialiased">
        @inertia
    </body>
</html>
