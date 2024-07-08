<?php
$ranges = ['3m' => '3m', '6m' => '6m', 'ytd' => 'YTD', '1yr' => '1yr', '5yr' => '5yr', 'max' => 'MAX'];
?>


{{-- Check resources/views/livewire/ownership/fund.blade.php for js code --}}
<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="order-1 col-span-12 2xl:col-span-6 bg-white rounded h-full flex flex-col">
            <div class="px-6 py-3 border-b">
                <h3 class="font-medium text-md">Market Value Overtime</h3>
            </div>
            <div class="p-6 flex-1">
                <x-defer-data-loading on-init="getOverTimeMarketValue" class="h-80">
                    <canvas id="overTimeMarketValue"></canvas>
                </x-defer-data-loading>
            </div>
        </div>

        <div class="order-2 col-span-12 2xl:col-span-6 p-6 bg-white rounded">
            <x-tabs :tabs="['13F Sector Allocation Overtime', '13F Sector Allocation last Quarter']">
                <x-defer-data-loading use-alpine="true" on-init="getSectorAllocationData" class="h-80"
                    @ready="$nextTick(() => {
                        renderLastQuarterSectorAllocation(result.lastQuarterSectorAllocation);
                    })">
                    <div :class="active == 0 ? 'block' : 'hidden'" x-data="{
                        period: '1yr',
                        init() {
                            this.renderChart();           
                            
                            this.$watch('period', () => {
                                this.renderChart();
                            });
                        },
                        renderChart() {
                            const data = result.overTimeSectorAllocation.map(item => ({
                                ...item,
                                data: item.data.filter(item => item.periods.includes(this.period))
                            }))

                            renderOverTimeSectorAllocation(data);
                        }
                    }">
                        <div class="flex items-center flex-wrap gap-x-4 gap-y-2 mb-6 text-gray-medium2">
                            @foreach ($ranges as $value => $label)
                                <label class="cursor-pointer flex items-center gap-x-1">
                                    <input type="radio" name="otsa-period" value="{{ $value }}"
                                        class="custom-radio custom-radio-xs focus:ring-0 border-gray-medium2"
                                        x-model="period">
                                    <span
                                        :class="period === '{{ $value }}' ? 'text-dark' : ''">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div>
                            <canvas id="overTimeSectorAllocation"></canvas>
                        </div>
                    </div>

                    <div :class="active == 1 ? 'block' : 'hidden'" x-cloak>
                        <div>
                            <canvas id="lastQuarterSectorAllocation"></canvas>
                        </div>
                    </div>
                </x-defer-data-loading>
            </x-tabs>
        </div>

        <div class="order-3 col-span-12 2xl:col-span-8 p-6 bg-white rounded">
            <x-tabs :tabs="['Top Buys', 'Top Sells']">
                <x-defer-data-loading use-alpine="true" on-init="getTopBuySells" class="h-80">
                    @foreach (['topBuys', 'topSells'] as $idx => $dataLabel)
                        <div :class="active == {{ $idx }} ? 'block' : 'hidden'" x-data="{
                            activeRow: 0,
                            period: '1yr',
                            chart: {
                                loading: false,
                                initial: true,
                                data: [],
                            },
                            get activeRowData() {
                                return result.{{ $dataLabel }}[this.activeRow];
                            },
                            init() {
                                this.makeChart()
                        
                                let fn = () => this.renderChart();
                                this.$watch('period', Alpine.debounce(fn, 500));
                            },
                            updateActiveRow(idx) {
                                this.activeRow = idx;
                                this.$nextTick(() => {
                                    this.makeChart();
                                });
                            },
                            makeChart() {
                                this.chart.loading = true;
                                this.chart.data = [];
                        
                                return window.http(`/company/${this.activeRowData.symbol}/eod_prices`)
                                    .then(res => res.json())
                                    .then(data => {
                                        this.chart.data = data.map(item => ({
                                            x: item.date,
                                            y: Number(item.adj_close),
                                            periods: item.periods,
                                            formatted_value: item.formatted_value,
                                        }));
                        
                                        this.renderChart();
                                    })
                                    .finally(() => {
                                        this.chart.initial = false;
                                        this.chart.loading = false;
                                    })
                            },
                            renderChart() {
                                const data = this.chart.data.filter(item => item.periods.includes(this.period))
                        
                                if (window.chart_{{ $dataLabel }}) {
                                    window.chart_{{ $dataLabel }}.data.datasets[0].data = JSON.parse(JSON.stringify(data));
                                    window.chart_{{ $dataLabel }}.update();
                                    return;
                                }
                        
                                const canvas = document.getElementById('tbs-{{ $dataLabel }}');
                                if (!canvas) return;
                        
                                const ctx = canvas.getContext('2d');
                        
                                const gradientBg = ctx.createLinearGradient(0, 0, 0, canvas.height * 2.5)
                                gradientBg.addColorStop(0, 'rgba(19,176,91, 0.18)')
                                gradientBg.addColorStop(1, 'rgba(19,176,91, 0)')
                        
                                window.chart_{{ $dataLabel }} = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        datasets: [{
                                            label: 'Price',
                                            data,
                                            borderColor: '#52D3A2',
                                            backgroundColor: gradientBg,
                                            fill: true,
                                            tension: 0.4,
                                            pointRadius: 0,
                                            pointHoverRadius: 6,
                                            pointHoverBackgroundColor: '#52D3A2',
                                            pointHoverBorderWidth: 4,
                                            pointHoverBorderColor: '#fff',
                                        }]
                                    },
                                    options: {
                                        maintainAspectRatio: false,
                                        responsive: true,
                                        interaction: {
                                            intersect: false,
                                            mode: 'index',
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            annotation: false,
                                            addLogo: false,
                                            tooltip: {
                                                bodyFont: {
                                                    size: 15
                                                },
                                                external: window.chartJsPlugins.largeTooltip,
                                                enabled: false,
                                                position: 'nearest',
                                                callbacks: {
                                                    title: function(context) {
                                                        const inputDate = new Date(context[0].label);
                                                        const month = inputDate.getMonth() + 1;
                                                        const day = inputDate.getDate();
                                                        const year = inputDate.getFullYear();
                                                        return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                                                    },
                                                    label: function(context) {
                                                        return `Price|${context.raw.formatted_value}`;
                                                    }
                                                },
                                            }
                                        },
                                        scales: {
                                            x: {
                                                grid: {
                                                    display: false
                                                },
                                                ticks: {
                                                    maxTicksLimit: 6,
                                                },
                                                type: 'time',
                                            },
                                            y: {
                                                display: false
                                            }
                                        }
                                    }
                                });
                            }
                        }">
                            <div x-show="result.{{ $dataLabel }}.length" x-cloak>
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 md:col-span-4 text-sm">
                                        <div class="grid grid-cols-12 gap-x-2 font-semibold mb-1.5 px-2">
                                            <div class="col-span-7">Company</div>
                                            <div class="text-right col-span-5">% Change</div>
                                        </div>
                                        <div class="space-y-2">
                                            <template x-for="(item, idx) in result.{{ $dataLabel }}"
                                                :key="idx">
                                                <div class="px-2 grid grid-cols-12 gap-x-2 cursor-pointer transition-all rounded"
                                                    @click.prevent="updateActiveRow(idx)"
                                                    :class="activeRow == idx ? 'bg-green-light4' : 'hover:bg-gray-100'">
                                                    <div class="col-span-7 py-1 text-dark-light2"
                                                        x-text="item.name_of_issuer">
                                                    </div>
                                                    <div class="col-span-5 py-1 text-right font-medium">
                                                        <span :class="item.change < 0 ? 'text-red' : ''"
                                                            x-text="item.change < 0 ? `(${item.formatted_value})` : item.formatted_value"
                                                            :data-tooltip-content="item.change"></span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="border my-5 md:hidden col-span-12"></div>
                                    <div class="col-span-12 md:col-span-8 flex flex-col mt-0 md:-mt-[3.75rem]">
                                        <div>
                                            <h3 class="text-md font-bold" x-text="activeRowData.name_of_issuer"></h3>
                                            <div class="mt-2 flex items-start sm:items-center justify-between gap-x-3">
                                                <div class="font-semibold whitespace-nowrap"
                                                    :class="activeRowData.change < 0 ? 'text-red' : 'text-blue'"
                                                    x-text="(activeRowData.change < 0 ? '-' : '+') + activeRowData.formatted_value + ' Change'">
                                                </div>
                                                <div
                                                    class="grid grid-cols-3 sm:grid-cols-6 gap-3 text-sm text-gray-medium2">
                                                    @foreach ($ranges as $value => $label)
                                                        <label class="cursor-pointer flex items-center gap-x-1">
                                                            <input type="radio" name="tbs-period-{{ $dataLabel }}"
                                                                value="{{ $value }}"
                                                                class="custom-radio custom-radio-xs focus:ring-0 border-gray-medium2"
                                                                x-model="period">
                                                            <span
                                                                :class="period === '{{ $value }}' ? 'text-dark' : ''">{{ $label }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2 w-full flex-1 relative"
                                            :class="chart.initial ? 'bg-gray-100/40' : ''" style="min-height: 350px;">
                                            <canvas id="tbs-{{ $dataLabel }}"
                                                :class="chart.loading ? 'blur-lg' : ''"></canvas>

                                            <span class="simple-loader !text-green-dark absolute z-20"
                                                style="top: 50%; left: 50%; transform: translate(-50%)"
                                                x-show="chart.loading" x-cloak></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <template x-if="!result.{{ $dataLabel }}.length">
                                <div class="grid place-items-center text-dark-light2 col-span-12 min-h-[400px]">
                                    No data available
                                </div>
                            </template>
                        </div>
                    @endforeach
                </x-defer-data-loading>
            </x-tabs>
        </div>

        <div class="order-4 col-span-12 2xl:col-span-4 p-6 bg-white rounded">
            <h3 class="mb-4 text-sm font-semibold text-blue">13F Holding Summary</h3>

            <x-defer-data-loading use-alpine="true" on-init="getHoldingSummary" class="h-32">
                <div class="space-y-4" :data-result="JSON.stringify(result)">
                    <template x-for="(item, idx) in result" :key="idx">
                        <div class="flex items-center justify-between gap-5">
                            <span class="text-sm" x-text="item.name"></span>
                            <span class="font-semibold" x-text="`${item.weight}%`"></span>
                        </div>
                    </template>
                </div>

                <template x-if="result?.length == 7">
                    <div class="flex justify-center mt-6">
                        <a href="#" class="text-xs+ font-semibold bg-green-light4 px-4 py-1 rounded"
                            @click.prevent="changeTab('holdings')">
                            View All Holdings
                        </a>
                    </div>
                </template>
            </x-defer-data-loading>
        </div>

        <div class="order-5 col-span-12">
            <div class="p-6 bg-white rounded xl:inline-block">
                <h3 class="mb-4 text-sm font-semibold text-blue">13F Activity</h3>

                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                    @foreach ($summary as $item)
                        <div>
                            <p class="text-sm text-dark-light2 whitespace-nowrap">{{ $item['title'] }}</p>

                            <p class="font-semibold">
                                @if ($item['type'] === 'link')
                                    <a href="{{ $item['value'] }}" class="underline text-blue"
                                        target="_blank">{{ $item['value'] }}</a>
                                @else
                                    <span>{{ $item['value'] }}</span>
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
