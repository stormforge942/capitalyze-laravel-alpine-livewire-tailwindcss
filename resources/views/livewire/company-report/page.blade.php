@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
@endpush

<div class="w-full">
    <livewire:slides.left-slide />

    <div id="main-report-div" class="py-0 bg-gray-100">
        <x-company-info-header :company="$company">
            <x-download-data-buttons />
        </x-company-info-header>

        <div class="mt-6">
            <x-primary-tabs :tabs="$tabs" :active="$activeTab" @tab-changed="$wire.activeTab = $event.detail.key"
                min-width="160px">
                <div x-data="{
                    rowGroups: [],
                    tableDates: @js($tableDates),
                    formattedTableDates: [],
                    selectedDateRange: $wire.entangle('selectedDateRange', true),
                    chart: null,
                    showLabel: true,
                    disclosureTab: $wire.entangle('disclosureTab'),
                    filters: {
                        view: $wire.entangle('view'),
                        period: $wire.entangle('period'),
                        unitType: $wire.entangle('unitType', true),
                        decimalPlaces: $wire.entangle('decimalPlaces', true),
                        order: $wire.entangle('order', true),
                        freezePane: $wire.entangle('freezePane', true),
                        footnote: $wire.entangle('disclosureFootnote'),
                    },
                    selectedChartRows: [],
                    hideSegments: [],
                    showAllRows: false,
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
                                    backgroundColor: row.type == 'line' ? window.chartJsPlugins.makeLinearGradientBackgroundColor([
                                        [0.2, window.hex2rgb(row.color, 0.2)],
                                        [1, window.hex2rgb(row.color, 0)],
                                    ]) : row.color,
                                    pointRadius: 1,
                                    pointHoverRadius: 8,
                                    tension: 0.5,
                                    fill: true,
                                    pointHoverBorderColor: '#fff',
                                    pointHoverBorderWidth: 4,
                                    pointHoverBackgroundColor: row.color,
                                    maxBarThickness: 150,
                                    isPercent: row.isPercent,
                                }
                            })
                        }
                    },
                    get isReversed() {
                        return this.filters.order === 'Latest on the Left';
                    },
                    get tableClasses() {
                        const classes = {
                            'Top Row': ['sticky-row'],
                            'First Column': ['sticky-column'],
                            'Top Row & First Column': ['sticky-row', 'sticky-column']
                        };
                
                        return 'sticky-table ' + (classes[this.filters.freezePane] || []).join(' ');
                    },
                    init() {
                        const rows = @js($rows);
                
                        this.updateFormattedTableDates(this.tableDates);
                        this.updateRowGroups(rows);
                
                        this.$watch('showAllRows', this.updateRowGroups.bind(this, rows))
                        this.$watch('filters.unitType', () => {
                            this.updateRowGroups(rows);
                            this.renderChart();
                        })
                        this.$watch('filters.decimalPlaces', () => {
                            this.updateRowGroups(rows)
                
                            this.renderChart();
                
                            window.updateUserSettings({
                                decimalPlaces: this.filters.decimalPlaces
                            })
                        })
                
                        this.$watch('filters', (newVal, oldVal) => {
                            const url = new URL(window.location.href);
                
                            url.searchParams.set('view', newVal.view);
                            url.searchParams.set('period', newVal.period);
                            url.searchParams.set('unitType', newVal.unitType);
                            url.searchParams.set('decimalPlaces', newVal.decimalPlaces);
                            url.searchParams.set('order', newVal.order);
                            url.searchParams.set('freezePane', newVal.freezePane);
                            url.searchParams.set('disclosureFootnote', newVal.footnote);
                
                            window.history.replaceState({}, '', url);
                        }, { deep: true })
                
                        this.$watch('filters.order', () => {
                            this.renderChart()
                            this.updateFormattedTableDates(this.tableDates);
                        })
                
                        this.$watch('disclosureTab', (val) => window.updateQueryParam('disclosureTab', val))
                
                        this.$watch('selectedChartRows', this.renderChart.bind(this), { deep: true })
                
                        this.$watch('showLabel', this.renderChart.bind(this))
                
                        this.$watch('selectedDateRange', (val) => {
                            window.updateQueryParam('selectedDateRange', val.join(','))
                
                            Alpine.debounce(this.renderChart.bind(this), 100)()
                
                            this.updateFormattedTableDates(this.tableDates);
                
                            this.updateRowGroups(rows);
                        }, { deep: true })
                    },
                    updateFormattedTableDates(_dates) {
                        let dates = [..._dates];
                
                        dates = dates.filter((date) => {
                            const year = parseInt(date.split('-')[0]);
                
                            return year >= this.selectedDateRange[0] && year <= this.selectedDateRange[1];
                        })
                
                        if (this.isReversed) {
                            dates = dates.slice().reverse();
                        }
                
                        this.formattedTableDates = dates;
                    },
                    formattedTableDate(date) {
                        const includeMonth = !['Calendar Annual', 'Fiscal Annual'].includes(this.filters.period);
                
                        return new Date(date).toLocaleString('en-US', {
                            year: 'numeric',
                            month: includeMonth ? 'short' : undefined,
                        })
                    },
                    isYearInRange(year) {
                        return year >= this.selectedDateRange[0] && year <= this.selectedDateRange[1];
                    },
                    formatTableValue(value, isPercent) {
                        value = value == null ? '' : value;
                
                        if (value === '' || value === '-' || isNaN(Number(value))) {
                            const isLink = value.startsWith('@@@');
                
                            const parser = new DOMParser();
                
                            return {
                                result: isLink ? value.slice(3) : parser.parseFromString(value, 'text/html').body.innerText,
                                isLink,
                            };
                        }
                
                        value = Number(value);
                
                        if (!isPercent) {
                            let divideBy = {
                                Thousands: 1000,
                                Millions: 1000000,
                                Billions: 1000000000,
                            } [this.filters.unitType] || 1
                
                            value = value / divideBy;
                        }
                
                        const result = Number(Math.abs(value)).toLocaleString('en-US', {
                            style: 'decimal',
                            minimumFractionDigits: this.filters.decimalPlaces,
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
                
                        this.chart = window.renderCompanyReportChart(
                            this.formattedChartData,
                            this.isReversed,
                            this.showLabel, {
                                unit: this.filters.unitType,
                                decimalPlaces: this.filters.decimalPlaces,
                            });
                    },
                    toggleSegment(id) {
                        if (this.hideSegments.includes(id)) {
                            this.hideSegments = this.hideSegments.filter(item => item !== id);
                        } else {
                            this.hideSegments.push(id);
                        }
                    },
                    toggleRowForChart(row) {
                        if (row.empty || row.seg_start) return;
                
                        if (this.selectedChartRows.find(item => item.id === row.id) ? true : false) {
                            this.selectedChartRows = this.selectedChartRows.filter(item => item.id !== row.id);
                        } else {
                            let values = {};
                
                            for (const [key, value] of Object.entries(row.values)) {
                                values[key] = value.value;
                            }
                
                            this.selectedChartRows.push({
                                id: row.id,
                                title: row.title,
                                values,
                                color: '#7C8286',
                                type: 'line',
                                isPercent: row.isPercent,
                            });
                        }
                    },
                    updateRowGroups(rows_) {
                        let rows = [];
                
                        const addRow = (row, section = 0, depth = 0, parent = null) => {
                            if (
                                this.hideSegments.includes(parent) ||
                                this.hideSegments.includes(row.id) ||
                                (!this.showAllRows && (row.mismatchedSegmentation || (row.empty && !row.children.length)))
                            ) {
                                return;
                            }
                
                            if (
                                !this.showAllRows &&
                                !row.children.length &&
                                !Object.entries(row.values).find(([key, value]) => !value.empty && this.formattedTableDates.includes(key))
                            ) {
                                return;
                            }
                
                            let _row = {
                                ...row,
                                values: {},
                                section,
                                depth,
                                parent,
                            };
                
                            delete _row.children;
                
                            Object.entries(row.values).forEach(([key, value]) => {
                                _row.values[key] = {
                                    ...value,
                                    ...this.formatTableValue(value.value, row.isPercent)
                                };
                            });
                
                            rows.push(_row);
                
                            row.children.forEach(child => {
                                addRow(child, section, depth + 1, _row.id);
                            });
                        }
                
                        rows_.forEach(row => {
                            addRow(row);
                        });
                
                        {{-- now group by sections --}}
                        let sections = []
                        let nonSectionRows = []
                
                        rows.forEach(row => {
                            if (row.section) {
                                if (!sections[row.section]) {
                                    sections[row.section] = []
                                }
                
                                sections[row.section].push(row)
                                return;
                            }
                
                            nonSectionRows.push(row)
                        })
                
                        sections.push(nonSectionRows)
                
                        let tmp = Object.values(sections)
                
                        {{-- clean the empty seg_start which has no children after filtering --}}
                        tmp.forEach((section, index) => {
                            let segments = section.map(row => row.segmentation ? row.parent : null).filter(Boolean)
                
                            section.forEach((row, index) => {
                                if (row.seg_start && !segments.includes(row.id)) {
                                    section.splice(index, 1)
                                }
                            })
                        })
                
                        this.rowGroups = tmp;
                    }
                }" wire:key="{{ \Str::uuid() }}">
                    @if ($activeTab === 'disclosure' && count($disclosureTabs))
                        <div class="mb-6 flex lg:hidden flex-wrap items-center gap-x-2 gap-y-4 text-sm">
                            @foreach ($disclosureTabs as $dtab => $title)
                                <button class="p-2 border rounded-full transition"
                                    :class="disclosureTab === `{{ $dtab }}` ?
                                        'border-green-dark bg-green bg-opacity-20' :
                                        'border-[#D1D3D5] hover:bg-gray-200'"
                                    @click="disclosureTab = `{{ $dtab }}`">
                                    {{ $title }}
                                </button>
                            @endforeach
                        </div>

                        <div class="hidden mb-6 border-b border-[#D4DDD7] px-3 overflow-x-auto lg:flex items-center gap text-gray-medium2 whitespace-nowrap font-medium"
                            style="line-height: 16px">
                            @foreach ($disclosureTabs as $dtab => $title)
                                <button class="px-6 py-2"
                                    :class="disclosureTab === `{{ $dtab }}` ?
                                        'font-medium border-b-2 border-green' : ''"
                                    @click="disclosureTab = `{{ $dtab }}`">
                                    {{ $title }}
                                </button>
                            @endforeach
                        </div>
                    @endif

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
                        <div class="mt-6 mb-8">
                            <x-range-slider :min="$rangeDates[0]" :max="$rangeDates[count($rangeDates) - 1]" :value="$selectedDateRange"
                                @range-updated="selectedDateRange = $event.detail">
                            </x-range-slider>
                        </div>

                        <template x-if="selectedChartRows.length">
                            <div class="mt-7" x-data="{
                                printChart() {
                                    window.printChart(this.$el.querySelector('canvas'))
                                }
                            }"
                                @download-chart="Livewire.emit('modal.open', 'upgrade-account-modal')"
                                @print-chart="printChart"
                                @full-screen="fullScreen($el.querySelector('canvas').parentElement)">
                                <div class="bg-white rounded-lg p-10 relative">
                                    <div class="absolute top-2 right-2 xl:top-3 xl:right-5">
                                        <x-dropdown placement="bottom-start" :shadow="true">
                                            <x-slot name="trigger">
                                                <svg :class="open ? `rotate-90` : ''" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 21.998L15 21.998C20 21.998 22 19.998 22 14.998L22 8.99805C22 3.99805 20 1.99805 15 1.99805L9 1.99805C4 1.99805 2 3.99805 2 8.99805L2 14.998C2 19.998 4 21.998 9 21.998Z"
                                                        stroke="#121A0F" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <circle cx="12" cy="8" r="1" fill="#121A0F" />
                                                    <circle cx="12" cy="12" r="1" fill="#121A0F" />
                                                    <circle cx="12" cy="16" r="1" fill="#121A0F" />
                                                </svg>
                                            </x-slot>

                                            <x-chart-options :toggleFeature="false"></x-chart-options>
                                        </x-dropdown>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="text-xl text-blue font-bold">
                                            {{ $company['name'] }} ({{ $company['ticker'] }})
                                        </div>

                                        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                            <input type="checkbox" value="yes" class="sr-only peer"
                                                :checked="showLabel" @change="showLabel = $event.target.checked">
                                            <div
                                                class="w-6 h-2.5 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:-start-[4px] after:bg-white after:rounded-full after:h-4 after:w-4 after:shadow-md after:transition-all peer-checked:bg-dark-light2 peer-checked:after:bg-dark">
                                            </div>
                                            <span class="ms-3 text-sm font-medium text-gray-900">Show Labels</span>
                                        </label>
                                    </div>

                                    <div class="mt-10 h-[300px] sm:h-[400px]">
                                        <canvas id="chart-company-report"></canvas>
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
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        viewBox="0 0 16 16" fill="none">
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
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" viewBox="0 0 16 16" fill="none">
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
                </div>
            </x-primary-tabs>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let chart = null;

        function renderCompanyReportChart(data, reversed, showLabel, config) {
            const ctx = document.getElementById("chart-company-report")?.getContext("2d");

            if (!ctx) return;

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
                plugins: [chartJsPlugins.pointLine, window.ChartDataLabels],
                type: 'line',
                data,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
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
                                    let y = context.raw.y

                                    if (context.dataset.isPercent) {
                                        y = window.formatNumber(y, {
                                            decimalPlaces: config.decimalPlaces,
                                        })
                                    } else {
                                        y = window.formatNumber(y, config);
                                    }

                                    return context.dataset.label + '|' + y
                                }
                            },
                        },
                        datalabels: {
                            display: (ctx) => showLabel ? 'auto' : false,
                            anchor: "center",
                            align: "center",
                            formatter: (v, ctx) => {
                                let y = v.y

                                if (ctx.dataset.isPercent) {
                                    return window.formatNumber(y, {
                                        decimalPlaces: config.decimalPlaces,
                                    })
                                }

                                return window.formatNumber(y, config);
                            },
                            font: {
                                weight: 500,
                                size: 12,
                            },
                            color: (ctx) => ctx.dataset?.type !== "line" ? '#fff' : '#121A0F',
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
                            reverse: reversed,
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
