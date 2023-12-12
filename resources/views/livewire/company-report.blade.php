<div class="w-full">
    <livewire:slides.right-slide />
    <livewire:slides.left-slide />

    <div id="main-report-div" class="py-0 bg-gray-100">
        <div class="flex items-center justify-between">
            <div class="text-lg md:text-xl">
                <h1 class="font-bold">{{ $company['name'] }} ({{ $company['ticker'] }})</h1>
                <p class="mt-2 flex items-center gap-1">
                    <span class="font-bold">${{ number_format($latestPrice, 2) }}</span>
                    <span class="text-md {{ $percentageChange >= 0 ? 'text-green' : 'text-red' }}">
                        ({{ $percentageChange >= 0 ? '+' : '-' }}{{ abs($percentageChange) }}%)
                    </span>
                    <svg class="h-6 w-6 {{ $percentageChange >= 0 ? 'text-green' : 'text-red' }} fill-current"
                        viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.33587 12.6669L3.33596 12.6669L3.33594 11.3336L8.00254 11.3335L8.0026 4.5523L5.36945 7.18547L4.42664 6.24264L8.66927 2L12.9119 6.24264L11.9691 7.18547L9.33594 4.55227L9.33587 12.6669Z" />
                    </svg>
                </p>
            </div>

            <x-download-data-buttons />
        </div>

        <div class="mt-6" x-data="{
            tabActive: $wire.entangle('activeTab'),
            rows: $wire.rows,
            tableDates: $wire.tableDates,
            dateRange: $wire.rangeDates,
            selectedDateRange: $wire.entangle('selectedDateRange', true),
            chart: null,
            filters: {
                view: $wire.entangle('view'),
                period: $wire.entangle('period'),
                unitType: $wire.entangle('unitType', true),
                decimalPlaces: $wire.entangle('decimalPlaces', true),
                order: $wire.entangle('order', true),
                freezePane: $wire.entangle('freezePane', true),
            },
            selectedChartRows: [],
            get formattedChartData() {
                return {
                    labels: this.formattedTableDates,
                    datasets: this.selectedChartRows.map(row => {
                        return {
                            data: Object.entries(row.values).filter(([date]) => {
                                const year = parseInt(date.split('-')[0]);
        
                                return year >= this.selectedDateRange[0] && year <= this.selectedDateRange[1];
                            }).map(entry => {
                                let value = entry[1];
        
                                if (Number.isNaN(value)) {
                                    value = null;
                                } else {
                                    value = Number(value);
                                }
        
                                return {
                                    x: entry[0],
                                    y: value
                                }
                            }),
                            type: row.type,
                            label: row.title,
                            borderColor: row.color,
                            backgroundColor: row.color,
                            pointRadius: 1,
                            pointHoverRadius: 8,
                            tension: 0.5,
                            fill: row.type !== 'line',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 4,
                            pointHoverBackgroundColor: row.color,
                        }
                    })
                }
            },
            get formattedTableDates() {
                let dates = [...this.tableDates];
        
                dates = dates.filter((date) => {
                    const year = parseInt(date.split('-')[0]);
        
                    return year >= this.selectedDateRange[0] && year <= this.selectedDateRange[1];
                })
        
                if (this.filters.order === 'Latest on the Left') {
                    dates = dates.slice().reverse();
                }
        
                return dates
            },
            init() {
                this.initRangeSlider();
        
                this.$watch('filters', (newVal) => {
                    const url = new URL(window.location.href);
        
                    url.searchParams.set('view', newVal.view);
                    url.searchParams.set('period', newVal.period);
                    url.searchParams.set('unitType', newVal.unitType);
                    url.searchParams.set('decimalPlaces', newVal.decimalPlaces);
                    url.searchParams.set('order', newVal.order);
                    url.searchParams.set('freezePane', newVal.freezePane);
        
                    window.history.replaceState({}, '', url);
                }, { deep: true })
        
                this.$watch('selectedChartRows', this.renderChart.bind(this), { deep: true })
        
                this.$watch('selectedDateRange', (newVal) => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('selectedDateRange', newVal.join(','));
                    window.history.replaceState({}, '', url);
        
                    Alpine.debounce(this.renderChart.bind(this), 300)()
                }, { deep: true })
            },
            initRangeSlider() {
                const el = document.getElementById('range-slider-company-report');
        
                if (!el) return;
        
                let rangeMin = this.dateRange[0];
                let rangeMax = this.dateRange[this.dateRange.length - 1];
        
                const alpineThis = this;
        
                rangeSlider(el, {
                    step: 1,
                    min: rangeMin,
                    max: rangeMax,
                    value: this.selectedDateRange,
                    rangeSlideDisabled: true,
                    onInput: (value) => {
                        alpineThis.selectedDateRange = value;
                    }
                });
            },
            formattedTableDate(date) {
                return new Date(date).toLocaleString('en-US', {
                    month: 'short',
                    year: 'numeric',
                })
            },
            isYearInRange(year) {
                return year >= this.selectedDateRange[0] && year <= this.selectedDateRange[1];
            },
            formatTableValue(value) {
                if (value === '' || value === '-' || Number.isNaN(value)) return {
                    result: value,
                };
        
                value = Number(value);
        
                let divideBy = {
                    Thousands: 1000,
                    Millions: 1000000,
                    Billions: 1000000000,
                } [this.filters.unitType] || 1
        
                value = value / divideBy;
        
                const result = Number(Math.abs(value)).toLocaleString('en-US', {
                    style: 'decimal',
                    maximumFractionDigits: this.filters.decimalPlaces,
                });
        
                const isNegative = value < 0;
        
                return {
                    result: isNegative ? `(${result})` : result,
                    isNegative,
                }
            },
            renderChart() {
                {{-- @todo: find efficient way to do this --}}
        
                this.chart?.destroy();
                this.chart = null;
        
                if (!this.selectedChartRows.length) {
                    return;
                }
        
                this.chart = window.renderCompanyReportChart(this.formattedChartData);
            }
        }" wire:key="{{ now() }}">
            <x-primary-tabs :tabs="$tabs" x-modelable="active" x-model="tabActive" min-width="160px">
                @include('partials.company-report.filters')

                @if ($noData)
                    <div class="py-12">
                        <div class="mx-auto flex relative">
                            <div
                                class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-1/2 md:mx-auto">
                                <div class="sm:flex sm:items-center">
                                    <div class="sm:flex-auto">
                                        <h1 class="text-base font-semibold leading-6 text-gray-900">
                                            No data available
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="cus-loader" wire:loading.block>
                                <div class="cus-loaderBar"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="years-range-wrapper my-2">
                        <div class="dots-wrapper">
                            <template x-for="year in dateRange" :key="year">
                                <span :class="isYearInRange(year) ? 'active-dots' : 'inactive-dots'"></span>
                            </template>
                        </div>
                        <div id="range-slider-company-report" class="range-slider"></div>
                    </div>

                    <template x-if="selectedChartRows.length">
                        <div class="mt-7" x-data="{ showGraph: true }">
                            <div class="flex justify-end">
                                <button class="show-hide-chart-btn" @click="showGraph = true" x-show="!showGraph">
                                    Show Chart
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none">
                                        <path
                                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                            fill="#121A0F"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="bg-white rounded-lg p-10 relative" x-show="showGraph">
                                <div class="absolute top-2 right-2 xl:top-3 xl:right-5">
                                    <x-dropdown placement="bottom-start" :shadow="true">
                                        <x-slot name="trigger">
                                            <svg :class="open ? `rotate-90` : ''" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9 21.998L15 21.998C20 21.998 22 19.998 22 14.998L22 8.99805C22 3.99805 20 1.99805 15 1.99805L9 1.99805C4 1.99805 2 3.99805 2 8.99805L2 14.998C2 19.998 4 21.998 9 21.998Z"
                                                    stroke="#121A0F" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <circle cx="12" cy="8" r="1" fill="#121A0F" />
                                                <circle cx="12" cy="12" r="1" fill="#121A0F" />
                                                <circle cx="12" cy="16" r="1" fill="#121A0F" />
                                            </svg>
                                        </x-slot>

                                        <div class="py-4 text-sm+ w-52">
                                            <div class="[&>*]:px-4 [&>*]:w-full [&>*]:p-2 [&>*]:text-left">
                                                <button class="hover:bg-gray-100"
                                                    @click="showGraph = !showGraph; dropdown.hide();"
                                                    x-text="showGraph ? 'Show Chart' : 'Hide Chart'"></button>
                                                <button class="hover:bg-gray-100">View in Full Screen</button>
                                                <button class="hover:bg-gray-100">Print Chart</button>
                                            </div>
                                            <hr class="my-4">
                                            <div class="[&>*]:px-4 [&>*]:w-full [&>*]:p-2">
                                                <button class="hover:bg-gray-100 flex items-center gap-x-2">
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M8.66927 6.66667H12.0026L8.0026 10.6667L4.0026 6.66667H7.33594V2H8.66927V6.66667ZM2.66927 12.6667H13.3359V8H14.6693V13.3333C14.6693 13.7015 14.3708 14 14.0026 14H2.0026C1.63442 14 1.33594 13.7015 1.33594 13.3333V8H2.66927V12.6667Z"
                                                            fill="#121A0F" />
                                                    </svg>

                                                    <span>Download as PDF</span>
                                                </button>
                                                <button class="hover:bg-gray-100 flex items-center gap-x-2">
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M8.66927 6.66667H12.0026L8.0026 10.6667L4.0026 6.66667H7.33594V2H8.66927V6.66667ZM2.66927 12.6667H13.3359V8H14.6693V13.3333C14.6693 13.7015 14.3708 14 14.0026 14H2.0026C1.63442 14 1.33594 13.7015 1.33594 13.3333V8H2.66927V12.6667Z"
                                                            fill="#121A0F" />
                                                    </svg>

                                                    <span>Download as JPEG</span>
                                                </button>
                                                <button class="hover:bg-gray-100 flex items-center gap-x-2">
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M8.66927 6.66667H12.0026L8.0026 10.6667L4.0026 6.66667H7.33594V2H8.66927V6.66667ZM2.66927 12.6667H13.3359V8H14.6693V13.3333C14.6693 13.7015 14.3708 14 14.0026 14H2.0026C1.63442 14 1.33594 13.7015 1.33594 13.3333V8H2.66927V12.6667Z"
                                                            fill="#121A0F" />
                                                    </svg>

                                                    <span>Download as PNG</span>
                                                </button>
                                            </div>
                                        </div>
                                    </x-dropdown>
                                </div>

                                <div class="text-xl text-blue font-bold">
                                    {{ $company['name'] }} ({{ $company['ticker'] }})
                                </div>

                                <div class="mt-10">
                                    <canvas id="chart-company-report" class="chart-company-report"></canvas>
                                </div>
                                <div class="mt-8 flex flex-wrap justify-start items-end gap-3">
                                    <template x-for="item in selectedChartRows" :key="item.id"
                                        :shadow="true">
                                        <div
                                            class="border border-[#D4DDD7] rounded-full p-2 flex items-center justify-between gap-x-6">
                                            <div class="flex items-center gap-x-1" x-data>
                                                <label
                                                    class="h-4 w-4 overflow-clip rounded-full gird place-items-center cursor-pointer"
                                                    :style="`background: ${item.color}`">
                                                    <input type="color" x-model="item.color" class="invisible"
                                                        x-ref="input">
                                                </label>

                                                <x-dropdown placement="bottom-start">
                                                    <x-slot name="trigger">
                                                        <div class="flex items-center gap-x-1">
                                                            <span x-text="item.title"></span>

                                                            <template x-if="item.type === 'line'">
                                                                <svg width="16" height="16"
                                                                    viewBox="0 0 16 16" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M3.33333 2V12.6667H14V14H2V2H3.33333ZM13.2929 3.95956L14.7071 5.37377L10.6667 9.4142L8.66667 7.414L6.04044 10.0405L4.62623 8.6262L8.66667 4.58579L10.6667 6.586L13.2929 3.95956Z"
                                                                        fill="#3561E7" />
                                                                </svg>
                                                            </template>

                                                            <template x-if="item.type === 'bar'">
                                                                <svg width="16" height="16"
                                                                    viewBox="0 0 16 16" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M1.33594 8.66667H5.33594V14H1.33594V8.66667ZM6.0026 2H10.0026V14H6.0026V2ZM10.6693 5.33333H14.6693V14H10.6693V5.33333Z"
                                                                        fill="#3561E7" />
                                                                </svg>
                                                            </template>

                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 16 16" fill="none">
                                                                <path
                                                                    d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                                                    fill="#464E49" />
                                                            </svg>
                                                        </div>
                                                    </x-slot>

                                                    <ul class="w-40">
                                                        <li>
                                                            <button class="flex items-center gap-x-2 p-2"
                                                                @click="item.type = 'line'; $dispatch('hide-dropdown')">
                                                                <svg width="16" height="16"
                                                                    viewBox="0 0 16 16" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M3.33333 2V12.6667H14V14H2V2H3.33333ZM13.2929 3.95956L14.7071 5.37377L10.6667 9.4142L8.66667 7.414L6.04044 10.0405L4.62623 8.6262L8.66667 4.58579L10.6667 6.586L13.2929 3.95956Z"
                                                                        fill="#3561E7" />
                                                                </svg>

                                                                <span>Line Chart</span>

                                                                <template x-if="item.type === 'line'">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        viewBox="0 0 16 16" fill="none">
                                                                        <path
                                                                            d="M8.0026 14.6666C4.3207 14.6666 1.33594 11.6818 1.33594 7.99992C1.33594 4.31802 4.3207 1.33325 8.0026 1.33325C11.6845 1.33325 14.6693 4.31802 14.6693 7.99992C14.6693 11.6818 11.6845 14.6666 8.0026 14.6666ZM8.0026 13.3333C10.9481 13.3333 13.3359 10.9455 13.3359 7.99992C13.3359 5.0544 10.9481 2.66659 8.0026 2.66659C5.05708 2.66659 2.66927 5.0544 2.66927 7.99992C2.66927 10.9455 5.05708 13.3333 8.0026 13.3333ZM7.33767 10.6666L4.50926 7.83818L5.45208 6.89532L7.33767 8.78098L11.1089 5.00973L12.0517 5.95254L7.33767 10.6666Z"
                                                                            fill="#13B05B" />
                                                                    </svg>
                                                                </template>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="flex items-center gap-x-2 p-2"
                                                                @click="item.type = 'bar'; $dispatch('hide-dropdown')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 16 16"
                                                                    fill="none">
                                                                    <path
                                                                        d="M1.33594 8.66667H5.33594V14H1.33594V8.66667ZM6.0026 2H10.0026V14H6.0026V2ZM10.6693 5.33333H14.6693V14H10.6693V5.33333Z"
                                                                        fill="#3561E7" />
                                                                </svg>

                                                                <span>Bar Chart</span>

                                                                <template x-if="item.type === 'bar'">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        viewBox="0 0 16 16" fill="none">
                                                                        <path
                                                                            d="M8.0026 14.6666C4.3207 14.6666 1.33594 11.6818 1.33594 7.99992C1.33594 4.31802 4.3207 1.33325 8.0026 1.33325C11.6845 1.33325 14.6693 4.31802 14.6693 7.99992C14.6693 11.6818 11.6845 14.6666 8.0026 14.6666ZM8.0026 13.3333C10.9481 13.3333 13.3359 10.9455 13.3359 7.99992C13.3359 5.0544 10.9481 2.66659 8.0026 2.66659C5.05708 2.66659 2.66927 5.0544 2.66927 7.99992C2.66927 10.9455 5.05708 13.3333 8.0026 13.3333ZM7.33767 10.6666L4.50926 7.83818L5.45208 6.89532L7.33767 8.78098L11.1089 5.00973L12.0517 5.95254L7.33767 10.6666Z"
                                                                            fill="#13B05B" />
                                                                    </svg>
                                                                </template>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </x-dropdown>
                                            </div>
                                            <button
                                                @click="selectedChartRows = selectedChartRows.filter(row => row.id != item.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <path
                                                        d="M8.0026 14.6693C4.3207 14.6693 1.33594 11.6845 1.33594 8.0026C1.33594 4.3207 4.3207 1.33594 8.0026 1.33594C11.6845 1.33594 14.6693 4.3207 14.6693 8.0026C14.6693 11.6845 11.6845 14.6693 8.0026 14.6693ZM8.0026 13.3359C10.9481 13.3359 13.3359 10.9481 13.3359 8.0026C13.3359 5.05708 10.9481 2.66927 8.0026 2.66927C5.05708 2.66927 2.66927 5.05708 2.66927 8.0026C2.66927 10.9481 5.05708 13.3359 8.0026 13.3359ZM8.0026 7.0598L9.8882 5.17418L10.831 6.11698L8.9454 8.0026L10.831 9.8882L9.8882 10.831L8.0026 8.9454L6.11698 10.831L5.17418 9.8882L7.0598 8.0026L5.17418 6.11698L6.11698 5.17418L8.0026 7.0598Z"
                                                        fill="#C22929" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                    @include('partials.company-report.table')
                @endif
            </x-primary-tabs>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let chart = null;

        document.getElementById('main-report-div')?.addEventListener('click', function() {
            let leftSlideOpen = document.getElementById('leftSlideOpen').value
            let rightSlideOpen = document.getElementById('rightSlideOpen').value

            if (leftSlideOpen || rightSlideOpen) {
                Livewire.emit('closeSlide')
            }
        })

        Livewire.on('slide-over.close', () => {
            slideOpen = false;
        });

        function renderCompanyReportChart(data) {
            const ctx = document.getElementById("chart-company-report").getContext("2d");

            data.datasets.sort((a, b) => {
                // If 'type' is 'line', prioritize it over 'bar'
                if (a.type === 'line' && b.type === 'bar') {
                    return -1;
                } else if (a.type === 'bar' && b.type === 'line') {
                    return 1;
                } else {
                    return 0; // Maintain the order if both are 'line' or both are 'bar'
                }
            })

            return new Chart(ctx, {
                plugins: [chartJsPlugins.pointLine],
                maintainAspectRatio: false,
                aspectRatio: 3,
                responsive: true,
                type: 'line',
                data,
                options: {
                    interaction: {
                        intersect: false,
                        mode: 'nearest',
                        axis: 'xy'
                    },
                    animation: {
                        duration: 0,
                    },
                    title: {
                        display: false,
                    },
                    elements: {
                        line: {
                            tension: 0
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            bodyFont: {
                                size: 15
                            },
                            external: window.chartJsPlugins.largeTooltip,
                            enabled: false,
                            callbacks: {
                                title: function(context) {
                                    return new Date(context[0].label).toLocaleString('en-US', {
                                        month: 'short',
                                        year: 'numeric',
                                    })
                                },
                                label: function(context) {
                                    return context.dataset.label + '|' + context.formattedValue
                                }
                            },
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            type: 'timeseries',
                            time: {
                                displayFormats: {
                                    quarter: 'MMM YYYY'
                                }
                            },
                            ticks: {
                                source: 'data',
                            },
                            align: 'center',
                        },
                        y: {
                            display: true,
                            ticks: {
                                callback: (val) => {
                                    return window.formatCmpctNumber(val)
                                },
                            },
                        }
                    }
                }
            });
        }
    </script>
@endpush
