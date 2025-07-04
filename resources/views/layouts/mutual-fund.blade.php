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
            @vite(['resources/js/chartjs-global.js'])
            <script src="https://cdn.jsdelivr.net/npm/luxon"></script>
        @endpush
    @endonce
</head>

<body>
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')
        <livewire:mutual-fund-navbar :fund="$fund" />
        <!-- Page Content -->
        <main>
            <div class="p-4 sm:ml-64 pl-0">
                @if ($tab == 'holdings')
                    <livewire:mutual-fund-holdings :fund="$fund" :cik="$cik" :fund_symbol="$fund_symbol"
                        :series_id="$series_id" :class_id="$class_id" />
                @elseif($tab == 'returns')
                    <livewire:mutual-fund-returns :fund="$fund" :cik="$cik" :fund_symbol="$fund_symbol"
                        :series_id="$series_id" :class_id="$class_id" />
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
