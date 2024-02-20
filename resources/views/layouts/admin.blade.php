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
</head>

<body>
    <div class="min-h-screen bg-gray-100">
        <livewire:admin-navbar />

        <main>
            <div class="container px-3 mx-auto pb-5">
                <ul class="flex px-4 sm:px-6 lg:px-8 py-4 shadow rounded max-w-5xl mx-auto">
                    <li class="mr-8">
                        <a class="nav-link {{ last(request()->segments()) == 'users' ? 'font-bold' : '' }}" aria-current="page" href="{{ route('admin.users') }}" >Users</a>
                    </li>
                    <li class="mr-8">
                            <a class="nav-link {{ last(request()->segments()) == 'permission' ? 'font-bold' : '' }}" href="{{ route('admin.permission-management') }}">Permission Management</a>
                    </li>
                    <li class="mr-8">
                        <a class="nav-link {{ last(request()->segments()) == 'groups' ? 'font-bold' : '' }}" href="{{ route('admin.groups-management') }}">Groups Management</a>
                    </li>
                    <li class="mr-8">
                        <a class="nav-link {{ last(request()->segments()) == 'feedbacks' ? 'font-bold' : '' }}" href="{{ route('admin.feedbacks-management') }}">Feedbacks Management</a>
                    </li>
                </ul>
            </div>

            <div class="container px-3 mx-auto pb-5">
                @if ($tab == 'users')
                    <livewire:admin-users />
                @endif

                @if ($tab == 'permission-management')
                    <livewire:admin-permission-management />
                @endif

                @if ($tab == 'groups-management')
                    <livewire:admin-groups-management />
                @endif

                @if ($tab == 'feedbacks-management')
                    <livewire:admin.feedbacks-management />
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
