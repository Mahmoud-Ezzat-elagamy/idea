<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Idea</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground min-h-screen">

<x-layouts.nav />

<main class="max-w-7xl mx-auto px-6">
    {{ $slot }}
</main>

{{-- Toast Messages --}}
<div class="fixed bottom-4 right-4 z-50 flex flex-col gap-2">
    @session('success')
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="rounded-lg bg-emerald-600 px-4 py-3 text-white shadow-xl">
        {{ $value }}
    </div>
    @endsession

    @error('error')
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="rounded-lg bg-red-600 px-4 py-3 text-white shadow-xl">
        {{ $message }}
    </div>
    @enderror
</div>

</body>
</html>
