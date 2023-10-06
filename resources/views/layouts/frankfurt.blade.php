<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')
        <livewire:frankfurt-navbar :model="$model" :period="$period" />
        <!-- Page Content -->
        <main>
            @if($tab == 'metrics')
            <livewire:frankfurt-metrics :model="$model" :period="$period" />
            @endif
            @if($tab == 'filings')
            {{-- <livewire:otc-filings :otc="$otc" /> --}}
            @endif
        </main>
    </div>

    @include('partials.info-modal')
    @stack('modals')
    @livewire('spotlight-pro')
    @livewire('slide-over-pro')
    @livewireScripts
    @stack('scripts')
</body>
</html>
