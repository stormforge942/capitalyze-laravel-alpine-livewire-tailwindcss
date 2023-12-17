<div>
    <div>
        <h1 class="text-xl font-bold">Earnings Calendar</h1>
        <p class="mt-2 text-dark-light2">Learn when companies announce their quarterly and annual earnings.</p>
    </div>

    <div class="mt-6">
        <x-primary-tabs :tabs="$tabs" :active="$activeTab" min-width="160px" :x-init="'badges = '.$badges">
            <div x-data="{
                data: @js($data),
                exchange: '',
                search: '',
                sort: {
                    column: '',
                    direction: 'asc',
                },
                customDateRange: @js($customDateRange),
                loading: false,
                get rows() {
                    const data = JSON.parse(JSON.stringify(this.data[this.activeTab.key]));
            
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
            
                        return c1 && c2;
                    });
            
                    return rows;
                },
                init() {
                    this.loadCustomData();
            
                    this.$watch('customDateRange', () => {
                        window.updateQueryParam('customDateRange', !this.customDateRange[0] ? `` : `${this.customDateRange[0] || ''},${this.customDateRange[1] || ''}`)
            
                        this.loadCustomData();
                    })
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
                loadCustomData() {
                    this.data.custom = [];
                    this.badges.custom = null;
            
                    const [from, to] = this.customDateRange;
            
                    if (!from || !to) {
                        return;
                    }
            
                    this.loading = true;
            
                    $wire.getData(from, to)
                        .then(data => {
                            this.data.custom = data;
                            this.badges.custom = data.length;
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                }
            }" @tab-changed.window="search = ''; exchange = '';">
                <div x-show="activeTab.key === 'custom'">
                    <x-range-calendar x-model="customDateRange" placement="bottom-start"></x-range-calendar>
                </div>

                <div class="mt-4 grid grid-cols-12 gap-2 mb-2">
                    <div
                        class="col-span-12 lg:col-span-4 bg-white flex items-center p-4 gap-x-4 border border-[#D4DDD7] rounded">
                        <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
                                fill="#828C85" />
                        </svg>

                        <input type="search" placeholder="Search"
                            class="placeholder:text-gray-medium2 border-none flex-1 focus:outline-none focus:ring-0 h-6 min-w-0"
                            x-model.debounce="search">
                    </div>

                    <div class="hidden lg:col-span-8 px-4 py-3 bg-white lg:block border border-[#D4DDD7] rounded">
                        <div class="items-center gap-2 text-sm hidden lg:inline-flex" wire:ignore>
                            <span>Exchange</span>
                            <x-select name="exchange" :options="$exchanges" placeholder="Exchange"
                                x-model="exchange"></x-select>
                        </div>
                    </div>
                </div>

                <div class="mt-6 overflow-x-auto">
                    <table class="table power-grid-table w-full bg-white rounded-md overflow-clip">
                        <thead class="font-sm font-semibold capitalize bg-[#EDEDED] rounded-t-md">
                            <tr>
                                <th class="pl-6 py-2 text-dark whitespace-nowrap"
                                    style="width: max-content; cursor:pointer;">
                                    <div class="flex items-center gap-1" @click.prevent="sortBy('symbol')">
                                        <span>Ticker</span>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16" fill="none">
                                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49"></path>
                                            </svg>

                                        </span>
                                    </div>
                                </th>
                                <th class="pl-6 py-2 text-dark whitespace-nowrap"
                                    style="width: max-content; cursor:pointer;">
                                    <div class="flex items-center gap-1" @click.prevent="sortBy('company_name')">
                                        <span>Company</span>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16" fill="none">
                                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                                <th class="pl-6 py-2 text-dark whitespace-nowrap"
                                    style="width: max-content; cursor:pointer;">
                                    <div class="flex items-center gap-1" @click.prevent="sortBy('origin')">
                                        <span>Origin</span>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16" fill="none">
                                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                                <th class="pl-6 py-2 text-dark whitespace-nowrap" style="width: max-content;">
                                    <div class="flex items-center gap-1">
                                        <span>Exchange</span>
                                    </div>
                                </th>
                                <th class="pl-6 py-2 text-dark whitespace-nowrap"
                                    style="width: max-content; cursor:pointer;">
                                    <div class="flex items-center justify-end gap-1" @click.prevent="sortBy('time')">
                                        <span>Time</span>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16" fill="none">
                                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                                <th class="pl-6 py-2 text-dark whitespace-nowrap"
                                    style="width: max-content; cursor:pointer;">
                                    <div class="flex items-center justify-end gap-1"
                                        @click.prevent="sortBy('pub_time')">
                                        <span>Reported Time</span>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16" fill="none">
                                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                                <th class="pl-6 py-2 text-dark whitespace-nowrap" style="width: max-content;">
                                    <div class="flex items-center gap-1">
                                        <span>URL</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2">
                            <template x-if="rows.length">
                                <template x-for="(row, idx) in rows" :key="idx">
                                    <tr>
                                        <td class="pl-6 py-4 whitespace-nowrap" x-text="row.symbol"></td>
                                        <td class="pl-6 py-4 whitespace-nowrap" x-text="row.company_name"></td>
                                        <td class="pl-6 py-4 whitespace-nowrap" x-text="row.origin"></td>
                                        <td class="pl-6 py-4 whitespace-nowrap" x-text="row.exchange"></td>
                                        <td class="pl-6 py-4 whitespace-nowrap text-right" x-text="row.time"></td>
                                        <td class="pl-6 py-4 whitespace-nowrap text-right" x-text="row.pub_time"></td>
                                        <td class="pl-6 py-4 whitespace-nowrap pr-6">
                                            <a :href="row.url" target="_blank" class="underline">Link</a>
                                        </td>
                                    </tr>
                                </template>
                            </template>

                            <template x-if="!rows.length">
                                <tr>
                                    <td class="text-center py-4 text-dark-light" colspan="7">
                                        <template x-if="loading && activeTab.key === 'custom'">
                                            <div class="grid py-10 place-items-center">
                                                <span class="mx-auto simple-loader !text-green-dark"></span>
                                            </div>
                                        </template>
                                        <template x-if="!loading || activeTab.key !== 'custom'">
                                            <span>No records found</span>
                                        </template>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </x-primary-tabs>
    </div>
</div>
