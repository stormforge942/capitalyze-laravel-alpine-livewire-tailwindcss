<div>
    <div>
        <h1 class="text-xl font-bold">Earnings Calendar</h1>
        <p class="mt-2 text-dark-light2">Learn when companies announce their quarterly and annual earnings.</p>
    </div>

    <div class="mt-6">
        <x-primary-tabs :tabs="$tabs" :active="$activeTab" min-width="160px" :x-init="'badges = '.$badges">
            @foreach ($tabs as $key => $tab)
                <div x-data="{
                    data: @js($data[$key]),
                    exchange: '',
                    search: '',
                    origin: '',
                    sort: {
                        column: '',
                        direction: 'asc',
                    },
                    loading: false,
                    get rows() {
                        const data = JSON.parse(JSON.stringify(this.data));
                
                        const search = this.search.toLowerCase();
                
                        let rows = this.sort.column ? data.sort((a, b) => {
                            if (this.sort.direction === 'asc') {
                                return a[this.sort.column] > b[this.sort.column] ? 1 : -1;
                            } else {
                                return a[this.sort.column] < b[this.sort.column] ? 1 : -1;
                            }
                        }) : data;
                
                        rows = rows.filter(row => {
                            const c1 = !this.exchange ? true : row.exchange === this.exchange;
                
                            const c2 = (
                                row.company_name.toLowerCase().includes(search) ||
                                row.symbol.toLowerCase().includes(search)
                            )
                
                            const c3 = !this.origin ? true : row.origin === this.origin;
                
                            return c1 && c2 && c3;
                        });
                
                        return rows;
                    },
                    init() {
                        @if($key === 'custom')
                        this.loadCustomData();
                
                        this.$watch('customDateRange', () => {
                            window.updateQueryParam('customDateRange', !this.customDateRange[0] ? `` : `${this.customDateRange[0] || ''},${this.customDateRange[1] || ''}`)
                
                            this.loadCustomData();
                        })
                        @endif
                    },
                    sortBy(column) {
                        if (this.sort.column === column) {
                            if (this.sort.direction === 'desc') {
                                this.sort.column = '';
                                this.sort.direction = 'asc';
                                return;
                            }
                
                            this.sort.direction = this.sort.direction === 'asc' ? 'desc' : 'asc';
                        } else {
                            this.sort.column = column;
                            this.sort.direction = 'asc';
                        }
                    },
                    columns() {
                        return [{
                                name: 'Ticker',
                                key: 'symbol',
                                sortable: true,
                            },
                            {
                                name: 'Company',
                                key: 'company_name',
                                sortable: true,
                            },
                            {
                                name: 'Origin',
                                key: 'origin',
                                sortable: true,
                            },
                            {
                                name: 'Exchange',
                                key: 'exchange',
                                sortable: false,
                            },
                            {
                                name: 'Time',
                                key: 'time',
                                sortable: true,
                            },
                            {
                                name: 'Reported Time',
                                key: 'pub_time',
                                sortable: true,
                            },
                            {
                                name: 'URL',
                                key: 'url',
                                sortable: false,
                            },
                        ]
                    },
                    @if($key === 'custom')
                    customDateRange: @js($customDateRange),
                    loadCustomData() {
                        this.data = [];
                        this.badges.custom = null;
                
                        const [from, to] = this.customDateRange;
                
                        if (!from || !to) {
                            return;
                        }
                
                        this.loading = true;
                
                        $wire.getData(from, to)
                            .then(data => {
                                this.data = data;
                                this.badges.custom = data.length;
                            })
                            .finally(() => {
                                this.loading = false;
                            });
                    }
                    @endif
                }" x-show="activeTab.key === '{{ $key }}'" x-cloak>
                    @if ($key === 'custom')
                        <div wire:ignore>
                            <x-range-calendar x-model="customDateRange" placement="bottom-start"></x-range-calendar>
                        </div>
                    @endif

                    <div class="mt-4 grid grid-cols-12 gap-2 mb-2">
                        <div class="col-span-12 sm:col-span-4">
                            <x-search-filter x-model.debounce="search"></x-search-filter>
                        </div>

                        <div
                            class="col-span-12 sm:col-span-8 px-4 py-3 bg-white flex flex-wrap items-center gap-4 border border-[#D4DDD7] rounded-lg">
                            <x-select name="exchange" :options="$exchanges" placeholder="Exchange"
                                x-model="exchange"></x-select>

                            <x-select name="origin" :options="['' => 'All', '8-K' => '8-K', 'Press Release' => 'Press Release']" placeholder="Origin" x-model="origin"></x-select>
                        </div>
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        <table class="table power-grid-table w-full bg-white rounded-md overflow-clip">
                            <thead class="font-sm font-semibold capitalize bg-[#EDEDED] rounded-t-md">
                                <tr>
                                    <template x-for="column in columns()" :key="column.key">
                                        <th class="pl-6 py-2 text-dark whitespace-nowrap"
                                            :style="`width: max-content;${column.sortable ? 'cursor:pointer;' : ''}`">
                                            <div class="flex items-center gap-1" @click.prevent="sortBy(column.key)">
                                                <span x-text="column.name"></span>

                                                <template x-if="column.sortable && sort.column !== column.key">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z"
                                                                fill="#464E49">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </template>

                                                <template x-if="column.sortable && sort.column === column.key">
                                                    <span x-html="sort.direction === 'asc' ? '&#8595;' : '&#8593;'"></span>
                                                </template>
                                            </div>
                                        </th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody class="divide-y-2">
                                <template x-if="rows.length">
                                    <template x-for="(row, idx) in rows" :key="idx">
                                        <tr>
                                            <td class="pl-6 py-4 whitespace-nowrap">
                                                <a :href="`/company/${row.symbol}`" class="text-blue hover:underline"
                                                    x-text="row.symbol"></a>
                                            </td>
                                            <td class="pl-6 py-4 whitespace-nowrap" x-text="row.company_name"></td>
                                            <td class="pl-6 py-4 whitespace-nowrap" x-text="row.origin"></td>
                                            <td class="pl-6 py-4 whitespace-nowrap" x-text="row.exchange"></td>
                                            <td class="pl-6 py-4 whitespace-nowrap text-right" x-text="row.time">
                                            </td>
                                            <td class="pl-6 py-4 whitespace-nowrap text-right" x-text="row.pub_time">
                                            </td>
                                            <td class="pl-6 py-4 whitespace-nowrap pr-6">
                                                <a :href="row.url" target="_blank" class="underline">Link</a>
                                            </td>
                                        </tr>
                                    </template>
                                </template>

                                <template x-if="!rows.length">
                                    <tr>
                                        <td class="text-center py-4 text-dark-light" colspan="7">
                                            <template x-if="loading">
                                                <div class="grid py-10 place-items-center">
                                                    <span class="mx-auto simple-loader !text-green-dark"></span>
                                                </div>
                                            </template>
                                            <template x-if="!loading">
                                                <span>No records found</span>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </x-primary-tabs>
    </div>
</div>
