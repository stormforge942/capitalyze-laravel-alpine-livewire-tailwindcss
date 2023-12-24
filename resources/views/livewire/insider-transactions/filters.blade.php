<div class="grid grid-cols-12 gap-2 mb-2" x-data="{
    filters: {
        search: '{{ data_get($filters, 'search') }}',
        transaction_codes: @js(data_get($filters, 'transaction_codes', [])),
        relationships: @js(data_get($filters, 'relationships', [])),
        months: {{ data_get($filters, 'months', 0) }},
        {{-- @todo: implement cso filter --}}
        cso: {{ data_get($filters, 'cso', 0) }},
        transaction_value: @js(data_get($filters, 'transaction_value', null)),
    },
    init() {
        this.$watch('filters', (value) => {
            window.Livewire.emit('filterInsiderTransactionsTable', value);

            let url = new URL(window.location.href);
            url.searchParams.set('search', value.search);
            url.searchParams.set('transaction_codes', value.transaction_codes.join(','));
            url.searchParams.set('relationships', value.relationships.join(','));
            url.searchParams.set('months', value.months);
            url.searchParams.set('cso', value.cso);
            url.searchParams.set('transaction_value', value.transaction_value ? `${value.transaction_value.min}-${value.transaction_value.max}` : '');

            window.history.replaceState({}, '', url);
        }, { deep: true });
    },
}">
    <div class="col-span-12 lg:col-span-2 bg-white flex items-center p-4 border border-[#D4DDD7] rounded">
        <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
                fill="#828C85" />
        </svg>

        <input type="search" placeholder="Search"
            class="placeholder:text-gray-medium2 border-none flex-1 focus:outline-none focus:ring-0 h-6 min-w-0"
            x-model.debounce.500ms="filters.search">
    </div>

    <div class="lg:col-span-10 px-4 py-3 bg-white border border-[#D4DDD7] rounded flex flex-wrap whitespace-nowrap items-center gap-2.5 text-sm">
        <div class="inline-flex items-center gap-1">
            <span>Transaction Filing</span>
            <x-select name="transaction-filing" :options="config('capitalyze.transaction_code_map')" placeholder="Transaction Filing" :multiple="true"
                :searchable="true" x-model="filters.transaction_codes"></x-select>
        </div>

        <div class="inline-flex items-center gap-1">
            <span>Insider Title</span>
            <x-select name="insider-title" :options="$insiderTitles" placeholder="Insider Title" :multiple="true"
                :searchable="true" x-model="filters.relationships"></x-select>
        </div>

        <div class="inline-flex items-center gap-1">
            <span>Transaction Value</span>
            <div x-data="{
                showDropdown: false,
                value: null,
                tmpValue: {
                    min: 0,
                    max: 0,
                },
                get valueText() {
                    if (!this.value) {
                        return 'All'
                    }
            
                    return `$${this.value.min}K - $${this.value.max}K`
                },
                init() {
                    $watch('showDropdown', value => {
                        this.tmpValue = {
                            min: this.value?.min || 0,
                            max: this.value?.max || 0,
                        }
                    })
                },
                updateValue() {
                    this.tmpValue.min = Number(this.tmpValue.min);
                    this.tmpValue.max = Number(this.tmpValue.max);
            
                    if (this.tmpValue.min <= 0 && this.tmpValue.max <= 0) {
                        this.value = null;
                        this.showDropdown = false;
                        return;
                    }
            
                    this.tmpValue.min = this.tmpValue.min < 0 ? 0 : this.tmpValue.min;
                    this.tmpValue.max = this.tmpValue.max < 0 ? 0 : this.tmpValue.max;
            
                    this.tmpValue.max = this.tmpValue.max < this.tmpValue.min ? this.tmpValue.min : this.tmpValue.max;
            
                    this.value = this.tmpValue;
                    this.showDropdown = false;
                },
            }" x-modelable="value" x-model="filters.transaction_value" class="inline-block">
                <x-dropdown x-model="showDropdown" placement="bottom-start">
                    <x-slot name="trigger">
                        <div class="border-[0.5px] border-[#93959880] p-2 rounded-full flex items-center gap-x-1"
                            :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'">
                            <span class="text-sm truncate" x-text="valueText">
                            </span>

                            <span :class="showDropdown ? 'rotate-180' : ''" class="transition-transform shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                        fill="#121A0F" />
                                </svg>
                            </span>
                        </div>
                    </x-slot>

                    <form class="w-[20rem]" @submit.prevent="updateValue">
                        <div class="px-6 pt-6">
                            <div class="flex justify-between">
                                <span class="font-medium">Transaction Value (in thousands)</span>

                                <button @click="dropdown.hide()">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                            fill="#686868" />
                                    </svg>
                                </button>
                            </div>

                            <div class="py-4">
                                <div class="flex items-center justify-between">
                                    <input class="flex-1 w-16 rounded-sm border-2 border-gray-medium2" type="number"
                                        min="0" step="1" x-model="tmpValue.min" :max="tmpValue.max">
                                    <span class="px-5">-</span>
                                    <input class="flex-1 w-16 rounded-sm border-2 border-gray-medium2" type="number"
                                        min="0" step="1" x-model="tmpValue.max" :min="tmpValue.min">
                                </div>

                                <button type="button" class="text-sm mt-1 hover:underline text-red"
                                    @click="tmpValue.min = 0; tmpValue.max = 0;"
                                    x-show="(tmpValue.min + tmpValue.max) > 0" x-cloak>Clear</button>
                            </div>
                        </div>

                        <div class="p-6">
                            <button type="submit"
                                class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base">
                                Show Result
                            </button>
                        </div>
                    </form>
                </x-dropdown>
            </div>
        </div>

        <div class="inline-flex items-center gap-1">
            <span>Date</span>
            <div x-data="{
                showDropdown: false,
                value: 0,
                tmpValue: '',
                get valueText() {
                    if (this.value > 0) {
                        return this.value + ' Month' + (this.value > 1 ? 's' : '');
                    }
            
                    return 'All'
                },
                get tmpValueText() {
                    return this.tmpValue + ' Month' + (this.tmpValue > 1 ? 's' : '');
                },
                init() {
                    $watch('showDropdown', value => {
                        this.tmpValue = this.value
                    })
                },
                increase() {
                    this.tmpValue = Number(this.tmpValue) + 1
                },
                decrease() {
                    if (this.tmpValue <= 0) return;
            
                    this.tmpValue = Number(this.tmpValue) - 1
                },
            }" x-modelable="value" x-model="filters.months" class="inline-block">
                <x-dropdown x-model="showDropdown" placement="bottom-start">
                    <x-slot name="trigger">
                        <div class="border-[0.5px] border-[#93959880] p-2 rounded-full flex items-center gap-x-1"
                            :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'">
                            <span class="text-sm truncate" x-text="valueText">
                            </span>

                            <span :class="showDropdown ? 'rotate-180' : ''" class="transition-transform shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                        fill="#121A0F" />
                                </svg>
                            </span>
                        </div>
                    </x-slot>

                    <div class="w-[20rem] sm:w-[26rem]">
                        <div class="flex justify-between gap-2 px-6 pt-6">
                            <span class="font-medium">Months</span>

                            <button @click="dropdown.hide()">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                        fill="#686868" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-4 flex items-center justify-between">
                            <button @click="decrease">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM7 11H17V13H7V11Z"
                                        fill="#121A0F" />
                                </svg>
                            </button>
                            <div class="flex-1 text-center" x-text="tmpValueText"></div>
                            <button @click="increase">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M11 11V7H13V11H17V13H13V17H11V13H7V11H11ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                                        fill="#121A0F" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-6">
                            <button type="button"
                                class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                                @click="value = tmpValue; showDropdown = false;" :disabled="value === tmpValue">
                                Show Result
                            </button>
                        </div>
                    </div>
                </x-dropdown>
            </div>
        </div>

        <div class="inline-flex items-center gap-1">
            <span>% of CSO</span>
            <div x-data="{
                showDropdown: false,
                value: 0,
                tmpValue: '',
                get valueText() {
                    if (this.value > 0) {
                        return this.value + '%';
                    }
            
                    return 'Auto'
                },
                get tmpValueText() {
                    return this.tmpValue + '%';
                },
                init() {
                    $watch('showDropdown', value => {
                        this.tmpValue = this.value
                    })
                },
                increase() {
                    this.tmpValue = Number(this.tmpValue) + 1
                },
                decrease() {
                    if (this.tmpValue <= 0) return;
            
                    this.tmpValue = Number(this.tmpValue) - 1
                },
            }" x-modelable="value" x-model="filters.cso" class="inline-block">
                <x-dropdown x-model="showDropdown" placement="bottom-start">
                    <x-slot name="trigger">
                        <div class="border-[0.5px] border-[#93959880] p-2 rounded-full flex items-center gap-x-1"
                            :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'">
                            <span class="text-sm truncate" x-text="valueText">
                            </span>

                            <span :class="showDropdown ? 'rotate-180' : ''" class="transition-transform shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                        fill="#121A0F" />
                                </svg>
                            </span>
                        </div>
                    </x-slot>

                    <div class="w-[20rem] sm:w-[26rem]">
                        <div class="flex justify-between gap-2 px-6 pt-6">
                            <span class="font-medium">Percentage</span>

                            <button @click="dropdown.hide()">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                        fill="#686868" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-4 flex items-center justify-between">
                            <button @click="decrease">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM7 11H17V13H7V11Z"
                                        fill="#121A0F" />
                                </svg>
                            </button>
                            <div class="flex-1 text-center" x-text="tmpValueText"></div>
                            <button @click="increase">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M11 11V7H13V11H17V13H13V17H11V13H7V11H11ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                                        fill="#121A0F" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-6">
                            <button type="button"
                                class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                                @click="value = tmpValue; showDropdown = false;" :disabled="value === tmpValue">
                                Show Result
                            </button>
                        </div>
                    </div>
                </x-dropdown>
            </div>
        </div>
    </div>
</div>
