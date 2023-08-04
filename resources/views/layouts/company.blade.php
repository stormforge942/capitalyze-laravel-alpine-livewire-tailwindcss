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

    <div class="">
        @livewire('navigation-menu')
        <livewire:company-navbar :company="$company" :period="$period" />
        <!-- Page Content -->
        <main>
            <div class="p-4 sm:ml-64 pl-0">
                <div class="">
                    @if($tab == 'geographical')
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
                    @endif
                </div> 
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
