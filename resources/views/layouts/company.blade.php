<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @once
        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/luxon"></script>
        @endpush
    @endonce
</head>
<body>
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu-guest')
        <livewire:company-navbar :company="$company" :period="$period" />
        <!-- Page Content -->
        <main>
            @if($tab == 'geographical')
            <livewire:company-geographical :company="$company" :ticker="$ticker" :period="$period" />
            @elseif($tab == 'products')
            <livewire:company-products :company="$company" :ticker="$ticker" :period="$period" />
            @elseif($tab == 'metrics')
            <livewire:company-metrics :company="$company" :ticker="$ticker" :period="$period" />
            @elseif($tab == 'report')
            <livewire:company-report :company="$company" :ticker="$ticker" :period="$period" />
             @elseif($tab == 'shareholders')
            <livewire:company-shareholders :company="$company" :ticker="$ticker" :period="$period" />
            @endif
        </main>
    </div>

    @stack('modals')
    @livewire('slide-over-pro')
    @livewireScripts
    @stack('scripts')
</body>
</html>
