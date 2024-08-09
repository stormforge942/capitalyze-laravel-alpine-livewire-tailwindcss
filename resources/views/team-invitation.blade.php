<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $invitation->team->name }} Invitation | Capitalyze</title>

    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700" rel="stylesheet" />

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen">
    @if ($isExistingUser)
        <livewire:accept-team-invitation :invitation="$invitation" />
    @else
        <livewire:join-and-accept-team-invitation :invitation="$invitation" />
    @endif

    @livewireScripts
</body>

</html>
