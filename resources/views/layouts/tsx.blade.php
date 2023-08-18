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
        @livewire('navigation-menu')
        <livewire:tsx-navbar :tsx="$tsx" />
        <!-- Page Content -->
        <main>
            @if($tab == 'metrics')
            <livewire:tsx-metrics :tsx="$tsx" />
            @endif
            @if($tab == 'filings')
            <livewire:tsx-filings :tsx="$tsx" />
            @endif
        </main>
    </div>

    @stack('modals')
    @livewire('spotlight-pro')
    @livewire('slide-over-pro')
    @livewireScripts
    @stack('scripts')
</body>
</html>
