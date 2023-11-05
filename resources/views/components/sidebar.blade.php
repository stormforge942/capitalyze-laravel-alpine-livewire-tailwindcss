<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/capitalyze-logo-bg.png') }}" class="block h-20 w-auto p-3"
                alt="Capitalyze Logo">
        </a>

        <ul class="space-y-2 font-medium">
            @foreach ($links as $item)
                <li>
                    <x-jet-nav-link href="{{ route($item->route_name) }}" :active="request()->routeIs($item->route_name)">
                        {{ __($item->name) }}
                    </x-jet-nav-link>
                </li>
            @endforeach
        </ul>

        @if ($slot ?? false)
            {{ $slot }}
        @endif
    </div>
</aside>
