<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Capitalyze')</title>

    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700" rel="stylesheet" />

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-dark text-base font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-light p-8">
        <div>
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" alt="Capitalyze logo" class="h-9 md:h-14 2xl:h-18">
            </a>
        </div>
        <div class="mt-[15vh] mb-5">
            <div class="p-6 max-w-[27rem] mx-auto bg-white rounded-lg shadow-xl">
                @yield('content')
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>