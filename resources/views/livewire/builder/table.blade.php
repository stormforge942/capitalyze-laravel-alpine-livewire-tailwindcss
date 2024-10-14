<div>
    <div>
        <h1 class="text-xl font-bold">Table</h1>
        <p class="mt-2 text-dark-light2">Build custom table to visualize financial data across companies</p>
    </div>

    <div class="mt-8">
        @livewire('builder.table-tabs')
    </div>

    @if ($tab)
        <div class="mt-6 relative" x-data="{
            settings: @js($settings),
            summaries: @js($summaries),
            tableOrder: @js($tableOrder),
            metrics: @js($metrics),
            summaryRows: [],
            tableRows: [],
            columns: [],
            init() {
                this.makeTableRows()

                this.$watch('summaries', () => {
                    window.http('{{ route('table-builder.update', $tab['id']) }}', {
                        method: 'POST',
                        body: {
                            summaries: this.summaries
                        }
                    })
                    this.makeSummaryRows()
                })

                this.$watch('metrics', () => {
                    window.http('{{ route('table-builder.update', $tab['id']) }}', {
                        method: 'POST',
                        body: {
                            metrics: this.metrics
                        }
                    })

                    this.makeTableRows()
                }, { deep: true })

                this.$watch('settings', () => {
                    this.makeTableRows();

                    window.http('{{ route('table-builder.update', $tab['id']) }}', {
                        method: 'POST',
                        body: {
                            settings: this.settings
                        }
                    })
                }, { deep: true })

                this.$nextTick(() => this.makeTableArrangeable())
            },
            makeTableRows() {
                const allMetrics = @js($allMetrics);
                const data = @js($data);
                const notes = @js($notes);

                this.tableRows = [];

                this.columns = [];

                if (!$wire.companies.length || !this.metrics.length)
                    return;

                this.metrics.forEach(item => {
                    if (!allMetrics[item.metric])
                        return;

                    const type = {
                        'value': null,
                        'growth': '% Growth YoY',
                        'cagr': 'CAGR'
                    } [item.type];

                    if (item.type === 'cagr') {
                        let label = allMetrics[item.metric].title + (type ? ` - ${type}` : '') + `<br>(${item.dates.join(' - ')})`;

                        this.columns.push({
                            label,
                            metric: item.metric,
                            type: item.type,
                            dates: item.dates,
                            applyUnits: false,
                        })

                        return;
                    }

                    let label = allMetrics[item.metric].title + (type ? ` - ${type}` : '');

                    item.dates.forEach(date => {
                        this.columns.push({
                            label: `${label}<br>(${date})`,
                            metric: item.metric,
                            type: item.type,
                            date,
                            applyUnits: allMetrics[item.metric].type != 'ratio' && item.type != 'growth'
                        })
                    })
                })

                $wire.companies.forEach(company => {
                    let d = {};

                    this.columns.forEach(column => {
                        if (column.type === 'growth') {
                            const lastValue = data[company]?.[column.metric]?.[this.getOldDate(column.date)] || null;
                            const value = data[company]?.[column.metric]?.[column.date] || null;

                            if (lastValue === null || value === null) {
                                d[column.label] = null;
                                return;
                            }

                            d[column.label] = lastValue ? (value / lastValue) - 1 : 0;
                            return;
                        }

                        if (column.type === 'cagr') {
                            let range = column.dates;

                            if (range[0] > range[1]) {
                                range.reverse();
                            }

                            const sv = data[company]?.[column.metric]?.[range[0]] || null;
                            const ev = data[company]?.[column.metric]?.[range[1]] || null;

                            const n = Math.abs(range[0].split(' ')[1] - range[1].split(' ')[1]);

                            d[column.label] = sv && ev ? ((ev / sv) ** 1 / n) - 1 : 'N/A'
                            return;
                        }

                        d[column.label] = data[company]?.[column.metric]?.[column.date] || 'N/A';
                    })

                    this.tableRows.push({
                        ticker: company,
                        name: company,
                        sector: '-',
                        marketCap: '-',
                        stockPrice: '-',
                        totalReturn: '-',
                        totalRevenue: '-',
                        columns: d,
                        note: notes?.[company] || null,
                    });
                })

                const order = this.tableOrder.data_rows || [];
                this.tableRows.sort((a, b) => {
                    if (!order.includes(a.ticker) || !order.includes(b.ticker))
                        return 0;

                    return order.indexOf(a.ticker) - order.indexOf(b.ticker)
                })

                this.makeSummaryRows()
            },
            makeSummaryRows() {
                if (!this.tableRows.length)
                    return;

                const summaryHandler = {
                    'Max': (values) => {
                        values = values.filter(value => value !== 'N/A');

                        if (!values.length)
                            return '-';

                        return Math.max(...values)
                    },
                    'Min': (values) => {
                        values = values.filter(value => value !== 'N/A');

                        if (!values.length)
                            return '-';

                        return Math.min(...values)
                    },
                    'Sum': (values) => {
                        values = values.filter(value => value !== 'N/A');

                        if (!values.length)
                            return '-'

                        return values.reduce((a, b) => a + b, 0)
                    },
                    'Median': (values) => {
                        values = values.filter(value => value !== 'N/A');

                        if (!values.length)
                            return '-';

                        values.sort((a, b) => a - b);
                        const half = Math.floor(values.length / 2);
                        return values.length % 2 ? values[half] : (values[half - 1] + values[half]) / 2;
                    }
                }

                this.summaryRows = this.summaries.map(summary => {
                    const row = {
                        title: summary.toUpperCase(),
                        columns: this.columns.reduce((obj, col) => {
                            const values = this.tableRows.map(row => row.columns[col.label] || null).filter(v => v !== null);

                            obj[col.label] = summaryHandler[summary](values);

                            return obj
                        }, {})
                    }

                    return row;
                })
            },
            formatTableValue(value, applyUnits) {
                const formatted = window.formatNumber(value, {
                    unit: applyUnits ? this.settings.unit : 'None',
                    decimalPlaces: this.settings.decimalPlaces
                });

                return value < 0 ? '(' + formatted + ')' : formatted;
            },
            tooltipValue(value) {
                if (isNaN(value))
                    return '';

                return Intl.NumberFormat('en-US').format(value);
            },
            makeTableArrangeable() {
                const table = this.$el.querySelector('table')
                let draggingRow = null

                table.addEventListener('dragover', (e) => {
                    e.preventDefault();

                    const targetRow = e.target.closest('tr');

                    if (!draggingRow || !targetRow.draggable || !targetRow.classList.contains('data-row'))
                        return;

                    let children = Array.from(targetRow.parentNode.children);

                    if (children.indexOf(targetRow) > children.indexOf(draggingRow))
                        targetRow.after(draggingRow);
                    else
                        targetRow.before(draggingRow);
                });

                table.querySelectorAll('.data-row').forEach(row => {
                    row.addEventListener('dragstart', (e) => {
                        e.dataTransfer.effectAllowed = 'move';
                        e.dataTransfer.setData('text/html', null);
                        e.target.classList.add('opacity-70');
                        draggingRow = e.target;
                    });

                    row.addEventListener('dragend', (e) => {
                        e.target.classList.remove('opacity-70');
                        e.dataTransfer.clearData();
                        draggingRow = null;
                        this.updateRowsOrder()
                    });
                });
            },
            updateRowsOrder() {
                const order = [...this.$el.querySelectorAll('.data-row')].map(row => row.dataset.key);

                this.tableOrder.data_rows = order;

                http('{{ route('table-builder.update.table-order', $tab['id']) }}', {
                    method: 'POST',
                    body: {
                        data_rows: order
                    }
                })
            },
            getOldDate(date) {
                // date can be Q YYYY or FY YYYY
                if (date.startsWith('Q')) {
                    const [q, y] = date.split(' ');
                    const prevQuarter = q === 'Q1' ? 'Q4' : `Q${parseInt(q.slice(1)) - 1}`;
                    const prevYear = q === 'Q1' ? parseInt(y) - 1 : parseInt(y);

                    return `${prevQuarter} ${prevYear}`;
                }

                const [fy, year] = date.split(' ');
                const prevYear = parseInt(year) - 1;

                return `${fy} ${prevYear}`;
            }
        }" wire:key="{{ \Str::random(5) }}"
            wire:loading.class="pointer-events-none animate-pulse">

            <div class="grid grid-cols-1 sm:grid-cols-10 gap-2 whitespace-nowrap flex-wrap">
                <div class="sm:col-span-5 xl:col-span-3 bg-white p-2 rounded-t">
                    <livewire:builder.table.select-company :selected="$companies" :wire:key="Str::random(5)" />
                </div>
                <div class="sm:col-span-5 xl:col-span-3 bg-white p-2 rounded-t"
                    :class="!$wire.companies.length ? 'opacity-60 cursor-not-allowed' : ''"
                    :data-tooltip-content="!$wire.companies.length ? 'Please add ticker(s) first' : ''">
                    @include('livewire.builder.table.select-metrics', [
                        'companies' => $companies,
                        'dates' => $dates,
                        'selected' => $metrics,
                    ])
                </div>
                <div class="sm:col-span-8 xl:col-span-3 bg-white p-2 rounded-t">
                    @include('livewire.builder.table.select-summary')
                </div>
                <div class="sm:col-span-2 xl:col-span-1 bg-white px-5 py-2 rounded-t flex items-center justify-center">
                    @include('livewire.builder.table.settings')
                </div>
            </div>
            <div wire:loading.remove class="mt-0.5 overflow-x-auto rounded-b-lg" x-cloak x-show="tableRows.length">
                <table class="overflow-hidden">
                    <tr class="font-bold whitespace-nowrap bg-[#EDEDED]">
                        <td class="py-3 pl-8">Ticker</td>
                        <template x-for="column in columns" :key="column.label">
                            <td class="py-3 pl-6 text-right" draggable="true">
                                <span class="text-center inline-block" x-html="column.label"></span>
                            </td>
                        </template>
                        <td class="py-3 pl-6 pr-8" style="min-width: 270px;">Notes</td>
                    </tr>
                    <template x-for="(row, idx) in tableRows" :key="row.ticker">
                        <tr class="bg-white border-y-2 border-gray-light font-semibold cursor-pointer data-row"
                            draggable="true" :data-key="row.ticker">
                            <td class="py-4 pl-8 whitespace-nowrap cursor-text">
                                <span x-text="row.ticker"></span>
                            </td>
                            <template x-for="column in columns" :key="column.label">
                                <td class="py-3 pl-6 text-right">
                                    <span class="cursor-text" :class="row.columns[column.label] < 0 ? 'text-red' : ''"
                                        x-text="formatTableValue(row.columns[column.label], column.applyUnits)"
                                        :data-tooltip-content="tooltipValue(row.columns[column.label])">
                                    </span>
                                </td>
                            </template>
                            <td class="py-4 pl-6 pr-8">
                                <div x-data="{
                                    openDropdown: false,
                                    content: row.note,
                                    init() {
                                        this.$watch('openDropdown', value => {
                                            if (value) {
                                                this.content = row.note;
                                                this.$el.querySelector('textarea').focus()
                                            }
                                        })
                                    },
                                    saveNote() {
                                        this.openDropdown = false;

                                        const oldNote = row.note;
                                        row.note = this.content;

                                        http(`/table-builder/${$wire.tab.id}/update-note`, {
                                            method: 'POST',
                                            body: {
                                                company: row.ticker,
                                                note: this.content,
                                            }
                                        }).catch(err => {
                                            alert('Something went wrong while saving note. Please try again')
                                            row.note = oldNote
                                        })
                                    },
                                }">
                                    <x-dropdown x-model="openDropdown" placement="bottom-start" :shadow="true">
                                        <x-slot name="trigger">
                                            <template x-if="!row.note">
                                                <p class="bg-[#EDEDED] hover:bg-green-light4 px-2 py-1 rounded-sm font-medium text-xs text-dark-light2 whitespace-nowrap"
                                                    :class="open ? 'hover:bg-green-light4' : ''">
                                                    Add Note
                                                </p>
                                            </template>
                                            <template x-if="row.note">
                                                <p class="flex items-center gap-x-1">
                                                    <span style="max-width: 200px" class="truncate text-ellipsis"
                                                        x-text="row.note"
                                                        :data-tooltip-content="row.note?.length > 25 ? row.note : ''"></span>
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.82843 11.9986H2V9.17016L9.62333 1.54682C9.88373 1.28648 10.3058 1.28648 10.5661 1.54682L12.4518 3.43244C12.7121 3.69279 12.7121 4.1149 12.4518 4.37525L4.82843 11.9986ZM2 13.332H14V14.6653H2V13.332Z"
                                                            fill="#121A0F" />
                                                    </svg>
                                                </p>
                                            </template>
                                        </x-slot>

                                        <div class="w-[20rem] rounded overflow-clip border border-green-muted">
                                            <div class="flex items-center justify-between px-6 py-4 bg-green-light4">
                                                <p class="font-semibold" x-text="'Add note for ' + row.ticker">
                                                </p>
                                                <button @click.prevent="$dispatch('hide-dropdown')">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                                            fill="#C22929" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <form class="px-6 py-4" @submit.prevent="saveNote">
                                                <textarea class="w-full focus:outline-none focus:ring-0 border-0 font-normal resize-none"
                                                    placeholder="Write note here..." rows="10" x-model="content"></textarea>
                                                <button type="submit"
                                                    class="mt-4 py-2 w-full text-sm font-medium bg-green-dark hover:bg-opacity-80 rounded">
                                                    Save Note
                                                </button>
                                            </form>
                                        </div>
                                    </x-dropdown>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template x-for="(row, idx) in summaryRows" :key="row.title + idx">
                        <tr class="border-y-2 border-gray-light font-semibold summary-row"
                            style="background: rgba(82, 198, 255, 0.10)">
                            <td class="py-3 pl-8" x-text="row.title"></td>

                            <template x-for="column in columns" :key="column.label">
                                <td class="py-3 pl-6 text-right">
                                    <span :class="row.columns[column.label] < 0 ? 'text-red' : ''"
                                        x-text="formatTableValue(row.columns[column.label], column.applyUnits)"
                                        :data-tooltip-content="tooltipValue(row.columns[column.label])">
                                    </span>
                                </td>
                            </template>

                            <td></td>
                        </tr>
                    </template>
                </table>
            </div>
            <div wire:loading.remove class="mt-[6rem] flex flex-col items-center" x-cloak x-show="!tableRows.length">
                <svg width="168" height="164" viewBox="0 0 168 164" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_9710_178945)">
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
                        <clipPath id="clip0_9710_178945">
                            <rect width="168" height="164" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <p class="mt-6 font-bold text-xl">No Data</p>
                <p class="mt-2">Create financial tables to analyse data</p>
            </div>

            <div wire:loading class="py-10 w-full">
                <div class="w-full flex justify-center">
                    <div class="simple-loader !text-green-dark"></div>
                </div>
            </div>
        </div>
    @else
        <div class="py-10 grid place-items-center">
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
    @endif
</div>
