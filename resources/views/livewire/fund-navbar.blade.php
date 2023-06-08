<div>
<header class="bg-white shadow">
    <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
        <nav class="hidden lg:flex lg:py-2" aria-label="Global">
            <div class="lg:space-x-4">
                <livewire:company-navbar-item wire:key="navbar-summary"
                    href="/fund/{{ $fund->cik }}" name="Summary"
                    :active="$currentRoute === 'fund.summary'" />
                <livewire:company-navbar-item wire:key="navbar-holdings"
                    href="/fund/{{ $fund->cik }}/holdings" name="Holdings"
                    :active="$currentRoute === 'fund.holdings'" />
                <livewire:company-navbar-item wire:key="navbar-metrics"
                    href="/fund/{{ $fund->cik }}/metrics" name="Metrics"
                    :active="$currentRoute === 'fund.metrics'" />
                <livewire:company-navbar-item wire:key="navbar-insider"
                    href="/fund/{{ $fund->cik }}/insider" name="Insider"
                    :active="$currentRoute === 'fund.insider'" />
                <livewire:company-navbar-item wire:key="navbar-filings"
                    href="/fund/{{ $fund->cik }}/filings" name="Filings"
                    :active="$currentRoute === 'fund.filings'" />
                <livewire:company-navbar-item wire:key="navbar-restatement"
                    href="/fund/{{ $fund->cik }}/restatement" name="Restatement"
                    :active="$currentRoute === 'fund.restatement'" />
            </div>
        </nav>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <nav class="lg:hidden" aria-label="Global" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <livewire:company-navbar-item wire:key="navbar-summary-mob"
                href="/fund/{{ $fund->cik }}" name="Summary"
                :active="$currentRoute === 'fund.summary'" />
            <livewire:company-navbar-item wire:key="navbar-holdings-mob"
                href="/fund/{{ $fund->cik }}/holdings" name="Holdings"
                :active="$currentRoute === 'fund.holdings'" />
            <livewire:company-navbar-item wire:key="navbar-metrics-mob"
                href="/fund/{{ $fund->cik }}/metrics" name="Metrics"
                :active="$currentRoute === 'fund.metrics'" />
            <livewire:company-navbar-item wire:key="navbar-insider-mob"
                    href="/fund/{{ $fund->cik }}/insider" name="Insider"
                    :active="$currentRoute === 'fund.insider'" />
            <livewire:company-navbar-item wire:key="navbar-filings-mob"
                href="/fund/{{ $fund->cik }}/filings" name="Filings"
                :active="$currentRoute === 'fund.filings'" />
            <livewire:company-navbar-item wire:key="navbar-restatement-mob"
                href="/fund/{{ $fund->cik }}/restatement" name="Restatement"
                :active="$currentRoute === 'fund.restatement'" />
        </div>
    </nav>
</header>
</div>