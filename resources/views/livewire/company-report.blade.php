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
                            pointRadius: 1,
                            pointHoverRadius: 8,
                            tension: 0.5,
                            fill: true,
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 4,
                            pointHoverBackgroundColor: 'rgba(104, 104, 104, 0.87)',
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
                this.$watch('selectedDateRange', this.renderChart.bind(this))
            },
            initRangeSlider() {
                const el = document.getElementById('range-slider-company-report');
        
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
                let [year, month] = date.split('-');
        
                month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'][parseInt(month) - 1];
        
                return `${month} ${year}`;
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
                this.chart?.destroy();
                this.chart = null;
        
                console.log(this)
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
                        <div id="range-slider-company-report" class="range-slider" wire:ignore></div>
                    </div>

                    <template x-if="selectedChartRows.length">
                        <div x-data="{ showGraph: true, menuOpen: false }">
                            <div class="flex justify-end mt-4">
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
                            <div>
                                <div class="mb-4 mt-7 pb-5 w-full px-5 bg-white flex flex-col" x-show="showGraph">
                                    <div class="flex justify-between w-full my-12 pl-6 pr-3">
                                        <div class="text-lg text-blue font-bold">
                                            {{ $company['name'] }} ({{ $company['ticker'] }})
                                        </div>
                                        <div class="flex items-start relative">

                                            <button type="button" class="custom-drop-down-button hide-mobile"
                                                aria-expanded="true" aria-haspopup="true">

                                                <svg xmlns="http://www.w3.org/2000/svg" @click="menuOpen = true"
                                                    x-show="!menuOpen" fill="#121A0F" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z">
                                                    </path>
                                                </svg>

                                                <svg xmlns="http://www.w3.org/2000/svg" @click="menuOpen = false"
                                                    x-show="menuOpen" fill="#121A0F" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="w-6 h-6"
                                                    style="display: none;">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                                                    </path>
                                                </svg>

                                            </button>

                                            <div class="absolute custom-drop-down right-0 z-10 bg-white focus:outline-none"
                                                x-show="menuOpen" role="menu" x-show="showGraph=true"
                                                aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
                                                style="">
                                                <div class="py-1" role="none">
                                                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                                    <div class="links-wrapper mb-3">
                                                        <a href="#" @click="menuOpen = false; showGraph = false;"
                                                            class="menu_link" role="menuitem" tabindex="-1"
                                                            id="menu-item-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                                height="14" viewBox="0 0 14 14" fill="none">
                                                                <path
                                                                    d="M6.99479 13.6666C3.31289 13.6666 0.328125 10.6818 0.328125 6.99992C0.328125 3.31802 3.31289 0.333252 6.99479 0.333252C10.6767 0.333252 13.6615 3.31802 13.6615 6.99992C13.6615 10.6818 10.6767 13.6666 6.99479 13.6666ZM6.99479 6.05712L5.10917 4.17149L4.16636 5.1143L6.05199 6.99992L4.16636 8.88552L5.10917 9.82832L6.99479 7.94272L8.88039 9.82832L9.82319 8.88552L7.93759 6.99992L9.82319 5.1143L8.88039 4.17149L6.99479 6.05712Z"
                                                                    fill="#C22929" />
                                                            </svg>
                                                            Hide Chart</a>
                                                        <a href="#" chartMenuOpen=false" class="menu_link"
                                                            role="menuitem" tabindex="-1" id="menu-item-0"
                                                            style="display: none;">Show
                                                            Chart</a>
                                                        <a href="#" class="menu_link" role="menuitem"
                                                            tabindex="-1" id="menu-item-1">View In Full
                                                            Screen</a>
                                                        <a href="#" class="menu_link" role="menuitem"
                                                            tabindex="-1" id="menu-item-2">Print
                                                            Chart</a>
                                                    </div>
                                                    <hr class="mb-3">
                                                    <div class="links-wrapper">
                                                        <a href="#" class="menu_link" role="menuitem"
                                                            tabindex="-1" id="menu-item-3"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3">
                                                                </path>
                                                            </svg>
                                                            Download As PNG</a>
                                                        <a href="#" class="menu_link" role="menuitem"
                                                            tabindex="-1" id="menu-item-4"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3">
                                                                </path>
                                                            </svg>
                                                            Download As PNG</a>
                                                        <a href="#" class="menu_link" role="menuitem"
                                                            tabindex="-1" id="menu-item-5"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3">
                                                                </path>
                                                            </svg>
                                                            Download As PNG</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 w-full" wire:ignore>
                                        <canvas id="chart-company-report" class="chart-company-report"></canvas>
                                    </div>
                                    <div
                                        class="w-full flex flex-wrap justify-start items-end space-x-3 px-2 mt-8 space-y-3">
                                        <template x-for="item in selectedChartRows" :key="item.id"
                                            :shadow="true">
                                            <x-dropdown placement="bottom-start">
                                                <x-slot name="trigger">
                                                    <div
                                                        class="border border-[#D4DDD7] rounded-full p-2 flex items-center justify-between gap-x-6">
                                                        <div class="flex items-center gap-x-1">
                                                            <div class="h-4 w-4 rounded-full"
                                                                :style="`background: ${item.color}`"></div>
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

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 16 16" fill="none"
                                                            @click.stop="selectedChartRows = selectedChartRows.filter(row => row.id != item.id)">
                                                            <path
                                                                d="M8.0026 14.6693C4.3207 14.6693 1.33594 11.6845 1.33594 8.0026C1.33594 4.3207 4.3207 1.33594 8.0026 1.33594C11.6845 1.33594 14.6693 4.3207 14.6693 8.0026C14.6693 11.6845 11.6845 14.6693 8.0026 14.6693ZM8.0026 13.3359C10.9481 13.3359 13.3359 10.9481 13.3359 8.0026C13.3359 5.05708 10.9481 2.66927 8.0026 2.66927C5.05708 2.66927 2.66927 5.05708 2.66927 8.0026C2.66927 10.9481 5.05708 13.3359 8.0026 13.3359ZM8.0026 7.0598L9.8882 5.17418L10.831 6.11698L8.9454 8.0026L10.831 9.8882L9.8882 10.831L8.0026 8.9454L6.11698 10.831L5.17418 9.8882L7.0598 8.0026L5.17418 6.11698L6.11698 5.17418L8.0026 7.0598Z"
                                                                fill="#C22929" />
                                                        </svg>
                                                    </div>
                                                </x-slot>

                                                <ul class="w-40">
                                                    <li>
                                                        <button class="flex items-center gap-x-2 p-2"
                                                            @click="item.type = 'line'; $dispatch('hide-dropdown')">
                                                            <svg width="16" height="16" viewBox="0 0 16 16"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M3.33333 2V12.6667H14V14H2V2H3.33333ZM13.2929 3.95956L14.7071 5.37377L10.6667 9.4142L8.66667 7.414L6.04044 10.0405L4.62623 8.6262L8.66667 4.58579L10.6667 6.586L13.2929 3.95956Z"
                                                                    fill="#3561E7" />
                                                            </svg>

                                                            <span>Line Chart</span>

                                                            <template x-if="item.type === 'line'">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 16 16"
                                                                    fill="none">
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
                                                                height="16" viewBox="0 0 16 16" fill="none">
                                                                <path
                                                                    d="M1.33594 8.66667H5.33594V14H1.33594V8.66667ZM6.0026 2H10.0026V14H6.0026V2ZM10.6693 5.33333H14.6693V14H10.6693V5.33333Z"
                                                                    fill="#3561E7" />
                                                            </svg>

                                                            <span>Bar Chart</span>

                                                            <template x-if="item.type === 'bar'">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 16 16"
                                                                    fill="none">
                                                                    <path
                                                                        d="M8.0026 14.6666C4.3207 14.6666 1.33594 11.6818 1.33594 7.99992C1.33594 4.31802 4.3207 1.33325 8.0026 1.33325C11.6845 1.33325 14.6693 4.31802 14.6693 7.99992C14.6693 11.6818 11.6845 14.6666 8.0026 14.6666ZM8.0026 13.3333C10.9481 13.3333 13.3359 10.9455 13.3359 7.99992C13.3359 5.0544 10.9481 2.66659 8.0026 2.66659C5.05708 2.66659 2.66927 5.0544 2.66927 7.99992C2.66927 10.9455 5.05708 13.3333 8.0026 13.3333ZM7.33767 10.6666L4.50926 7.83818L5.45208 6.89532L7.33767 8.78098L11.1089 5.00973L12.0517 5.95254L7.33767 10.6666Z"
                                                                        fill="#13B05B" />
                                                                </svg>
                                                            </template>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </x-dropdown>
                                        </template>
                                    </div>
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
            console.log(data)
            const ctx = document.getElementById("chart-company-report").getContext("2d");

            return new Chart(ctx, {
                plugins: [chartJsPlugins.pointLine],
                maintainAspectRatio: false,
                aspectRatio: 3,
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
                                    const inputDate = new Date(context[0].label);
                                    return inputDate.getFullYear();
                                },
                                label: function(context) {
                                    return context.dataset.raw
                                }
                            },
                        }
                    },
                    scales: {
                        x: {
                            offset: false,
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
