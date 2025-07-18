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
    @vite(['resources/css/app.css'])

    @livewireStyles
</head>

<body class="min-h-screen font-sans text-base antialiased text-dark bg-gray-light">
    <x-jet-banner />

    <livewire:company-navbar :company="$company" />

    <main class="px-4 pb-10 transition-all md:px-6 lg:pl-8 lg:ml-56 overflow-x-clip" id="main-container">
        <div class="mx-auto" style="max-width: 1500px;" x-data x-cloak>
            @if ($tab == 'track-investor')
                <livewire:track-investor.page />
            @elseif($tab == 'investor-adviser')
                <livewire:investor-adviser.page />
            @elseif($tab == 'event-filings')
                <livewire:event-filings.page />
            @elseif($tab == 'insider-transactions')
                <livewire:insider-transactions.page />
            @elseif($tab == 'earnings-calendar')
                <livewire:earnings-calendar.page />
            @elseif($tab === 'screener')
                <livewire:screener.page />
            @elseif ($tab == 'geographical')
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
                <livewire:company-report.page :company="$company" :ticker="$ticker" />
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
            @elseif($tab == 'mutual-fund')
                <livewire:ownership.mutual-fund :company="$currentCompany" :fund="$fund" />
            @elseif($tab == 'adviser')
                <livewire:investor-adviser.adviser :company="$currentCompany" :adviser="$fund" />
            @elseif($tab == 'etf-filings')
                <livewire:etf.filings />
            @elseif($tab === 'filings-summary')
                <livewire:comapany-filings-summary :company="$company" :tinker="$ticker" :period="$period" />
            @elseif($tab == 'analysis')
                <livewire:company-analysis.page :company="$company" :ticker="$ticker" :period="$period" />
            @elseif($tab === 'builder-chart')
                <livewire:builder.chart />
            @elseif($tab === 'builder-table')
                <livewire:builder.table />
            @elseif($tab === 'account-settings')
                <livewire:account-settings.page :src="$src" :tab="$subtab" />
            @endif
        </div>
    </main>

    <div id="modals-area">
        @stack('modals')
        @livewire('modal-pro')
        @livewire('spotlight-pro')
        @livewire('slide-over-pro')
    </div>

    <div class="hidden z-[1000] relative" id="general-text-tooltip">
        <div class="content bg-dark text-white text-sm px-3 py-1 font-medium rounded "></div>
        <div
            class="-z-10 absolute h-3 w-3 rotate-45 bg-dark top-[100%] left-[50%] -translate-x-[50%] -translate-y-[80%]">
        </div>
    </div>

    @livewireScripts
    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/js/chartjs-global.js'])
    <script src="https://cdn.jsdelivr.net/npm/luxon"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/3.0.1/chartjs-plugin-annotation.min.js"
        integrity="sha512-Hn1w6YiiFw6p6S2lXv6yKeqTk0PLVzeCwWY9n32beuPjQ5HLcvz5l2QsP+KilEr1ws37rCTw3bZpvfvVIeTh0Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-adapter-luxon/0.2.1/chartjs-adapter-luxon.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    @stack('scripts')
</body>

</html>
