<?php

$options = App\Services\TableBuilderService::options();

?>

<div x-data="{
    search: '',
    allOptions: [],
    options: @js($options),
    value: @js($selected),
    tmpValue: [],
    showDropdown: false,
    active: null,
    expand: null,
    selectedMetricType: 'value',
    selectedCount: 0,
    init() {
        this.updateSelectedCount()

        this.allOptions = this.options.reduce((acc, item) => ({ ...acc, ...item.items }), {})

        this.active = this.options[0].title

        this.$watch('showDropdown', (show) => {
            this.tmpValue = JSON.parse(JSON.stringify(this.value))

            this.$nextTick(() => {
                if (show) {
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
    get resultTitle() {
        const metricType = {
            value: 'Value',
            growth: '% Growth YoY',
            cagr: 'CAGR',
        } [this.selectedMetricType]

        return this.allOptions[this.expand].title + ` (${metricType})`
    },
    showResult() {
        this.value = this.tmpValue.filter(item => item.dates.length);
        this.showDropdown = false;

        this.updateSelectedCount()
    },
    dates(period) {
        const dates = @js($dates)

        const metric = this.expand.split('||')[0]

        return dates[period][metric] || []
    },
    updateSelectedCount() {
        this.selectedCount = new Set(this.value.map(item => item.metric)).size
    }
}" class="flex items-center justify-between gap-x-5" x-modelable="value" x-model="metrics">
    <div wire:ignore>
        <x-dropdown x-model="showDropdown" placement="bottom-start" :fullWidthTrigger="true" :teleport="true">
            <x-slot name="trigger">
                <p class="h-8 px-4 flex items-center gap-x-2 font-medium text-sm bg-[#DCF6EC] rounded" x-cloak
                    x-show="!open" @if (!count($companies)) @click="$event.stopPropagation()" @endif>
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

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="overflow-y-scroll" style="max-height: 25rem">
                            <template x-for="(option, value) in subOptions" :key="value">
                                <div x-data="{
                                    get open() {
                                        return expand === value
                                    },
                                }">
                                    <button type="button"
                                        class="w-full py-4 px-3 rounded flex items-center gap-5 justify-between"
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
                        <div class="overflow-y-scroll" style="max-height: 25rem">
                            <template x-if="expand && selectedMetricType">
                                <div>
                                    <p class="font-medium py-2 px-3" x-text="resultTitle"></p>

                                    <div class="mt-2 space-y-2" x-data="{
                                        open: null,
                                        selectedDates: [],
                                        get periods() {
                                            if (selectedMetricType === 'cagr') {
                                                return { annual: 'Fiscal Annual' };
                                            }
                                    
                                            return { annual: 'Fiscal Annual', quarter: 'Fiscal Quarterly' };
                                        },
                                        get selectedDates() {
                                            return this.tmpValue
                                                .find(item => item.metric === expand && item.type === selectedMetricType && item.period === this.open)
                                                ?.dates || []
                                        },
                                        toggleDate(date) {
                                            const index = this.tmpValue
                                                .findIndex(item => item.metric === expand && item.type === selectedMetricType && item.period === this.open)
                                    
                                            if (index === -1) {
                                                this.tmpValue.push({
                                                    metric: expand,
                                                    type: selectedMetricType,
                                                    period: this.open,
                                                    dates: [date]
                                                })
                                                return;
                                            }
                                    
                                            const item = this.tmpValue[index]
                                    
                                            if (item.dates.includes(date)) {
                                                item.dates = item.dates.filter(d => d !== date)
                                            } else {
                                                item.dates.push(date)
                                            }
                                        }
                                    }">
                                        <template x-for="(label, key) in periods" :key="key">
                                            <div>
                                                <button type="button"
                                                    class="w-full px-4 py-2 rounded flex items-center gap-5 justify-between"
                                                    @click="open = open == key ? null : key">
                                                    <span class="truncate text-ellipsis" x-text="label"></span>

                                                    <svg class="shrink-0" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        :class="open === key ? 'rotate-90' : ''">
                                                        <path
                                                            d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z"
                                                            fill="#121A0F" />
                                                    </svg>
                                                </button>

                                                <div class="mt-1 mx-4 bg-gray-light rounded p-4" x-cloak
                                                    x-show="open === key">
                                                    <p class="text-sm font-medium">Choose Period</p>
                                                    <template x-if="selectedMetricType !== 'cagr'">
                                                        <div
                                                            class="mt-4 flex flex-wrap gap-x-2.5 gap-y-4 text-xs font-semibold">
                                                            <template x-for="date in dates(key)" :key="date">
                                                                <button
                                                                    class="flex items-center gap-x-1 hover:opacity-80 rounded-full py-1 px-1.5 transition-colors border"
                                                                    :class="{
                                                                        'bg-green-light4 border-green-dark': selectedDates
                                                                            .includes(date),
                                                                        'bg-green-muted  border-transparent': !
                                                                            selectedDates
                                                                            .includes(date),
                                                                    }"
                                                                    @click="toggleDate(date)">
                                                                    <span x-text="date"></span>
                                                                    <template x-if="selectedDates.includes(date)">
                                                                        <svg width="16" height="16"
                                                                            viewBox="0 0 16 16" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M6.66451 10.1146L12.4392 4.33988C12.6345 4.14462 12.9511 4.14462 13.1463 4.33988L13.382 4.57558C13.5773 4.77084 13.5773 5.08743 13.382 5.28269L6.66451 12.0002L2.77543 8.11114C2.58017 7.91587 2.58017 7.59929 2.77544 7.40403L3.01114 7.16833C3.2064 6.97307 3.52298 6.97307 3.71824 7.16833L6.66451 10.1146Z"
                                                                                fill="#121A0F" />
                                                                        </svg>
                                                                    </template>
                                                                    <template x-if="!selectedDates.includes(date)">
                                                                        <svg width="16" height="16"
                                                                            viewBox="0 0 16 16" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M7.33594 7.33398V3.33398H8.66927V7.33398H12.6693V8.66732H8.66927V12.6673H7.33594V8.66732H3.33594V7.33398H7.33594Z"
                                                                                fill="#121A0F" />
                                                                        </svg>
                                                                    </template>
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </template>
                                                    <template x-if="selectedMetricType === 'cagr'">
                                                        <div class="mt-4 text-sm border border-[#D1D3D5] rounded-lg grid grid-cols-2 divide-x divide-[#F3F3F3] [&>*]:px-4 bg-white"
                                                            x-data="{
                                                                from: null,
                                                                to: null,
                                                                get toOptions() {
                                                                    return dates(key).filter(date => date != this.from)
                                                                },
                                                                get fromOptions() {
                                                                    return dates(key).filter(date => date != this.to)
                                                                },
                                                                init() {
                                                                    const obj = this.tmpValue.find(item => item.metric === expand && item.type === selectedMetricType)
                                                            
                                                                    if (obj) {
                                                                        [this.from, this.to] = obj.dates
                                                                    }
                                                            
                                                                    console.log(this.from, this.to)
                                                            
                                                                    this.$watch('to', () => this.onChange())
                                                            
                                                                    this.$watch('from', () => this.onChange())
                                                                },
                                                                onChange() {
                                                                    if (!(this.to && this.from)) {
                                                                        const idx = this.tmpValue.findIndex(item => item.metric === expand && item.type === selectedMetricType)
                                                                        if (idx !== -1) {
                                                                            this.tmpValue.splice(idx, 1)
                                                                        }
                                                                        return;
                                                                    }
                                                            
                                                                    if (this.to < this.from) {
                                                                        [this.to, this.from] = [this.from, this.to]
                                                                    }
                                                            
                                                                    const obj = this.tmpValue.find(item => item.metric === expand && item.type === selectedMetricType)
                                                            
                                                                    if (!obj) {
                                                                        this.tmpValue.push({
                                                                            metric: expand,
                                                                            type: selectedMetricType,
                                                                            dates: [this.from, this.to]
                                                                        })
                                                                    } else {
                                                                        obj.dates = [this.from, this.to]
                                                                    }
                                                                }
                                                            }">
                                                            <label class="py-2">
                                                                <label class="text-[#7C8286] block">From</label>
                                                                <select
                                                                    class="block w-full focus:ring-0 focus:border-none bg-none"
                                                                    x-model="from">
                                                                    <option value="">-</option>
                                                                    <template x-for="date in fromOptions"
                                                                        :key="date">
                                                                        <option :value="date" x-text="date">
                                                                        </option>
                                                                    </template>
                                                                </select>
                                                            </label>
                                                            <div class="py-2">
                                                                <label class="text-[#7C8286] block">To</label>
                                                                <select
                                                                    class="block w-full focus:ring-0 focus:border-none bg-none"
                                                                    x-model="to">
                                                                    <option value="">-</option>
                                                                    <template x-for="date in toOptions"
                                                                        :key="date">
                                                                        <option :value="date" x-text="date">
                                                                        </option>
                                                                    </template>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-2 p-6 border-t flex items-center gap-x-4">
                    <button type="button"
                        class="w-full px-4 py-3 font-medium bg-[#DCF6EC] hover:bg-green-light2 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                        @click.prevent="tmpValue = []" :disabled="!tmpValue.length">
                        Reset
                    </button>
                    <button type="button"
                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                        @click.prevent="showResult">
                        Show Result
                    </button>
                </div>
            </div>
        </x-dropdown>
    </div>

    <div class="bg-blue rounded-full px-1.5 py-0.5 font-semibold text-xs text-white"
        x-text="selectedCount + ' Metrics'">
    </div>
</div>
