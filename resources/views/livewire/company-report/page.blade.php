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
                    showLabel: false,
                    disclosureTab: $wire.entangle('disclosureTab'),
                    publicView: false,
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
                                    tension: 0.5,
                                    fill: true,
                                    pointBackgroundColor: row.color,
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
                
                            if (!row.seg_start || this.showAllRows) {
                                rows.push(_row);
                            }
                
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

                        <div class="hidden mb-6 border-b gap-x-1 border-[#D4DDD7] px-3 overflow-x-auto lg:flex items-center gap text-gray-medium2 whitespace-nowrap font-medium"
                            style="line-height: 16px">
                            @foreach ($disclosureTabs as $dtab => $title)
                                <button class="px-6 py-2 border-b-2 transition-all"
                                    :class="disclosureTab === `{{ $dtab }}` ?
                                        'font-medium border-green' : 'border-transparent hover:border-gray-medium'"
                                    @click="disclosureTab = `{{ $dtab }}`">
                                    {{ $title }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    @include('partials.company-report.filters')

                    @if ($noData)
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
                    @else
                        <div class="mt-6">
                            <x-range-slider :min="$rangeDates[0]" :max="$rangeDates[count($rangeDates) - 1]" :value="$selectedDateRange"
                                @range-updated="selectedDateRange = $event.detail">
                            </x-range-slider>
                        </div>

                        <template x-if="selectedChartRows.length">
                            <div class="mt-6" x-data="{
                                printChart() {
                                    window.printChart(this.$el.querySelector('canvas'))
                                }
                            }"
                                @download-chart="Livewire.emit('modal.open', 'upgrade-account-modal')"
                                @print-chart="printChart"
                                @full-screen="fullScreen($el.querySelector('canvas').parentElement)"
                                @clear-chart="selectedChartRows = []">
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

                                            <x-chart-options :toggleFeature="false">
                                                <x-slot name="top">
                                                    <button class="hover:bg-gray-100 flex items-center gap-x-2"
                                                        @click="dropdown.hide(); $dispatch('clear-chart')">
                                                        <svg width="16" height="16" viewBox="0 0 16 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.99479 14.6666C4.31289 14.6666 1.32812 11.6818 1.32812 7.99992C1.32812 4.31802 4.31289 1.33325 7.99479 1.33325C11.6767 1.33325 14.6615 4.31802 14.6615 7.99992C14.6615 11.6818 11.6767 14.6666 7.99479 14.6666ZM7.99479 7.05712L6.10917 5.17149L5.16636 6.1143L7.05199 7.99992L5.16636 9.88552L6.10917 10.8283L7.99479 8.94272L9.88039 10.8283L10.8232 9.88552L8.93759 7.99992L10.8232 6.1143L9.88039 5.17149L7.99479 7.05712Z"
                                                                fill="#C22929" />
                                                        </svg>
                                                        <span>Clear Chart</span>
                                                    </button>
                                                </x-slot>
                                            </x-chart-options>
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

                                    <div class="mt-4 h-[300px] sm:h-[345px]">
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
                                                                    height="16" viewBox="0 0 16 16"
                                                                    fill="none">
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
                    layout: {
                        padding: {
                            top: 25,
                        }
                    },
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
                            align: (ctx) => {
                                if (ctx.dataset.type === 'line') {
                                    return 'end';
                                }

                                return 'center';
                            },
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
