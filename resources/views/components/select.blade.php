<div x-data="{
    showDropdown: false,
    selectAll: false,
    name: '{{ $name }}',
    value: @if ($multiple) [] @else '``' @endif,
    tmpValue: @if ($multiple) [] @else '``' @endif,
    options: @js($options),
    search: '',
    placeholder: '{{ $placeholder }}',
    multiple: {{ $multiple ? 'true' : 'false' }},
    disabled: @js($disabled),
    pillTextStyle: 'text-{{ $size }} text-[{{ $color }}]',
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
    get pillText() {
        if (this.multiple || this.value === '') {
            return this.placeholder
        }

        return this.options[this.value] || this.placeholder
    },
    get filtersChanged() {
        const filters = Array.from(this.value || []);
        const tmpFilters = Array.from(this.tmpValue || []);

        return filters.length === tmpFilters.length && filters.sort().join('') === tmpFilters.sort().join('');
    },
    init() {
        this.$nextTick(() => {
            @if(!$multiple)
            if (this.value !== '' && !Object.keys(this.options).includes(String(this.value))) {
                this.value = ''
            }
            @else
            const values = Object.keys(this.options)
            const tmp = this.value.filter(value => values.includes(String(value)))

            if (tmp.length !== this.value.length) {
                this.value = tmp
            }
            @endif
        })

        this.$watch('showDropdown', value => {
            this.tmpValue = this.value
            this.search = ''
        })

        this.$watch('search', (val) => {
            this.$dipatch('search', val)
        })

        this.$watch('selectAll', value => {
            this.tmpValue = value ? Object.keys(this.options) : []
        })
    },
}" x-modelable="value" {{ $attributes->merge(['class' => 'inline-block']) }}>
    <x-dropdown x-model="showDropdown" placement="bottom-start" :disabled="$disabled">
        <x-slot name="trigger">
            <div class="border border-[{{ $color }}] p-2 rounded-full flex items-center gap-x-1"
                :class="disabled ? 'bg-[#E2E2E2]' : ''"
                :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'" style="max-width: 15rem">
                <span class="truncate" x-bind:class="pillTextStyle" x-text="pillText">
                </span>

                @if ($multiple)
                    <span class="inline-block rounded-full text-white bg-blue text-xs"
                        style="min-height: 1rem; min-width: 1rem;" x-text="value.length" x-show="value.length > 0"
                        x-cloak></span>
                @endif
                <span :class="showDropdown ? 'rotate-180' : ''" class="transition-transform shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </span>
            </div>
        </x-slot>

        <form class="w-[20rem] sm:w-[26rem]">
            <div class="flex justify-between gap-2 px-6 pt-6">
                <span class="font-medium text-base" x-text="placeholder"></span>

                <button type="button" @click="dropdown.hide()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>

            @if (($searchable && $multiple) || ($searchable && !$multiple && count($options) > 10))
                <div class="grid grid-cols-12 gap-4 px-6 mt-4 mb-2">
                    <div class="col-span-12" :class="{ 'md:col-span-8': multiple }">
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

                    <template x-if="multiple">
                        <div class="col-span-12 flex md:col-span-4">
                            <label class="cursor-pointer rounded flex items-center py-3 gap-x-3">
                                <input type="checkbox" class="custom-checkbox border-dark focus:ring-0" x-model="selectAll">
                                <span>
                                    Select All
                                </span>
                            </label>
                        </div>
                    </template>
                </div>
            @endif

            <div class="max-h-[19rem] overflow-y-auto dropdown-scroll mr-1">
                <div class="space-y-2 px-6">
                    <template x-for="(value, key) in computedOptions" :key="'a' + key">
                        <label class="cursor-pointer rounded flex items-center p-4 hover:bg-green-light gap-x-4">
                            <template x-if="multiple">
                                <input type="checkbox" :name="name" :value="key"
                                    class="custom-checkbox border-dark focus:ring-0" x-model="tmpValue">
                            </template>

                            <template x-if="!multiple">
                                <input type="radio" :name="name" :value="key"
                                    class="custom-radio border-dark focus:ring-0" x-model="tmpValue">
                            </template>

                            <template x-if="typeof value === 'object'">
                                <div>
                                    <p x-text="value.label"></p>
                                    <p class="text-sm text-gray-medium2" x-text="value.description"></p>
                                </div>
                            </template>

                            <template x-if="typeof value === 'string'">
                                <span x-text="value"></span>
                            </template>
                        </label>
                    </template>

                    <template x-if="!Object.keys(computedOptions).length">
                        <p class="text-sm text-gray-medium2 text-center">
                            No options found.
                        </p>
                    </template>
                </div>
            </div>

            <div class="p-6">
                <button type="button"
                    class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D4DDD7] disabled:text-gray-medium2 text-base"
                    @click="value = tmpValue; showDropdown = false; $dispatch('selected', { selected: tmpValue });" :disabled="filtersChanged">
                    Show Result
                </button>
            </div>
        </form>
    </x-dropdown>
</div>
