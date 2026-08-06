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
<body class="bg-background text-foreground">

<x-layouts.nav />

<main class="max-w-7xl mx-auto px-6">
    {{ $slot }}
</main>

{{--    This one to show the message sent with routing or redircting    --}}
@session('success')
<div
    x-data="{show: true}"
    x-init="setTimeout(()=> show = false, 3000)"
    x-show="show"
    x-transition.opacity.duration.300ms
    class="bg-primary px-4 py-3 absolute bottom-4 right-4 rounded-lg">{{$value}}</div>
@endsession

</body>
</html>
