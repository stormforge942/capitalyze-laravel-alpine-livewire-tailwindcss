<div class="flex items-center justify-between gap-x-5" x-data="{
    tmpValue: {data: [], exclude: false},
    value: {data: [], exclude: false},
    showDropdown: false,
    options: ['USD'],
    search: '',
    showResult() {
        this.value = {...this.tmpValue}
        this.showDropdown = false
    },
    get hasValueChanged() {
        return ([...this.value.data].sort().join('-') !== [...this.tmpValue.data].sort().join('-')) || (this.tmpValue.exclude !== this.value.exclude)
    },
    get computedOptions() {
        if (!this.search) {
            return this.options
        }

        let options = {};

        for (const [key, value] of Object.entries(this.options)) {
            const value_ = typeof value === 'object' ? value.label + ' ' + value.description : value

            if (value_.toLowerCase().includes(this.search.toLowerCase())) {
                options[key] = value
            }
        }

        return options
    },
    init() {
        this.$watch('showDropdown', value => {
            this.tmpValue = {...this.value}
            this.search = ''
        })

        this.$watch('search', (val) => {
            this.$dispatch('search', val)
        })
    }
}" x-modelable="value" x-model="currencies">
    <div class="flex items-center">
        <x-dropdown x-model="showDropdown" placement="bottom-start">
            <x-slot name="trigger">
                <p class="flex items-center border-[0.5px] border-[#D4DDD7] dropdown-trigger rounded-tl-full rounded-bl-full p-2 text-sm"
                   :class="[
                        value.data.length > 0 ? 'rounded-tr-none rounded-br-none' : 'rounded-tr-full rounded-br-full',
                        showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'
                    ]">
                    Currency
                    <span :class="showDropdown ? 'rotate-180' : ''" class="transition-transform shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                         fill="none">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </span>
                </p>
            </x-slot>

            <div class="w-[20rem] sm:w-[26rem] h-[400px] !overflow-scroll">
                <div class="fixed top-0 left-0 z-50 bg-white">
                    <div class="flex justify-between items-start gap-2 px-6 pt-6">
                        <div>
                            <p class="font-medium text-base">Select Location</p>
                        </div>

                        <button @click="dropdown.hide()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                    fill="#C22929" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-12 gap-4 px-6 mt-4 mb-2">
                        <div class="col-span-12 md:col-span-8">
                            <div class="bg-white rounded px-4 py-3 gap-3 flex items-center border border-[#D4DDD7]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                        d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
                                        fill="#464E49" />
                                </svg>
                                <input type="search" placeholder="Search"
                                       class="border-none flex-1 focus:outline-none focus:ring-0 h-6 min-w-0 search-x-button"
                                       x-model.debounce="search">
                            </div>
                        </div>

                        <div class="col-span-12 flex md:col-span-4">
                            <label class="cursor-pointer rounded flex items-center py-3 gap-x-3">
                                <input type="checkbox" class="custom-checkbox border-dark focus:ring-0" x-model="tmpValue.exclude">
                                <span>
                                    Exclude
                                </span>
                            </label>
                        </div>
                    </div>

                    <template x-if="tmpValue.exclude">
                        <div class="px-6 py-2 ">
                            <div class="flex gap-4 items-center bg-[#DA680B] bg-opacity-10 px-4 py-2 rounded">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0C3.136 0 0 3.136 0 7C0 10.864 3.136 14 7 14C10.864 14 14 10.864 14 7C14 3.136 10.864 0 7 0ZM6.9998 3.5C6.61321 3.5 6.2998 3.8134 6.2998 4.2C6.2998 4.5866 6.61321 4.9 6.9998 4.9C7.3864 4.9 7.6998 4.5866 7.6998 4.2C7.6998 3.8134 7.3864 3.5 6.9998 3.5ZM7.6998 9.8C7.6998 10.185 7.3848 10.5 6.9998 10.5C6.6148 10.5 6.2998 10.185 6.2998 9.8V7C6.2998 6.615 6.6148 6.3 6.9998 6.3C7.3848 6.3 7.6998 6.615 7.6998 7V9.8ZM1.40039 7C1.40039 10.087 3.91339 12.6 7.00039 12.6C10.0874 12.6 12.6004 10.087 12.6004 7C12.6004 3.913 10.0874 1.4 7.00039 1.4C3.91339 1.4 1.40039 3.913 1.40039 7Z" fill="#DA680B"/>
                                </svg>
                                <p class="text-sm text-[#DA680B]">
                                    Any selection you make will be excluded in the result
                                </p>
                            </div>
                        </div>
                    </template>
                </div>

                <div :class="tmpValue.exclude ? 'mt-[170px]' : 'my-[120px]'" class="p-4 py-2">
                    <template x-for="(value, index) in computedOptions" :key="index">
                        <label class="p-4 flex items-center gap-x-4 hover:bg-green-light cursor-pointer rounded">
                            <input type="checkbox" name="company" class="custom-checkbox border-dark focus:ring-0"
                                   :value="value" x-model="tmpValue.data">
                            <span x-text="value"></span>
                        </label>
                    </template>
                </div>

                <div class="p-6 border-t flex gap-4 fixed bottom-0 bg-white w-full">
                    <button type="button"
                            class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D4DDD7] disabled:text-gray-medium2 text-base"
                            @click="tmpValue.data = [];" :disabled="!hasValueChanged">
                        Reset
                    </button>
                    <button type="button"
                            class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D4DDD7] disabled:text-gray-medium2 text-base"
                            @click="showResult" :disabled="!hasValueChanged">
                        Done
                    </button>
                </div>
            </div>
        </x-dropdown>

        <div class="flex items-center gap-1 border-[0.5px] border-[#D4DDD7] rounded-tr-full rounded-br-full" x-show="true">
            <template x-for="(item, index) in value.data" :key="index">
                <div class="flex items-center bg-[#E2E2E2] p-2" :class="[value.data.length - 1 === index ? 'rounded-tr-full rounded-br-full' : '']">
                    <p class="text-sm truncate mr-1" x-text="item"></p>
                    <button type="button" @click="value.data=value.data.filter(e => e !== item)">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.00045 7.05767L11.0882 3.96994C11.2053 3.85279 11.3953 3.85279 11.5124 3.96995L12.031 4.48849C12.1481 4.60564 12.1481 4.79559 12.031 4.91275L8.94325 8.00047L12.031 11.0881C12.1481 11.2053 12.1481 11.3952 12.031 11.5124L11.5124 12.0309C11.3953 12.1481 11.2053 12.1481 11.0882 12.0309L8.00045 8.94327L4.91276 12.0309C4.7956 12.1481 4.60565 12.1481 4.48849 12.0309L3.96995 11.5124C3.85279 11.3952 3.85279 11.2053 3.96995 11.0881L7.05765 8.00047L3.96994 4.91275C3.85279 4.79559 3.85279 4.60564 3.96995 4.48849L4.48849 3.96994C4.60565 3.85279 4.7956 3.85279 4.91276 3.96995L8.00045 7.05767Z" fill="#C22929"/>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>
