<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

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

<body class="text-dark text-base font-sans antialiased min-h-screen bg-gray-light">
    <x-jet-banner />

    <div class="">
        <livewire:company-navbar :company="$company" />
        <!-- Page Content -->
        <main>
            <div class="px-4 sm:ml-64 pl-0 transition-all" id="main-container">
                @if ($tab == 'geographical')
                    <livewire:company-geographical :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'products')
                    <livewire:company-products :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'profile')
                    <livewire:company-profile :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'splits')
                    <livewire:company-splits :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'metrics')
                    <livewire:company-metrics :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'chart')
                    <livewire:company-chart :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'executiveCompensation')
                    <livewire:company-executive-compensation :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'report')
                    <livewire:company-report :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'shareholders')
                    <livewire:company-shareholders :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'summary')
                    <livewire:company-summary :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'filings')
                    <livewire:company-filings :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'insider')
                    <livewire:company-insider :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'restatement')
                    <livewire:company-restatement :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'employee')
                    <livewire:company-employee-count :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'failToDeliver')
                    <livewire:company-fail-to-deliver :company="$company" :ticker="$ticker" :period="$period" />
                @elseif($tab == 'ownership')
                    <livewire:ownership.page :company="$company" />
                @elseif($tab == 'shareholder')
                    <livewire:ownership.shareholder />
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
