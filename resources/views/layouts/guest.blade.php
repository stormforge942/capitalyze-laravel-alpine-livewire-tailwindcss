<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body>
        <x-jet-banner />

         <div class="min-h-screen bg-gray-100">
        @auth
            @if(auth()->user()->is_approved && auth()->user()->hasVerifiedEmail())
                @livewire('navigation-menu')
            @else
                @livewire('navigation-menu-guest')
            @endif
        @else
            @livewire('navigation-menu-guest')
        @endauth

        <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        @livewire('spotlight-pro')
        @livewireScripts
    </body>
</html>
