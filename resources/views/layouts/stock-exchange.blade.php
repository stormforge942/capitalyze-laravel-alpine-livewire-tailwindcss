<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>

    <body class="text-dark text-base font-sans antialiased min-h-screen bg-gray-light">
        @livewire('navigation-menu')
        @sectionMissing('navbar')
            <livewire:is :component="$exchange . '.navbar'" :model="$model" :period="$period" />
        @else
            @yield('navbar')
        @endif
        <!-- Page Content -->
        <main>
            @json($tab)
            @if ($tab == 'metrics')
                @sectionMissing('metrics')
                    <livewire:is :component="$exchange . '.metrics'" :model="$model" :period="$period" />
                @else
                    @yield('metrics')
                @endif
            @endif
            @if ($tab == 'filings')
                @sectionMissing('filings')
                    <livewire:is :component="$exchange . '.filings'" :model="$model" :exchange="$exchange" />
                @else
                    @yield('filings')
                @endif
            @endif
            @if ($tab == 'profile')
                @sectionMissing('profile')
                    <livewire:is :component="$exchange . '.profile'" :model="$model" :exchange="$exchange" />
                @else
                    @yield('profile')
                @endif
            @endif
            @yield('content')
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
