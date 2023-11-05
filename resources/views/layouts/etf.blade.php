<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Public+Sans:400,500,600" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @once
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/luxon"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-adapter-luxon/0.2.1/chartjs-adapter-luxon.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
        @endpush
    @endonce
</head>

<body class="min-h-screen font-sans text-base antialiased text-dark bg-gray-light">
    <x-jet-banner />

    @if ($tab === 'filings')
        <livewire:company-navbar :company="$company" period="annual" />
    @else
        <livewire:etf.navbar :etf="$etf" />

        <div class="ml-12">
            <livewire:navigation-menu />
        </div>
    @endif

    <main class="px-4 pb-10 transition-all md:px-6 lg:px-8 {{ $tab === 'filings' ? 'lg:ml-52' : 'lg:ml-64' }}" id="main-container">
        @if ($tab == 'holdings')
            <livewire:etf.holdings :etf="$etf" />
        @elseif($tab == 'filings')
            <livewire:etf.filings :company="$company" />
        @endif
    </main>

    @stack('modals')
    @livewire('spotlight-pro')
    @livewire('slide-over-pro')
    @livewireScripts
    @stack('scripts')
</body>

</html>
