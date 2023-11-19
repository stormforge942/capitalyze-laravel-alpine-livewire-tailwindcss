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
        <div class="ml-8">
            @livewire('navigation-menu')
        </div>
        <livewire:fund-navbar :fund="$fund" />
        <!-- Page Content -->
        <main>
            <div class="p-4 sm:ml-64 pl-0">
                @if($tab == 'summary')
                <livewire:fund-summary :fund="$fund" :cik="$cik" />
                @elseif($tab == 'holdings')
                <livewire:fund-holdings :fund="$fund" :cik="$cik" />
                @elseif($tab == 'metrics')
                <livewire:fund-metrics :fund="$fund" :cik="$cik" />
                @elseif($tab == 'insider')
                <livewire:fund-insider :fund="$fund" :cik="$cik" />
                @elseif($tab == 'filings')
                <livewire:fund-filings :fund="$fund" :cik="$cik" />
                @elseif($tab == 'restatement')
                <livewire:fund-restatement :fund="$fund" :cik="$cik" />
            @endif
            </div>
        </main>
    </div>

    @stack('modals')
    @livewire('spotlight-pro')
    @livewire('slide-over-pro')
    @livewireScripts
    @stack('scripts')
</body>
</html>
