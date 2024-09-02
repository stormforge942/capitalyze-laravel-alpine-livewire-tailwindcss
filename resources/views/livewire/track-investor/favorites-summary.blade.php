<div class="bg-white rounded-lg py-4 px-6" x-data="{
    loading: true,
    activeTab: $wire.entangle('activeTab', true),
    init() {
        window.favSummaryCharts = window.favSummaryCharts || {};

        $wire.getData()
            .finally(() => {
                this.loading = false;
            });
    },
    changeTab(tab) {
        if (tab === this.activeTab) return;

        {{-- destroy all the charts --}}
        Object.keys(window.favSummaryCharts).forEach(key => {
            window.favSummaryCharts[key].destroy();
            delete window.favSummaryCharts[key];
        });

        this.loading = true;
        this.activeTab = tab;
        $wire.getData()
            .finally(() => {
                this.loading = false;
            });
    },
}">
    <div class="mb-5 flex items-center gap-x-8">
        @foreach ($tabs as $tab => $title)
            <button :class="activeTab === '{{ $tab }}' ? 'ownership-active-bread-link' : ''"
                @click="changeTab('{{ $tab }}')">
                {{ $title }}
            </button>
        @endforeach
    </div>

    <x-tabs class="min-h-[400px]" :tabs="Arr::pluck($data, 'title')" :wire:key="$activeTab" x-cloak x-show="!loading">
        <div>
            @foreach ($data as $idx => $item)
                <div x-show="active === {{ $idx }}" x-data="{
                    data: @js($item['data']),
                    activeRow: 0,
                    period: '1yr',
                    currentPage: 1,
                    perPage: 5,
                    chart: {
                        loading: false,
                        initial: true,
                        data: [],
                    },
                    get activeRowData() {
                        return this.currentPageData[this.activeRow];
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
                        if (!this.activeRowData) return;
                
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
                
                        let chart = window.favSummaryCharts['{{ $item['title'] }}']
                
                        if (chart) {
                            chart.data.datasets[0].data = JSON.parse(JSON.stringify(data));
                            chart.update();
                            return;
                        }
                
                        const canvas = document.getElementById('tbs-{{ \Str::camel($item['title']) }}');
                        if (!canvas) return;
                
                        const ctx = canvas.getContext('2d');
                
                        const gradientBg = ctx.createLinearGradient(0, 0, 0, canvas.height * 2.5)
                        gradientBg.addColorStop(0, 'rgba(19,176,91, 0.18)')
                        gradientBg.addColorStop(1, 'rgba(19,176,91, 0)')
                
                        window.favSummaryCharts['{{ $item['title'] }}'] = new Chart(ctx, {
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
                    },
                    prevPage() {
                        if (this.currentPage > 1) this.currentPage--;
                    },
                    nextPage() {
                        if (this.currentPage < this.totalPages) this.currentPage++;
                    },
                    get currentPageData() {
                        const start = (this.currentPage - 1) * this.perPage;
                
                        return this.data.slice(start, start + this.perPage);
                    },
                    get totalPages() {
                        return Math.ceil(this.data.length / this.perPage);
                    },
                }">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 md:col-span-6 text-sm">
                            <div class="grid grid-cols-6 gap-x-2 font-semibold mb-1.5 px-2">
                                <div class="col-span-2">Fund</div>
                                <div>Company</div>
                                <div class="text-right">% of portfolio</div>
                                <div class="text-right"
                                    x-text="activeTab === 'funds' ? 'Change in shares %' : 'Change in balance'">
                                </div>
                                <div class="text-right">Market Value ($M)</div>
                            </div>
                            <div class="space-y-2">
                                <template x-for="(item, idx) in currentPageData" :key="idx">
                                    <div class="px-2 grid grid-cols-6 gap-x-2 cursor-pointer transition-all rounded"
                                        @click.prevent="updateActiveRow(idx)"
                                        :class="activeRow == idx ? 'bg-green-light4' : 'hover:bg-gray-100'">
                                        <div class="py-1 col-span-2 text-dark-light2" x-text="item.fund_name"></div>
                                        <div class="py-1" x-text="item.company"></div>
                                        <div class="py-1 text-right">
                                            <span :class="item.weight < 0 ? 'text-red' : ''"
                                                x-text="item.weight < 0 ? `(${item.formatted_weight})` : item.formatted_weight"
                                                :data-tooltip-content="item.weight"></span>
                                        </div>
                                        <div class="py-1 text-right">
                                            <span :class="item.change < 0 ? 'text-red' : ''"
                                                x-text="item.change < 0 ? `(${item.formatted_change})` : item.formatted_change"
                                                :data-tooltip-content="item.change"></span>
                                        </div>
                                        <div class="py-1 text-right">
                                            <span :class="item.value < 0 ? 'text-red' : ''"
                                                x-text="item.value < 0 ? `(${item.formatted_value})` : item.formatted_value"
                                                :data-tooltip-content="item.value"></span>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="!data.length">
                                    <div class="text-center py-2 text-gray-600">
                                        No data available
                                    </div>
                                </template>
                            </div>
                            <template x-if="totalPages > 1">
                                <div class="mt-5 flex flex-row-reverse">
                                    <div class="flex items-center gap-x-4">
                                        <button
                                            class="bg-green-light4 rounded h-6 w-6 grid place-items-center disabled:opacity-60 disabled:cursor-not-allowed"
                                            :disabled="currentPage <= 1" @click="prevPage">
                                            <svg width="8" height="12" viewBox="0 0 8 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 12L0 6L6 0L7.4 1.4L2.8 6L7.4 10.6L6 12Z" fill="#121A0F" />
                                            </svg>
                                        </button>
                                        <span class="text-sm">
                                            <span x-text="currentPage"></span>
                                            of
                                            <span x-text="totalPages"></span>
                                            pages
                                        </span>
                                        <button
                                            class="bg-green-light4 rounded h-6 w-6 grid place-items-center disabled:opacity-60 disabled:cursor-not-allowed"
                                            :disabled="currentPage >= totalPages" @click="nextPage">
                                            <svg width="8" height="12" viewBox="0 0 8 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.4 12L0 10.6L4.6 6L0 1.4L1.4 0L7.4 6L1.4 12Z"
                                                    fill="#121A0F" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="border my-5 md:hidden col-span-12"></div>
                        <template x-if="activeRowData">
                            <div class="col-span-12 md:col-span-6 flex flex-col mt-0 md:-mt-[3.75rem]">
                                <div>
                                    <h3 class="text-md font-bold" x-text="activeRowData.company"></h3>
                                    <div class="mt-2 flex items-start sm:items-center justify-between gap-x-3">
                                        <div class="font-semibold whitespace-nowrap"
                                            :class="activeRowData.change < 0 ? 'text-red' : 'text-blue'"
                                            x-text="(activeRowData.change < 0 ? '-' : '+') + activeRowData.formatted_change + ' Change'">
                                        </div>
                                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 text-sm text-gray-medium2">
                                            @foreach ($ranges as $value => $label)
                                                <label class="cursor-pointer flex items-center gap-x-1">
                                                    <input type="radio"
                                                        name="tbs-period-{{ \Str::camel($item['title']) }}"
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
                                <div class="mt-2 w-full flex-1 relative" :class="chart.initial ? 'bg-gray-100/40' : ''"
                                    style="min-height: 350px;">
                                    <canvas id="tbs-{{ \Str::camel($item['title']) }}"
                                        :class="chart.loading ? 'blur-lg' : ''"></canvas>

                                    <span class="simple-loader !text-green-dark absolute z-20"
                                        style="top: 50%; left: 50%; transform: translate(-50%)" x-show="chart.loading"
                                        x-cloak></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            @endforeach
        </div>
    </x-tabs>

    <template x-if="loading">
        <div class="h-[400px] grid place-items-center">
            <span class="simple-loader !text-green-dark"></span>
        </div>
    </template>
</div>
