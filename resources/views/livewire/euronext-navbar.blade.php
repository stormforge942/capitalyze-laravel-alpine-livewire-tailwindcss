<div>
<header class="bg-white shadow">
    <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
        <nav class="hidden lg:flex lg:py-2" aria-label="Global">
            <div class="lg:space-x-4">
                <livewire:company-navbar-item wire:key="navbar-metrics"
                    href="{{ route('euronext.metrics', ['ticker' => $euronext->symbol]) }}" name="Metrics"
                    :active="$currentRoute === 'euronext.metrics'" />
            </div>
        </nav>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <nav class="lg:hidden" aria-label="Global" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <livewire:company-navbar-item wire:key="navbar-metrics-mob"
                href="{{ route('euronext.metrics', ['ticker' => $euronext->symbol]) }}" name="Metrics"
                :active="$currentRoute === 'euronext.metrics'" />
        </div>
    </nav>
</header>
</div>