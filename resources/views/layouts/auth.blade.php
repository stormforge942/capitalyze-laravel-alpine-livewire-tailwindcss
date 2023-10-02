<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700" rel="stylesheet" />

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-dark text-base font-sans antialiased">
    <div class="min-h-screen bg-gray-light p-8">
        <div>
            <a href="/">
                <img src="/img/logo.png" alt="Capitalyze logo" class="h-9 md:h-14 2xl:h-18">
            </a>
        </div>
        <div class="mt-[3.65rem] md:mt-[15vh] mb-5">
            <div class="p-6 pb-11 max-w-[31rem] mx-auto bg-white rounded-lg shadow-xl">
                @if($component === 'login')
                <livewire:auth.login></livewire:auth.login>
                @else
                @endif
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>