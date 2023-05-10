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
            </div>
            <div class="hidden ml-auto sm:flex sm:items-center">

                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <label for="period" class="inline-flex text-sm font-medium text-gray-900">Periodicity: </label>
                    <select wire:model="period" wire:key="navbar-select-period"
                        class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                        name="period" wire:change="$emit('periodChange', $event.target.value)" id="period">
                        <option value="annual">
                            Annual
                        </option>
                        <option value="quarterly">
                            Quarterly
                        </option>
                    </select>
                </div>
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
            <div class="relative mt-3 ml-3">
                <label for="period" class="inline-flex text-sm font-medium text-gray-900"> Periodicity : </label>
                <select wire:model.lazy="period" wire:key="navbar-select-mob"
                    class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                    wire:change="$emit('periodChange', $event.target.value)"
                    name="period" id="period-mob">
                    <option value="annual">
                        Annual
                    </option>
                    <option value="quarterly">
                        Quarterly
                    </option>
                </select>
            </div>
        </div>
    </nav>
</header>
</div>