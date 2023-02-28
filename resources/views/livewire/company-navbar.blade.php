<header class="bg-white shadow">
    <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
        <nav class="hidden lg:flex lg:py-2" aria-label="Global">
            <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-900 hover:bg-gray-50 hover:text-gray-900" -->
            <div class="lg:space-x-4">
                <livewire:company-navbar-item key="navbar-geographic-{{ $period }}"
                    href="/company/{{ $company->ticker }}?period={{ $period }}" name="Geographic"
                    :active="$currentRoute === 'company.show'" />
                <livewire:company-navbar-item key="navbar-metrics-{{ $period }}"
                    href="/company/{{ $company->ticker }}/metrics?period={{ $period }}" name="Metrics"
                    :active="$currentRoute === 'company.metrics'" />
                <livewire:company-navbar-item key="navbar-calcbench-{{ $period }}"
                    href="/company/{{ $company->ticker }}/calcbench?period={{ $period }}" name="c/ Calcbench"
                    :active="$currentRoute === 'company.calcbench'" />
                <livewire:company-navbar-item key="navbar-report-{{ $period }}"
                    href="/company/{{ $company->ticker }}/report?period={{ $period }}" name="Full report"
                    :active="$currentRoute === 'company.report'" />
                <livewire:company-navbar-item key="navbar-periods-{{ $period }}"
                    href="/company/{{ $company->ticker }}/periods?period={{ $period }}" name="F.R. by period"
                    :active="$currentRoute === 'company.periods'" />
                <livewire:company-navbar-item key="navbar-sc2-{{ $period }}"
                    href="/company/{{ $company->ticker }}/sc2?period={{ $period }}" name="Harmonization Sc2"
                    :active="$currentRoute === 'company.sc2'" />
                <livewire:company-navbar-item key="navbar-sc3-{{ $period }}"
                    href="/company/{{ $company->ticker }}/sc3?period={{ $period }}" name="Harmonization Sc"
                    :active="$currentRoute === 'company.sc3'" />
            </div>
            <div class="hidden ml-auto sm:flex sm:items-center">

                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <label for="period" class="inline-flex text-sm font-medium text-gray-900">Periodicity: </label>
                    <select wire:model="period"
                        class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                        name="period" id="period">
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
            <livewire:company-navbar-item key="navbar-geographic-{{ $period }}"
                href="/company/{{ $company->ticker }}?period={{ $period }}" name="Geographic"
                :active="$currentRoute === 'company.show'" />
            <livewire:company-navbar-item key="navbar-metrics-{{ $period }}"
                href="/company/{{ $company->ticker }}/metrics?period={{ $period }}" name="Metrics"
                :active="$currentRoute === 'company.metrics'" />
            <livewire:company-navbar-item key="navbar-calcbench-{{ $period }}"
                href="/company/{{ $company->ticker }}/calcbench?period={{ $period }}" name="c/ Calcbench"
                :active="$currentRoute === 'company.calcbench'" />
            <livewire:company-navbar-item key="navbar-report-{{ $period }}"
                href="/company/{{ $company->ticker }}/report?period={{ $period }}" name="Full report"
                :active="$currentRoute === 'company.report'" />
            <livewire:company-navbar-item key="navbar-periods-{{ $period }}"
                href="/company/{{ $company->ticker }}/periods?period={{ $period }}" name="F.R. by period"
                :active="$currentRoute === 'company.periods'" />
            <livewire:company-navbar-item key="navbar-sc2-{{ $period }}"
                href="/company/{{ $company->ticker }}/sc2?period={{ $period }}" name="Harmonization Sc2"
                :active="$currentRoute === 'company.sc2'" />
            <livewire:company-navbar-item key="navbar-sc3-{{ $period }}"
                href="/company/{{ $company->ticker }}/sc3?period={{ $period }}" name="Harmonization Sc"
                :active="$currentRoute === 'company.sc3'" />
            <div class="relative mt-3">
                <label for="period" class="inline-flex text-sm font-medium text-gray-900"> Periodicity : </label>
                <select wire:model.lazy="period"
                    class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                    name="period" id="period">
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
