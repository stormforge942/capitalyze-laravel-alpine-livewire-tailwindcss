<div class="chart-builder-page">
    <div>
        <h1 class="text-xl font-bold">Chart</h1>
        <p class="mt-2 text-dark-light2">Build custom charts to visualize financial data across companies</p>
    </div>

    <div class="mt-8">
        @livewire('builder.chart-tabs')
    </div>

    @if ($tab)
        <div x-data="{
            filters: $wire.tab.filters,
            dates: @js($dates),
            data: @js($data),
            init() {},
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
        }">
            <div class="mt-6 grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div>
                    <livewire:builder.select-company :selected="$tab['companies']" :wire:key="'select-company-' . $tab['id']" />
                </div>

                <div>
                    <livewire:builder.select-chart-metrics :selected="$tab['metrics']"
                        :wire:key="'select-metrics-' . $tab['id']" />
                </div>
            </div>

            <div class="mt-6">
                <x-filter-box>
                    <div class="flex items-center gap-x-1">
                        <span class="text-sm text-dark-light2">Period Type</span>
                        <x-select placeholder="Period Type" :options="['annual' => 'Annual', 'quarter' => 'Quarterly']" x-model="filters.period"></x-select>
                    </div>

                    <div class="flex-1">
                        <x-range-slider :min="2002" :max="date('Y')"></x-range-slider>
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

            <div class="mt-6 rounded-lg sticky-table-container">
                <table class="round-lg text-right whitespace-nowrap sticky-table sticky-column">
                    <thead>
                        <tr class="capitalize text-dark bg-[#EDEDED] text-base font-bold">
                            <th class="pl-8 py-2 bg-[#EDEDED] text-left">
                                Metric
                            </th>
                            <template x-for="date in dates" :key="date">
                                <th class="pl-6 py-2 last:pr-8" x-text="formatDate(date)"></th>
                            </template>
                        </tr>
                    </thead>
                    <template x-for="(metrics, company) in data" :key="company">
                        <tbody class="report-tbody">
                            <template x-for="(timeline, metric) in metrics" :key="company + '-' + metric">
                                <tr class="border-b last:border-b-0">
                                    <td class="pl-6 text-left py-2">
                                        <span x-text="`${company} - ${$wire.metricsMap[metric].title}`"></span>
                                    </td>
                                    <template x-for="date in dates" :key="date">
                                        <td class="pl-6 last:pr-8 py-2 bg-white"
                                            :class="timeline[date] < 0 ? 'text-red' : ''"
                                            x-text="timeline[date] ? (timeline[date] < 0 ? `(${formatValue(-1 * timeline[date], !$wire.metricsMap[metric].yAxis)})` : formatValue(timeline[date], !metricsMap[metric].yAxis)) : '-'">
                                        </td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                    </template>
                </table>
            </div>
        </div>
    @else
        <div class="py-10 grid place-items-center">
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
    @endif
</div>
