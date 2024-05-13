<div x-data="{
    search: '',
    allOptions: [],
    options: @js($options),
    value: $wire.entangle('selected', true),
    tmpValue: [],
    showDropdown: false,
    active: null,
    expand: null,
    selectedMetricType: 'value',
    init() {
        this.allOptions = this.options.reduce((acc, item) => ({ ...acc, ...item.items }), {})

        this.active = this.options[0].title

        this.$watch('showDropdown', value => {
            this.tmpValue = [...this.value]

            this.$nextTick(() => {
                if (value) {
                    window.dispatchEvent(new Event('resize')) // this fixes the dropdown position
                    this.$el.querySelector(`input[type='search']`).focus()
                }
            })
        })

        this.$watch('active', () => {
            this.expand = null
            this.selectedMetricType = 'value'
        })
    },
    get subOptions() {
        if (!this.active) {
            return []
        }

        const item = this.options.find(option => option.title === this.active) || {}

        return item.items || [];
    },
    get hasValueChanged() {
        return [...this.value].sort().map(item => item).join('-') !== [...this.tmpValue].sort().map(item => item).join('-')
    },
    get resultTitle() {
        const metricType = {
            value: 'Value',
            growth: '% Growth YoY',
            cagr: 'CAGR',
        } [this.selectedMetricType]

        return this.allOptions[this.expand].title + ` (${metricType})`
    },
    showResult() {
        this.value = [...this.tmpValue];
        this.showDropdown = false;

        this.dispatchValueChanged()
    },
    dispatchValueChanged() {
        Livewire.emit('metricsChanged', this.value)
    }
}" class="flex items-center justify-between gap-x-5">
    <div wire:ignore>
        <x-dropdown x-model="showDropdown" placement="bottom-start" :fullWidthTrigger="true" :teleport="true">
            <x-slot name="trigger">
                <p class="h-8 px-4 flex items-center gap-x-2 font-medium text-sm bg-[#DCF6EC] rounded" x-cloak
                    x-show="!open">
                    Add Metric
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.33594 7.33398V4.66732H8.66927V7.33398H11.3359V8.66732H8.66927V11.334H7.33594V8.66732H4.66927V7.33398H7.33594ZM8.0026 14.6673C4.3207 14.6673 1.33594 11.6825 1.33594 8.00065C1.33594 4.31875 4.3207 1.33398 8.0026 1.33398C11.6845 1.33398 14.6693 4.31875 14.6693 8.00065C14.6693 11.6825 11.6845 14.6673 8.0026 14.6673ZM8.0026 13.334C10.9481 13.334 13.3359 10.9462 13.3359 8.00065C13.3359 5.05513 10.9481 2.66732 8.0026 2.66732C5.05708 2.66732 2.66927 5.05513 2.66927 8.00065C2.66927 10.9462 5.05708 13.334 8.0026 13.334Z"
                            fill="#121A0F" />
                    </svg>
                </p>

                <template x-if="open">
                    <input type="search" placeholder="Search Company or Ticker"
                        class="h-8 text-sm w-52 border border-[#D4DDD7] focus:ring-0 focus:border-green-dark rounded search-x-button"
                        @click="$event.stopPropagation()" @keyup.space="$event.preventDefault()"
                        x-model.debounce.500ms="search">
                </template>
            </x-slot>

            <div style="max-width: 45rem">
                <div class="flex justify-between gap-2 px-6 pt-6">
                    <span class="font-medium text-base">Metrics</span>

                    <button @click.prevent="dropdown.hide()">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                fill="#C22929" />
                        </svg>
                    </button>
                </div>

                <div class="relative mt-2 px-6">
                    <div
                        class="flex items-center gap-0.5 whitespace-nowrap text-sm font-medium text-center text-gray-medium2 border-[0.5px] outline-green-muted rounded">
                        <template x-for="option in options" :key="option.title">
                            <button type="button" class="px-3 border rounded -m-[0.5px] -mb-[1px]"
                                :class="active === option.title ? 'border-green-dark bg-green-light4 text-dark' :
                                    'border-transparent hover:border-green-muted'"
                                @click="active = option.title" x-text="option.title"></button>
                        </template>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3" style="max-height: 25rem">
                        <div class="overflow-y-scroll" style="max-height: 25rem">
                            <template x-for="(option, value) in subOptions" :key="value">
                                <div x-data="{
                                    get open() {
                                        return expand === value
                                    },
                                }">
                                    <button type="button"
                                        class="w-full p-4 rounded flex items-center gap-5 justify-between"
                                        @click.prevent="expand = open ? null : value; selectedMetricType = 'value'">
                                        <span class="truncate text-ellipsis" x-text="option.title"></span>

                                        <svg class="shrink-0" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                            :class="open ? 'rotate-90' : ''">
                                            <path
                                                d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z"
                                                fill="#121A0F" />
                                        </svg>
                                    </button>

                                    <div class="ml-4 space-y-4 text-sm" x-cloak x-show="open">
                                        <div class="text-blue text-xs+ font-medium">Choose data type</div>
                                        <template
                                            x-for="(label, key) in {value: 'Value', growth: '% Growth YoY', cagr: 'CAGR'}">
                                            <button type="button"
                                                class="w-full block text-left px-4 py-2 rounded border-[0.5px] "
                                                :class="selectedMetricType === key ? 'bg-green-light4 border-green-dark' :
                                                    'hover:bg-green-light4 bg-[#EDEDED] border-green-muted hover:border-green-dark'"
                                                @click="selectedMetricType = key" x-text="label">
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div>
                            <template x-if="expand && selectedMetricType">
                                <div>
                                    <p class="font-medium py-2 px-4" x-text="resultTitle"></p>

                                    <div class="mt-2" x-data="{
                                        open: null
                                    }">
                                        <div>
                                            <button type="button"
                                                class="w-full p-4 rounded flex items-center gap-5 justify-between"
                                                @click="open = open == 'FA' ? null : 'FA'">
                                                <span class="truncate text-ellipsis">Fiscal Annual</span>

                                                <svg class="shrink-0" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg"
                                                    :class="open === 'FA' ? 'rotate-90' : ''">
                                                    <path
                                                        d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z"
                                                        fill="#121A0F" />
                                                </svg>
                                            </button>

                                            <div class="mt-1 mx-4 bg-gray-light rounded p-4" x-cloak x-show="open === 'FA'">
                                                <p class="text-sm font-medium">Choose Period</p>
                                                <div class="mt-4 flex flex-wrap gap-x-2.5 gap-y-4 text-xs font-semibold">
                                                    <template x-for="date in [2000, 2001, 2002, 2003]"
                                                        :key="date">
                                                        <button class="flex items-center gap-x-1 bg-green-muted rounded-full py-1 px-1.5">
                                                            <span x-text="'FY ' + date"></span>
                                                            <svg width="16" height="16" viewBox="0 0 16 16"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M7.33594 7.33398V3.33398H8.66927V7.33398H12.6693V8.66732H8.66927V12.6673H7.33594V8.66732H3.33594V7.33398H7.33594Z"
                                                                    fill="#121A0F" />
                                                            </svg>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-2 p-6 border-t flex items-center gap-x-4">
                    <button type="button"
                        class="w-full px-4 py-3 font-medium bg-[#DCF6EC] hover:bg-green-light2 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                        @click.prevent="tmpValue = [];" :disabled="!tmpValue.length">
                        Reset
                    </button>
                    <button type="button"
                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                        @click.prevent="showResult" :disabled="!hasValueChanged">
                        Show Result
                    </button>
                </div>
            </div>
        </x-dropdown>
    </div>

    <div class="bg-blue rounded-full px-1.5 py-0.5 font-semibold text-xs text-white"
        x-text="value.length + ' Metrics'">
    </div>
</div>
