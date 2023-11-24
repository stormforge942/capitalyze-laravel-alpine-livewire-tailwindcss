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
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/luxon"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-adapter-luxon/0.2.1/chartjs-adapter-luxon.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
        @endpush
    @endonce
</head>

<body class="min-h-screen font-sans text-base antialiased text-dark bg-gray-light">
    <x-jet-banner />

    <livewire:company-navbar :company="$company" />

    <main class="px-4 pb-10 transition-all md:px-6 lg:px-8 lg:ml-56" id="main-container">
        @if ($tab == 'geographical')
            <livewire:company-geographical :company="$company" :ticker="$ticker" :period="$period" />
        @elseif($tab == 'products')
            <livewire:company-products :company="$company" :ticker="$ticker" :period="$period" />
        @elseif($tab == 'profile')
            <livewire:company-profile.page :company="$company" :period="$period" />
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
            <livewire:ownership.page :company="$currentCompany" />
        @elseif($tab == 'fund')
            <livewire:ownership.fund :company="$currentCompany" :fund="$fund" />
        @elseif($tab == 'track-investor')
            <livewire:track-investor.page :comapany="$company" :tinker="$ticker" :period="$period" />
        @elseif($tab == 'etf-filings')
            <livewire:etf.filings />
        @elseif($tab === 'filings-summary')
            <livewire:comapany-filings-summary :company="$company" :tinker="$ticker" :period="$period" />
        @elseif($tab == 'analysis')
            <livewire:company-analysis :company="$company" :ticker="$ticker" :period="$period" />
        @endif
    </main>

    <div id="modals-area">
        @stack('modals')
        @livewire('spotlight-pro')
        @livewire('slide-over-pro')
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>
