<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background text-foreground flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col">
        <div class="max-w-xl w-full mx-auto text-center">
            <h1 class="text-3xl font-semibold mb-4">Laravel</h1>
            <p class="text-muted-foreground">Welcome to your normal Laravel PHP application with local Tailwind CSS.</p>
        </div>
    </body>
</html>
