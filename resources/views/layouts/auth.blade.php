<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Innovatice</title>

    <!-- Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    >
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap"
        rel="stylesheet"
    />

    @vite(['resources/css/app.css'])
</head>

<body class="antialiased">

    <div class="flex flex-col items-center justify-start w-full min-h-screen px-6">

        {{ $slot }}

    </div>


    @vite(['resources/js/app.js'])
    @livewireScripts()
</body>

</html>
