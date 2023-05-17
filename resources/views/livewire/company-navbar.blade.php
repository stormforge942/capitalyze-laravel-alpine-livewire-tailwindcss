<div>
<header class="bg-white shadow">
    <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
        <nav class="hidden lg:flex lg:py-2" aria-label="Global">
            <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-900 hover:bg-gray-50 hover:text-gray-900" -->
            <div class="lg:space-x-4">
                <livewire:company-navbar-item wire:key="navbar-product-{{ $period }}"
                    href="/company/{{ $company->ticker }}/?period={{ $period }}" name="Products"
                    :active="$currentRoute === 'company.product'" />
                <livewire:company-navbar-item wire:key="navbar-geographic-{{ $period }}"
                    href="/company/{{ $company->ticker }}/geographic?period={{ $period }}" name="Geographic"
                    :active="$currentRoute === 'company.geographic'" />
                <livewire:company-navbar-item wire:key="navbar-metrics-{{ $period }}"
                    href="/company/{{ $company->ticker }}/metrics?period={{ $period }}" name="Metrics"
                    :active="$currentRoute === 'company.metrics'" />
                <livewire:company-navbar-item wire:key="navbar-report-{{ $period }}"
                    href="/company/{{ $company->ticker }}/report?period={{ $period }}" name="Full Report"
                    :active="$currentRoute === 'company.report'" />
                <livewire:company-navbar-item wire:key="navbar-shareholders"
                    href="/company/{{ $company->ticker }}/shareholders" name="Shareholders"
                    :active="$currentRoute === 'company.shareholders'" />
            </div>
            <div class="hidden ml-auto sm:flex sm:items-center">
                @if($currentRoute !== 'company.shareholders')
                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <button wire:key="navbar-period-annual" class="@if($period == 'annual')text-blue-700 @else text-slate-700 @endif text-sm appearance-none inline-flex px-3 py-2 leading-tight appearance-none focus:outline-none focus:bg-white focus:border-slate-500" wire:click="changePeriod('annual')">Annual</button>
                    <span class="text-indigo-600">|</span>
                    <button wire:key="navbar-period-quarterly" class="@if($period == 'quarterly')text-blue-700 @else text-slate-700 @endif text-sm appearance-none inline-flex px-3 py-2 leading-tight appearance-none focus:outline-none focus:bg-white focus:border-slate-500" wire:click="changePeriod('quarterly')">Quarterly</button>
                </div>
                @endif
            </div>
        </nav>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <nav class="lg:hidden" aria-label="Global" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <livewire:company-navbar-item wire:key="navbar-product-mob-{{ $period }}"
                href="/company/{{ $company->ticker }}?period={{ $period }}" name="Product"
                :active="$currentRoute === 'company.product'" />
            <livewire:company-navbar-item wire:key="navbar-geographic-mob-{{ $period }}"
                href="/company/{{ $company->ticker }}/geographic?period={{ $period }}" name="Geographic"
                :active="$currentRoute === 'company.geographic'" />
            <livewire:company-navbar-item wire:key="navbar-metrics-mob-{{ $period }}"
                href="/company/{{ $company->ticker }}/metrics?period={{ $period }}" name="Metrics"
                :active="$currentRoute === 'company.metrics'" />
            <livewire:company-navbar-item wire:key="navbar-report-mob-{{ $period }}"
                href="/company/{{ $company->ticker }}/report?period={{ $period }}" name="Full Report"
                :active="$currentRoute === 'company.report'" />
            <livewire:company-navbar-item wire:key="navbar-shareholders-mob"
                    href="/company/{{ $company->ticker }}/shareholders" name="Shareholders"
                    :active="$currentRoute === 'company.shareholders'" />
            @if($currentRoute !== 'company.shareholders')
            <div class="relative mt-3 ml-3">
                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <button wire:key="navbar-period-annual" class="@if($period == 'annual')border-b-2 @endif appearance-none inline-flex px-3 py-2 leading-tight appearance-none border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500" wire:click="changePeriod('annual')">Annual</button>
                    <button wire:key="navbar-period-quarterly" class="@if($period == 'quarterly')border-b-2 @endif appearance-none inline-flex px-3 py-2 leading-tight appearance-none border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500" wire:click="changePeriod('quarterly')">Quarterly</button>
                </div>
            </div>
            @endif
        </div>
    </nav>
</header>
</div>