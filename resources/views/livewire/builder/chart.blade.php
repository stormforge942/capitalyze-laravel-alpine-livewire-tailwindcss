<div class="chart-builder-page">
    <div>
        <h1 class="text-xl font-bold">Chart</h1>
        <p class="mt-2 text-dark-light2">Build custom charts to visualize financial data across companies</p>
    </div>

    <div class="mt-8">
        @livewire('builder.chart-tabs')
    </div>

    @if ($tab)
        <div class="relative" x-data="{
            filters: $wire.entangle('filters', true),
            metricAttributes: $wire.entangle('metricAttributes', true),
            metricsColor: $wire.entangle('metricsColor', true),
            _dates: @js($dates),
            _data: @js($data),
            dateRange: @js($dateRange),
            metricsMap: @js($metricsMap),
            showChart: false,
            init() {
                this.showChart = this.shouldShowChart()
        
                this.$watch('filters', (filters) => {
                    window.http(`/chart-builder/${$wire.tab.id}/update`, {
                        method: 'POST',
                        body: { filters }
                    })
                }, { deep: true })
        
                this.$watch('filters.period', () => {
                    this.$dispatch('update-range-slider')
                    this.$dispatch('update-chart');
                })
        
                this.$watch('filters.dateRange', (value) => {
                    this.$dispatch('update-chart');
                })
        
                this.$watch('filters.decimalPlaces', (value) => {
                    this.$dispatch('update-chart');
                })
        
                this.$watch('filters.unit', (value) => {
                    this.$dispatch('update-chart');
                })
        
                this.$watch('metricAttributes', (metric_attributes) => {
                    this.showChart = this.shouldShowChart()
        
                    this.$dispatch('update-chart');
        
                    window.http(`/chart-builder/${$wire.tab.id}/update`, {
                        method: 'POST',
                        body: { metric_attributes }
                    })
                })
            },
            formatDate(date) {
                if (this.filters.period === 'annual') {
                    return date.split('-')[0];
                }
        
                const [month, year] = new Intl.DateTimeFormat('en-US', { month: 'short', year: 'numeric' }).format(new Date(date)).split(' ');
        
                return {
                    'Jan': 'Q1',
                    'Apr': 'Q2',
                    'Jul': 'Q3',
                    'Oct': 'Q4',
                } [month] + '-' + year;
            },
            formatValue(value, applyUnit = true) {
                return window.formatNumber(value, {
                    decimalPlaces: this.filters.decimalPlaces,
                    unit: applyUnit ? this.filters.unit : 'None'
                });
            },
            shouldShowChart() {
                return Object.entries(this.metricAttributes)
                    .find(([metric, value]) => value.show && $wire.metrics.includes(metric))
            },
            get dates() {
                return this._dates[this.filters.period]
            },
            get data() {
                return this._data[this.filters.period]
            },
            get selectedDates() {
                return this.dates.filter(date => {
                    const year = new Date(date).getFullYear();
        
                    return this.filters.dateRange[0] <= year && year <= this.filters.dateRange[1]
                });
            },
            get fullDateRange() {
                return this.dateRange[this.filters.period]
            },
            get dataGroupedByMetric() {
                let data = {}
        
                Object.entries(this.data).forEach(([company, value]) => {
                    for (const [metric, timeline] of Object.entries(value)) {
                        if (!data[metric]) {
                            data[metric] = {}
                        }
        
                        data[metric][company] = timeline
                    }
                })
        
                Object.keys(data).forEach(metric => {
                    if (!this.metricAttributes[metric].show) {
                        delete data[metric]
                    }
                })
        
                return data
            },
        }" wire:key="{{ \Str::random(5) }}"
            wire:loading.class="pointer-events-none animate-pulse">
            <div class="cus-loader" wire:loading.block>
                <div class="cus-loaderBar"></div>
            </div>

            <div class="mt-6 grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div>
                    <livewire:builder.select-company :selected="$companies" :wire:key="'select-company-' . $tab['id']" />
                </div>

                <div>
                    <livewire:builder.select-chart-metrics :selected="$metrics"
                        :wire:key="'select-metrics-' . $tab['id']" />
                </div>
            </div>

            <template x-if="showChart && dates.length">
                <div>
                    <div class="mt-6">
                        <x-filter-box>
                            <div class="flex items-center gap-x-1">
                                <span class="text-sm text-dark-light2">Period Type</span>
                                <x-select placeholder="Period Type" :options="['annual' => 'Annual', 'quarter' => 'Quarterly']"
                                    x-model="filters.period"></x-select>
                            </div>

                            <div class="flex-1">
                                <x-range-slider :min="2002" :max="date('Y')" x-init="() => {
                                    const range = fullDateRange
                                
                                    min = range[0]
                                    max = range[1]
                                
                                    value = filters.dateRange
                                
                                    initSlider()
                                }"
                                    @range-updated="filters.dateRange = $event.detail"
                                    @update-range-slider.window="() => {
                                        const range = fullDateRange
        
                                        min = range[0]
                                        max = range[1]
                                    
                                        value = filters.dateRange
                                    
                                        initSlider()    
                                    }"></x-range-slider>
                            </div>

                            <div class="flex items-center gap-x-1">
                                <span class="text-sm text-dark-light2">Unit Type</span>
                                <x-select placeholder="Unit Type" :options="['As Stated', 'Thousands', 'Millions', 'Billions']" x-model="filters.unit"></x-select>
                            </div>

                            <div class="flex items-center gap-x-1">
                                <span class="text-sm text-dark-light2">Decimal</span>
                                <x-select-decimal-places x-model="filters.decimalPlaces"></x-select-decimal-places>
                            </div>
                        </x-filter-box>
                    </div>

                    <div class="mt-6 bg-white p-6 relative rounded-lg" x-data="{
                        panel: $wire.entangle('panel', true),
                        showLabel: $wire.entangle('showLabel', true),
                        tabs: {
                            'single-panel': 'Single Panel',
                            'multi-security': 'Multi Security',
                            'multi-metric': 'Multi Metric',
                        },
                        init() {
                            this.$watch('showLabel', (showLabel) => {
                                this.$dispatch('update-chart');
                            })
                    
                            this.$watch('panel', (panel) => {
                                window.http(`/chart-builder/${$wire.tab.id}/update`, {
                                    method: 'POST',
                                    body: { panel }
                                })
                            })
                        }
                    }">
                        <div class="flex items-center justify-between">
                            <div
                                class="flex items-center w-full max-w-[400px] gap-x-1 border border-[#D4DDD7] rounded bg-gray-light font-medium">
                                <template x-for="(tab, key) in tabs">
                                    <button class="py-2 rounded flex-1 transition"
                                        :class="panel === key ? 'bg-[#DCF6EC] border border-[#52D3A2] -m-[1px]' : ''"
                                        @click="panel = key" x-text="tab"></button>
                                </template>
                            </div>
                            <div class="flex items-center gap-x-5 justify-between">
                                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                    <input type="checkbox" value="yes" class="sr-only peer" :checked="showLabel"
                                        @change="showLabel = $event.target.checked">
                                    <div
                                        class="w-6 h-2.5 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:-start-[4px] after:bg-white after:rounded-full after:h-4 after:w-4 after:shadow-md after:transition-all peer-checked:bg-dark-light2 peer-checked:after:bg-dark">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900">Show Labels</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4 space-y-6">
                            <template x-if="panel === 'single-panel'">
                                @include('livewire.builder.chart.single-panel')
                            </template>
                            <template x-if="panel === 'multi-security'">
                                @include('livewire.builder.chart.multi-security')
                            </template>
                            <template x-if="panel === 'multi-metric'">
                                @include('livewire.builder.chart.multi-metric')
                            </template>
                        </div>
                    </div>

                    <div class="mt-4 bg-white p-6 relative rounded-lg">
                        <h3 class="font-medium">Indicators</h3>
                        <div class="mt-3 chart-legends !grid grid-cols-2">
                        </div>
                    </div>

                    <div class="mt-6 rounded-lg sticky-table-container">
                        <table class="round-lg text-right whitespace-nowrap sticky-table sticky-column">
                            <thead>
                                <tr class="capitalize text-dark bg-[#EDEDED] text-base font-bold">
                                    <th class="pl-8 py-2 bg-[#EDEDED] text-left">
                                        Metric
                                    </th>
                                    <template x-for="date in selectedDates" :key="date">
                                        <th class="pl-6 py-2 last:pr-8" x-text="formatDate(date)"></th>
                                    </template>
                                </tr>
                            </thead>
                            <template x-for="(metrics, company) in data" :key="company">
                                <tbody class="report-tbody">
                                    <template x-for="(timeline, metric) in metrics" :key="company + '-' + metric">
                                        <tr class="border-b last:border-b-0">
                                            <td class="pl-6 text-left py-2">
                                                <span x-text="`${company} - ${metricsMap[metric].title}`"></span>
                                            </td>
                                            <template x-for="date in selectedDates" :key="date">
                                                <td class="pl-6 last:pr-8 py-2 bg-white"
                                                    :class="timeline[date] < 0 ? 'text-red' : ''"
                                                    x-text="timeline[date] ? (timeline[date] < 0 ? `(${formatValue(-1 * timeline[date], !metricsMap[metric].yAxis)})` : formatValue(timeline[date], !metricsMap[metric].yAxis)) : '-'">
                                                </td>
                                            </template>
                                        </tr>
                                    </template>
                                </tbody>
                            </template>
                        </table>
                    </div>
                </div>
            </template>

            <template x-if="!showChart || !dates.length">
                <div class="grid place-items-center py-24">
                    <svg width="168" height="164" viewBox="0 0 168 164" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_8757_81677)">
                            <path
                                d="M106.655 36.8798H61.3859C60.3543 36.881 59.3653 37.2914 58.6359 38.0209C57.9064 38.7504 57.4961 39.7394 57.4948 40.7711V141.388L56.976 141.546L45.8709 144.947C45.3446 145.108 44.7761 145.053 44.2903 144.795C43.8044 144.536 43.4409 144.096 43.2795 143.57L10.2468 35.6631C10.086 35.1367 10.1408 34.5681 10.3991 34.0821C10.6574 33.5962 11.0981 33.2326 11.6243 33.0714L28.7373 27.8311L78.3484 12.6445L95.4613 7.40419C95.7217 7.32404 95.9954 7.29603 96.2667 7.32177C96.5379 7.34751 96.8015 7.42649 97.0422 7.5542C97.2829 7.68191 97.496 7.85583 97.6695 8.06602C97.8429 8.27621 97.9731 8.51854 98.0528 8.77913L106.496 36.3609L106.655 36.8798Z"
                                fill="#F5F5F5" />
                            <path
                                d="M116.53 36.3621L106.353 3.11973C106.184 2.56585 105.907 2.05076 105.539 1.6039C105.171 1.15704 104.718 0.787167 104.206 0.515411C103.695 0.243655 103.135 0.0753432 102.558 0.0200995C101.982 -0.0351441 101.4 0.0237631 100.846 0.193449L76.7865 7.55845L27.178 22.7476L3.11821 30.1152C2.00052 30.4584 1.06466 31.2311 0.516056 32.2637C-0.0325492 33.2963 -0.149081 34.5044 0.192045 35.6228L34.9731 149.232C35.2502 150.134 35.8093 150.925 36.5685 151.486C37.3276 152.048 38.2468 152.352 39.1911 152.352C39.6281 152.353 40.0627 152.287 40.4802 152.158L56.9732 147.109L57.492 146.949V146.406L56.9732 146.565L40.3272 151.662C39.3407 151.963 38.2751 151.86 37.3642 151.376C36.4534 150.892 35.7717 150.067 35.4686 149.081L0.690209 35.4697C0.540037 34.9812 0.487698 34.4678 0.536187 33.9591C0.584677 33.4503 0.733038 32.9561 0.972785 32.5047C1.21253 32.0534 1.53896 31.6538 1.93335 31.3288C2.32775 31.0038 2.78238 30.7598 3.27121 30.6107L27.331 23.2431L76.9397 8.05654L100.999 0.68895C101.37 0.57579 101.756 0.518092 102.143 0.517731C102.975 0.519599 103.785 0.78783 104.453 1.28314C105.122 1.77844 105.614 2.4748 105.858 3.2702L115.988 36.3621L116.149 36.881H116.688L116.53 36.3621Z"
                                fill="#464E49" />
                            <path
                                d="M31.8258 33.1568C31.3259 33.1565 30.8391 32.9959 30.4371 32.6986C30.0351 32.4014 29.7389 31.9831 29.592 31.5052L26.2508 20.5908C26.161 20.2976 26.1298 19.9896 26.1591 19.6844C26.1883 19.3792 26.2774 19.0827 26.4213 18.8119C26.5651 18.5412 26.7609 18.3014 26.9974 18.1063C27.2339 17.9112 27.5066 17.7646 27.7997 17.6748L73.4392 3.70137C74.0312 3.52069 74.6708 3.58231 75.2175 3.87271C75.7641 4.1631 76.1733 4.65855 76.3551 5.2503L79.6963 16.1648C79.8769 16.7569 79.8152 17.3964 79.5248 17.9431C79.2345 18.4898 78.7391 18.899 78.1475 19.0809L32.5079 33.0543C32.2869 33.1222 32.057 33.1567 31.8258 33.1568Z"
                                fill="#52D3A2" />
                            <path
                                d="M49.3287 11.664C52.194 11.664 54.5168 9.34105 54.5168 6.47556C54.5168 3.61006 52.194 1.28711 49.3287 1.28711C46.4634 1.28711 44.1406 3.61006 44.1406 6.47556C44.1406 9.34105 46.4634 11.664 49.3287 11.664Z"
                                fill="#52D3A2" />
                            <path
                                d="M49.3243 9.75847C51.1387 9.75847 52.6096 8.28751 52.6096 6.47298C52.6096 4.65846 51.1387 3.1875 49.3243 3.1875C47.5099 3.1875 46.0391 4.65846 46.0391 6.47298C46.0391 8.28751 47.5099 9.75847 49.3243 9.75847Z"
                                fill="white" />
                            <path
                                d="M156.329 151.025H68.6503C68.0657 151.024 67.5052 150.792 67.0919 150.378C66.6785 149.965 66.446 149.405 66.4453 148.82V43.7539C66.446 43.1693 66.6785 42.6088 67.0918 42.1954C67.5052 41.782 68.0657 41.5495 68.6503 41.5488H156.329C156.914 41.5495 157.474 41.782 157.887 42.1954C158.301 42.6088 158.533 43.1693 158.534 43.7539V148.82C158.533 149.405 158.301 149.965 157.887 150.378C157.474 150.792 156.914 151.024 156.329 151.025Z"
                                fill="#D4DDD7" />
                            <path
                                d="M115.991 36.3574H61.3864C60.2174 36.3591 59.0967 36.8243 58.27 37.651C57.4434 38.4777 56.9782 39.5985 56.9766 40.7676V146.56L57.4954 146.402V40.7676C57.4966 39.7359 57.907 38.7469 58.6364 38.0174C59.3659 37.2879 60.3549 36.8775 61.3864 36.8763H116.152L115.991 36.3574ZM163.592 36.3574H61.3864C60.2174 36.3591 59.0967 36.8243 58.27 37.651C57.4434 38.4777 56.9782 39.5985 56.9766 40.7676V159.583C56.9782 160.752 57.4434 161.873 58.27 162.7C59.0967 163.526 60.2174 163.992 61.3864 163.993H163.592C164.761 163.992 165.882 163.526 166.708 162.7C167.535 161.873 168 160.752 168.002 159.583V40.7676C168 39.5985 167.535 38.4777 166.708 37.651C165.882 36.8243 164.761 36.3591 163.592 36.3574ZM167.483 159.583C167.482 160.615 167.071 161.604 166.342 162.333C165.613 163.063 164.624 163.473 163.592 163.474H61.3864C60.3549 163.473 59.3659 163.063 58.6364 162.333C57.907 161.604 57.4966 160.615 57.4954 159.583V40.7676C57.4966 39.7359 57.907 38.7469 58.6364 38.0174C59.3659 37.2879 60.3549 36.8775 61.3864 36.8763H163.592C164.624 36.8775 165.613 37.2879 166.342 38.0174C167.071 38.7469 167.482 39.7359 167.483 40.7676V159.583Z"
                                fill="#464E49" />
                            <path
                                d="M136.354 47.7795H88.6237C88.0047 47.7788 87.4113 47.5326 86.9736 47.0949C86.5359 46.6572 86.2898 46.0637 86.2891 45.4447V34.0301C86.2898 33.4111 86.536 32.8176 86.9736 32.3799C87.4113 31.9422 88.0047 31.696 88.6237 31.6953H136.354C136.973 31.696 137.567 31.9422 138.004 32.3799C138.442 32.8176 138.688 33.4111 138.689 34.0301V45.4447C138.688 46.0637 138.442 46.6572 138.004 47.0949C137.567 47.5326 136.973 47.7788 136.354 47.7795Z"
                                fill="#52D3A2" />
                            <path
                                d="M112.485 32.4667C115.35 32.4667 117.673 30.1438 117.673 27.2783C117.673 24.4128 115.35 22.0898 112.485 22.0898C109.62 22.0898 107.297 24.4128 107.297 27.2783C107.297 30.1438 109.62 32.4667 112.485 32.4667Z"
                                fill="#52D3A2" />
                            <path
                                d="M112.488 30.4416C114.233 30.4416 115.648 29.0267 115.648 27.2813C115.648 25.536 114.233 24.1211 112.488 24.1211C110.743 24.1211 109.328 25.536 109.328 27.2813C109.328 29.0267 110.743 30.4416 112.488 30.4416Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_8757_81677">
                                <rect width="168" height="164" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <p class="mt-6 text-xl font-bold">No Data</p>
                    <p class="mt-2 text-md">Create financial charts to analyse data</p>
                </div>
            </template>
        </div>
    @else
        <div class="py-10 grid place-items-center">
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
    @endif
</div>
