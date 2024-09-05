<div x-data="{
    id: @js($criteriaId),
    search: '',
    options: [],
    _options: [],
    value: @js($value),
    selectedCriteria: null,
    dates_: @js($dates),
    tmpValue: [],
    showDropdown: false,
    active: null,
    showSelectedMetrics: true,
    expand: null,
    selectedMetricType: 'value',
    selectedCount: 0,
    init() {
        this.makeOptions()

        this.onSearchChange();

        this.updateSelectedCount()

        this.active = this.options[0].title

        this.$watch('showDropdown', (show) => {
            const metric = this.selectedCriteria.find(item => item.id === this.id)

            this.tmpValue = JSON.parse(JSON.stringify(this.value))

            if (show && metric.value.length > 0) {
                this.tmpValue = [...metric.value]
            }

            this.active = this.options[0].title
            this.expand = null
            this.selectedMetricType = 'value'

            this.$nextTick(() => {
                if (show) {
                    window.dispatchEvent(new Event('resize')) // this fixes the dropdown position
                    this.$el.querySelector(`input[type='search']`)?.focus()
                }
            })
        })

        this.$watch('search', () => {
            this.onSearchChange()
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

        return this.options[0].items[this.expand].title + ` (${metricType})`
    },

    get currentSelectedCount() {
        return new Set(this.tmpValue.map(item => item.metric + item.type)).size
    },
    get isCagrMetricType() {
        const metric = this.selectedCriteria.find(item => item.id === this.id)

        return metric.value[0].type === 'cagr'
    },
    makeOptions() {
        const options = @js($options);

        const all = {
            title: 'All Metrics',
            items: options.reduce((acc, item) => ({ ...acc, ...item.items }), {})
        }

        this._options = [all, ...options]
    },
    onSearchChange() {
        const search = this.search.toLowerCase().trim()

        if (!search.length) {
            this.options = this._options
            return
        }

        const options = []

        this._options.forEach(option => {
            const items = {};

            Object.entries(option.items).filter(([key, item]) => {
                if (item.title.toLowerCase().includes(search)) {
                    items[key] = item
                }
            })

            options.push({
                ...option,
                items
            })
        })

        this.options = options
    },
    showResult() {
        this.tmpValue = this.tmpValue.filter(item => item.dates.length);

        if (this.tmpValue.length > 1) {
            const extraCriteria = this.tmpValue.slice(1);

            $wire.addNewFinancialCriteria(extraCriteria);
        }

        this.value = [this.tmpValue[0]];

        this.selectedCriteria = this.selectedCriteria.map(item => {
            if (item.id === this.id) {
                item.value = [...this.value]
            }

            return item
        })

        this.showDropdown = false;

        this.updateSelectedCount()
    },
    dates(period) {
        if (!this.expand) {
            return []
        }

        const metric = this.expand.split('||')[0]

        return this.dates_[period][metric] || []
    },
    updateSelectedCount() {
        this.selectedCount = new Set(this.value?.map(item => item.metric)).size
    },
    selectedMetricsData() {
        let value = {}

        this.tmpValue.forEach(item => {
            let key = item.metric + '||' + item.type

            if (!value[key]) {
                const title = this.options[0].items[item.metric].title + ' (' + { value: 'Value', growth: '% Growth YoY', cagr: 'CAGR' } [item.type] + ')'

                value[key] = {
                    title,
                    key,
                    type: item.type,
                    values: {},
                }
            }

            value[key].values[item.period] = item.dates
        })

        return Object.values(value)
    },
    getLabel(metric) {
        return String(metric).split('||')[1]
    }
}" class="flex flex-col gap-4" x-modelable="selectedCriteria" x-model="selectedFinancialCriteria">
    <div class="border rounded-lg flex py-2 justify-between">
        <div class="flex children-border-right gap-4">
            <div class="px-4">
                <div class="flex items-center justify-between gap-x-5">
                    <div class="flex items-center gap-x-2">
                        <div wire:ignore>
                            <x-dropdown x-model="showDropdown" placement="bottom-start" :fullWidthTrigger="true"
                                        :teleport="true">
                                <x-slot name="trigger">
                                    <div
                                        class="border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1"
                                        :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'"
                                        style="max-width: 15rem">
                                        <span class="text-sm truncate"
                                              x-text="value && value.length > 0 ? getLabel(value[0].metric) : 'Choose Data'">
                                        </span>
                                        </span>
                                        <span :class="showDropdown ? 'rotate-180' : ''"
                                              class="transition-transform shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                                 fill="none">
                                                <path
                                                    d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                                    fill="#121A0F" />
                                            </svg>
                                        </span>
                                    </div>
                                </x-slot>

                                <div style="width: 45rem">
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
                                                        :class="active === option.title ?
                                                         'border-green-dark bg-green-light4 text-dark'
                                                         : 'border-transparent hover:border-green-muted'"
                                                        @click="active = option.title" x-text="option.title"></button>
                                            </template>
                                        </div>

                                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div class="overflow-y-scroll" style="max-height: 25rem">
                                                <div>
                                                    <button type="button"
                                                            class="w-full p-3 rounded flex items-center gap-5 justify-between  font-semibold transition-colors"
                                                            :class="{
                                                                    'bg-green-light': showSelectedMetrics,
                                                                    'bg-[#EDEDED] hover:bg-gray-medium': !showSelectedMetrics
                                                                }"
                                                            @click.prevent="showSelectedMetrics = true;">
                                                        <span class="truncate text-ellipsis">Selected Metrics</span>
                                                        <span
                                                            class="h-5 w-5 grid place-content-center bg-dark text-white rounded-full text-xs"
                                                            x-text="currentSelectedCount"></span>
                                                    </button>
                                                </div>

                                                <template x-for="(option, index) in subOptions" :key="index">
                                                    <div x-data="{
                                                          get open() {
                                                              return expand === index
                                                          }
                                                    }">
                                                        <button type="button"
                                                                class="w-full py-4 px-3 rounded flex items-center gap-5 justify-between"
                                                                @click.prevent="expand = open ? null : index; selectedMetricType = 'value'; showSelectedMetrics = false;">
                                                            <span class="truncate text-ellipsis"
                                                                  x-text="option.title"></span>

                                                            <svg class="shrink-0 transition-transform" width="24"
                                                                 height="24"
                                                                 viewBox="0 0 24 24" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 :class="open ? 'rotate-90' : ''">
                                                                <path
                                                                    d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z"
                                                                    fill="#121A0F" />
                                                            </svg>
                                                        </button>

                                                        <div class="ml-4 space-y-4 text-sm" x-cloak x-show="open">
                                                            <div class="text-blue text-xs+ font-medium">Choose data
                                                                type
                                                            </div>
                                                            <template
                                                                x-for="(label, key) in {value: 'Value', growth: '% Growth YoY', cagr: 'CAGR'}">
                                                                <button type="button"
                                                                        class="w-full block text-left px-4 py-2 rounded border-[0.5px] "
                                                                        :class="selectedMetricType === key ? 'bg-green-light4 border-green-dark': 'hover:bg-green-light4 bg-[#EDEDED] border-green-muted hover:border-green-dark'"
                                                                        @click="selectedMetricType = key"
                                                                        x-text="label">
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="overflow-y-scroll" style="max-height: 25rem">
                                                <template x-if="showDropdown && showSelectedMetrics">
                                                    <div class="flex flex-col gap-y-6 px-3 h-full" x-data="{
                                                            data: [],
                                                            init() {
                                                                this.$nextTick(() => {
                                                                    this.data = this.selectedMetricsData()
                                                                })
                                                            }
                                                        }">
                                                        <template x-for="item in data" :key="item.key">
                                                            <div>
                                                                <p class="font-medium py-2" x-text="item.title"></p>

                                                                <div class="space-y-2">
                                                                    <template x-for="(values, period) in item.values">
                                                                        <div type="button" class="py-2"
                                                                             x-data="{ open: false }">
                                                                            <button
                                                                                class="w-full flex items-center gap-x-4 justify-between"
                                                                                @click="open = !open">
                                                                            <span x-text="{ annual: 'Fiscal Annual', quarter: 'Fiscal Quarterly' }[period]"></span>
                                                                                <div class="inline-flex items-center gap-x-4">
                                                                                    <span class="bg-green-light rounded-full text-xs font-semibold px-1.5 py-0.5"
                                                                                          x-text="`${values.length} SELECTION${values.length > 1 ? 'S' : ''}`"
                                                                                          x-cloak x-show="item.type !== 'cagr'">

                                                                                    </span>
                                                                                    <svg width="24" height="24"
                                                                                         viewBox="0 0 24 24" fill="none"
                                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                                         class="transition-transform shrink-0"
                                                                                         :class="open ? 'rotate-90' : ''">
                                                                                        <path
                                                                                            d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z"
                                                                                            fill="#121A0F" />
                                                                                    </svg>
                                                                                </div>
                                                                            </button>
                                                                            <template x-if="open">
                                                                                <div class="mt-4 bg-gray-light rounded p-4">
                                                                                    <span class="text-sm font-medium">Selected Period</span>
                                                                                    <template
                                                                                        x-if="item.type === 'cagr'">
                                                                                        <div
                                                                                            class="mt-4 text-sm border border-[#D1D3D5] rounded-lg grid grid-cols-2 divide-x divide-[#F3F3F3] [&>*]:px-4 bg-white">
                                                                                            <label class="py-2">
                                                                                                <label
                                                                                                    class="text-[#7C8286] block">From</label>
                                                                                                <span
                                                                                                    x-text="values[0]"></span>
                                                                                            </label>
                                                                                            <div class="py-2">
                                                                                                <label
                                                                                                    class="text-[#7C8286] block">To</label>
                                                                                                <span
                                                                                                    x-text="values[1]"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </template>

                                                                                    <template
                                                                                        x-if="item.type != 'cagr'">
                                                                                        <div
                                                                                            class="mt-4 flex items-center whitespace-nowrap flex-wrap gap-y-4 gap-x-2.5 text-xs font-semibold">
                                                                                            <template
                                                                                                x-for="date in values">
                                                                                                <div
                                                                                                    class="flex items-center px-1.5 py-1 gap-1 border rounded-full border-green-dark bg-green-light">
                                                                                                    <span
                                                                                                        x-text="date"></span>
                                                                                                    <svg width="16"
                                                                                                         height="16"
                                                                                                         viewBox="0 0 16 16"
                                                                                                         fill="none"
                                                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                                                        <path
                                                                                                            d="M6.66451 10.1146L12.4392 4.33988C12.6345 4.14462 12.9511 4.14462 13.1463 4.33988L13.382 4.57558C13.5773 4.77084 13.5773 5.08743 13.382 5.28269L6.66451 12.0002L2.77543 8.11114C2.58017 7.91587 2.58017 7.59929 2.77544 7.40403L3.01114 7.16833C3.2064 6.97307 3.52298 6.97307 3.71824 7.16833L6.66451 10.1146Z"
                                                                                                            fill="#121A0F" />
                                                                                                    </svg>
                                                                                                </div>
                                                                                            </template>
                                                                                        </div>
                                                                                    </template>
                                                                                </div>
                                                                            </template>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </div>
                                                        </template>

                                                        <template x-if="!data.length">
                                                            <div class="text-center m-auto">
                                                                <svg class="mx-auto" width="135" height="87"
                                                                     viewBox="0 0 135 87" fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <g clip-path="url(#clip0_9710_180322)">
                                                                        <path
                                                                            d="M130.44 0H4.44142C3.26391 0.00141686 2.13504 0.472303 1.30242 1.30937C0.469794 2.14643 0.00140934 3.28132 0 4.46511V18.096C0.00140934 19.2798 0.469794 20.4147 1.30242 21.2517C2.13504 22.0888 3.26391 22.5597 4.44142 22.5611H130.44C131.617 22.5597 132.746 22.0888 133.579 21.2517C134.411 20.4147 134.88 19.2798 134.881 18.096V4.46511C134.88 3.28132 134.411 2.14643 133.579 1.30937C132.746 0.472303 131.617 0.00141686 130.44 0ZM134.414 18.096C134.412 19.1551 133.993 20.1703 133.248 20.9192C132.503 21.6681 131.493 22.0895 130.44 22.091H4.44142C3.38796 22.0895 2.3781 21.6681 1.6332 20.9192C0.888291 20.1703 0.469123 19.1551 0.467573 18.096V4.46511C0.469123 3.40603 0.888291 2.39078 1.6332 1.64191C2.3781 0.893029 3.38796 0.471625 4.44142 0.470067H130.44C131.493 0.471625 132.503 0.893029 133.248 1.64191C133.993 2.39078 134.412 3.40603 134.414 4.46511V18.096Z"
                                                                            fill="#464E49" />
                                                                        <path
                                                                            d="M130.44 54.7562H4.44142C3.26391 54.7547 2.13504 54.2838 1.30242 53.4468C0.469794 52.6097 0.00140934 51.4748 0 50.291V36.6604C0.00140934 35.4766 0.469794 34.3417 1.30242 33.5047C2.13504 32.6676 3.26391 32.1967 4.44142 32.1953H130.44C131.617 32.1967 132.746 32.6676 133.579 33.5047C134.411 34.3417 134.88 35.4766 134.881 36.6604V50.291C134.88 51.4748 134.411 52.6097 133.579 53.4468C132.746 54.2838 131.617 54.7547 130.44 54.7562ZM4.44142 32.6654C3.38786 32.6666 2.37779 33.0879 1.63281 33.8368C0.887829 34.5858 0.468771 35.6012 0.467573 36.6604V50.291C0.46856 51.3504 0.887522 52.366 1.63253 53.1152C2.37753 53.8643 3.38772 54.2857 4.44142 54.2869H130.44C131.493 54.2858 132.504 53.8645 133.249 53.1155C133.994 52.3666 134.413 51.3511 134.414 50.2919V36.6604C134.413 35.6012 133.994 34.5858 133.249 33.8368C132.504 33.0879 131.494 32.6666 130.44 32.6654H4.44142Z"
                                                                            fill="#D4DDD7" />
                                                                        <path
                                                                            d="M130.44 86.9534H4.44142C3.26391 86.952 2.13504 86.4811 1.30242 85.6441C0.469794 84.807 0.00140934 83.6721 0 82.4883V68.8577C0.00140934 67.6739 0.469794 66.539 1.30242 65.7019C2.13504 64.8649 3.26391 64.394 4.44142 64.3926H130.44C131.617 64.394 132.746 64.8649 133.579 65.7019C134.411 66.539 134.88 67.6739 134.881 68.8577V82.4883C134.88 83.6721 134.411 84.807 133.579 85.6441C132.746 86.4811 131.617 86.952 130.44 86.9534ZM4.44142 64.8616C3.38786 64.8628 2.37779 65.2841 1.63281 66.033C0.887829 66.782 0.468771 67.7974 0.467573 68.8566V82.4872C0.468701 83.5465 0.887728 84.562 1.63272 85.311C2.37771 86.06 3.38781 86.4813 4.44142 86.4825H130.44C131.493 86.4814 132.504 86.0601 133.249 85.3112C133.994 84.5622 134.413 83.5467 134.414 82.4875V68.8577C134.413 67.7983 133.994 66.7825 133.249 66.0333C132.504 65.2841 131.494 64.8627 130.44 64.8616H4.44142Z"
                                                                            fill="#D4DDD7" />
                                                                        <path
                                                                            d="M21.4648 19.0531C19.9359 19.0531 18.4413 18.5973 17.17 17.7433C15.8987 16.8893 14.9079 15.6756 14.3228 14.2555C13.7377 12.8354 13.5846 11.2728 13.8829 9.76524C14.1812 8.25769 14.9174 6.87291 15.9986 5.78603C17.0797 4.69915 18.4571 3.95897 19.9567 3.6591C21.4562 3.35923 23.0105 3.51313 24.4231 4.10135C25.8356 4.68957 27.043 5.68568 27.8924 6.96372C28.7418 8.24176 29.1952 9.74432 29.1952 11.2814C29.1952 13.3426 28.3808 15.3193 26.931 16.7768C25.4813 18.2343 23.515 19.0531 21.4648 19.0531Z"
                                                                            fill="#52D3A2" />
                                                                        <path
                                                                            d="M119.029 17.6255H36.5108C36.0148 17.6255 35.5391 17.4274 35.1884 17.0748C34.8377 16.7222 34.6406 16.244 34.6406 15.7454C34.6406 15.2467 34.8377 14.7685 35.1884 14.4159C35.5391 14.0633 36.0148 13.8652 36.5108 13.8652H119.029C119.525 13.8652 120 14.0633 120.351 14.4159C120.702 14.7685 120.899 15.2467 120.899 15.7454C120.899 16.244 120.702 16.7222 120.351 17.0748C120 17.4274 119.525 17.6255 119.029 17.6255Z"
                                                                            fill="#D4DDD7" />
                                                                        <path
                                                                            d="M92.1384 9.63332H36.503C36.007 9.63332 35.5313 9.43523 35.1806 9.08264C34.8298 8.73004 34.6328 8.25183 34.6328 7.75318C34.6328 7.25454 34.8298 6.77632 35.1806 6.42372C35.5313 6.07113 36.007 5.87305 36.503 5.87305H92.1384C92.6344 5.87305 93.1101 6.07113 93.4608 6.42372C93.8115 6.77632 94.0086 7.25454 94.0086 7.75318C94.0086 8.25183 93.8115 8.73004 93.4608 9.08264C93.1101 9.43523 92.6344 9.63332 92.1384 9.63332Z"
                                                                            fill="#D4DDD7" />
                                                                        <path
                                                                            d="M21.4648 51.2503C19.9359 51.2503 18.4413 50.7945 17.17 49.9406C15.8987 49.0866 14.9079 47.8728 14.3228 46.4528C13.7377 45.0327 13.5846 43.4701 13.8829 41.9625C14.1812 40.455 14.9174 39.0702 15.9986 37.9833C17.0797 36.8964 18.4571 36.1562 19.9567 35.8564C21.4562 35.5565 23.0105 35.7104 24.4231 36.2986C25.8356 36.8868 27.043 37.8829 27.8924 39.161C28.7418 40.439 29.1952 41.9416 29.1952 43.4787C29.1952 45.5398 28.3808 47.5166 26.931 48.9741C25.4813 50.4315 23.515 51.2503 21.4648 51.2503Z"
                                                                            fill="#EDEDED" />
                                                                        <path
                                                                            d="M119.029 49.8208H36.5108C36.0148 49.8208 35.5391 49.6227 35.1884 49.2701C34.8377 48.9175 34.6406 48.4393 34.6406 47.9407C34.6406 47.442 34.8377 46.9638 35.1884 46.6112C35.5391 46.2586 36.0148 46.0605 36.5108 46.0605H119.029C119.525 46.0605 120 46.2586 120.351 46.6112C120.702 46.9638 120.899 47.442 120.899 47.9407C120.899 48.4393 120.702 48.9175 120.351 49.2701C120 49.6227 119.525 49.8208 119.029 49.8208Z"
                                                                            fill="#EDEDED" />
                                                                        <path
                                                                            d="M92.1384 41.8286H36.503C36.007 41.8286 35.5313 41.6305 35.1806 41.278C34.8298 40.9254 34.6328 40.4471 34.6328 39.9485C34.6328 39.4499 34.8298 38.9716 35.1806 38.619C35.5313 38.2664 36.007 38.0684 36.503 38.0684H92.1384C92.6344 38.0684 93.1101 38.2664 93.4608 38.619C93.8115 38.9716 94.0086 39.4499 94.0086 39.9485C94.0086 40.4471 93.8115 40.9254 93.4608 41.278C93.1101 41.6305 92.6344 41.8286 92.1384 41.8286Z"
                                                                            fill="#EDEDED" />
                                                                        <path
                                                                            d="M21.4648 83.4456C19.9359 83.4456 18.4413 82.9898 17.17 82.1359C15.8987 81.2819 14.9079 80.0682 14.3228 78.6481C13.7377 77.228 13.5846 75.6654 13.8829 74.1578C14.1812 72.6503 14.9174 71.2655 15.9986 70.1786C17.0797 69.0917 18.4571 68.3515 19.9567 68.0517C21.4562 67.7518 23.0105 67.9057 24.4231 68.4939C25.8356 69.0821 27.043 70.0783 27.8924 71.3563C28.7418 72.6343 29.1952 74.1369 29.1952 75.674C29.1952 77.7352 28.3808 79.7119 26.931 81.1694C25.4813 82.6268 23.515 83.4456 21.4648 83.4456Z"
                                                                            fill="#EDEDED" />
                                                                        <path
                                                                            d="M119.029 82.0161H36.5108C36.0148 82.0161 35.5391 81.818 35.1884 81.4655C34.8377 81.1129 34.6406 80.6346 34.6406 80.136C34.6406 79.6374 34.8377 79.1591 35.1884 78.8065C35.5391 78.4539 36.0148 78.2559 36.5108 78.2559H119.029C119.525 78.2559 120 78.4539 120.351 78.8065C120.702 79.1591 120.899 79.6374 120.899 80.136C120.899 80.6346 120.702 81.1129 120.351 81.4655C120 81.818 119.525 82.0161 119.029 82.0161Z"
                                                                            fill="#EDEDED" />
                                                                        <path
                                                                            d="M92.1384 74.0259H36.503C36.007 74.0259 35.5313 73.8278 35.1806 73.4752C34.8298 73.1226 34.6328 72.6444 34.6328 72.1458C34.6328 71.6471 34.8298 71.1689 35.1806 70.8163C35.5313 70.4637 36.007 70.2656 36.503 70.2656H92.1384C92.6344 70.2656 93.1101 70.4637 93.4608 70.8163C93.8115 71.1689 94.0086 71.6471 94.0086 72.1458C94.0086 72.6444 93.8115 73.1226 93.4608 73.4752C93.1101 73.8278 92.6344 74.0259 92.1384 74.0259Z"
                                                                            fill="#EDEDED" />
                                                                        <path
                                                                            d="M21.0664 14.0148C20.8744 14.0153 20.6875 13.9529 20.5339 13.8371L20.5243 13.8298L18.5206 12.289C18.4278 12.2175 18.3499 12.1283 18.2914 12.0265C18.2329 11.9247 18.1949 11.8123 18.1795 11.6958C18.1642 11.5793 18.1719 11.4608 18.2021 11.3473C18.2323 11.2337 18.2845 11.1272 18.3556 11.0339C18.4268 10.9406 18.5155 10.8623 18.6167 10.8035C18.718 10.7447 18.8297 10.7065 18.9457 10.6911C19.0616 10.6757 19.1794 10.6834 19.2924 10.7137C19.4053 10.7441 19.5112 10.7966 19.604 10.8681L20.9019 11.8687L23.9685 7.84637C24.1122 7.6581 24.3243 7.53488 24.5583 7.5038C24.7922 7.47273 25.0289 7.53635 25.2163 7.68067L25.1974 7.70744L25.2168 7.68067C25.4039 7.82529 25.5262 8.03859 25.5571 8.2738C25.5879 8.50901 25.5247 8.74692 25.3814 8.93534L21.7742 13.6644C21.6906 13.7732 21.5832 13.8611 21.4604 13.9215C21.3376 13.9818 21.2026 14.0129 21.0659 14.0124L21.0664 14.0148Z"
                                                                            fill="white" />
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath id="clip0_9710_180322">
                                                                            <rect width="135" height="87"
                                                                                  fill="white" />
                                                                        </clipPath>
                                                                    </defs>
                                                                </svg>
                                                                <p class="mt-6 text-sm+">No selected metrics</p>
                                                                <p class="mt-2 font-semibold">Metrics selected will
                                                                    appear here</p>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>

                                                <template x-if="!showSelectedMetrics && expand && selectedMetricType">
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
                                                        dates: [date],
                                                        comparisonValue: null
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
                                                                        <span class="truncate text-ellipsis"
                                                                              x-text="label"></span>

                                                                        <svg class="shrink-0 transition-transform"
                                                                             width="24"
                                                                             height="24" viewBox="0 0 24 24" fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             :class="open === key ? 'rotate-90' : ''">
                                                                            <path
                                                                                d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z"
                                                                                fill="#121A0F" />
                                                                        </svg>
                                                                    </button>

                                                                    <div class="mt-1 mx-4 bg-gray-light rounded p-4"
                                                                         x-cloak
                                                                         x-show="open === key">
                                                                        <p class="text-sm font-medium">Choose Period</p>
                                                                        <template x-if="selectedMetricType !== 'cagr'">
                                                                            <div
                                                                                class="mt-4 flex flex-wrap gap-x-2.5 gap-y-4 text-xs font-semibold">
                                                                                <template x-for="date in dates(key)"
                                                                                          :key="date">
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
                                                                                        <template
                                                                                            x-if="selectedDates.includes(date)">
                                                                                            <svg width="16" height="16"
                                                                                                 viewBox="0 0 16 16"
                                                                                                 fill="none"
                                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                                <path
                                                                                                    d="M6.66451 10.1146L12.4392 4.33988C12.6345 4.14462 12.9511 4.14462 13.1463 4.33988L13.382 4.57558C13.5773 4.77084 13.5773 5.08743 13.382 5.28269L6.66451 12.0002L2.77543 8.11114C2.58017 7.91587 2.58017 7.59929 2.77544 7.40403L3.01114 7.16833C3.2064 6.97307 3.52298 6.97307 3.71824 7.16833L6.66451 10.1146Z"
                                                                                                    fill="#121A0F" />
                                                                                            </svg>
                                                                                        </template>
                                                                                        <template
                                                                                            x-if="!selectedDates.includes(date)">
                                                                                            <svg width="16" height="16"
                                                                                                 viewBox="0 0 16 16"
                                                                                                 fill="none"
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
                                                                            <div
                                                                                class="mt-4 text-sm border border-[#D1D3D5] rounded-lg grid grid-cols-2 divide-x divide-[#F3F3F3] [&>*]:px-4 bg-white"
                                                                                x-data="{
                                                                    from: null,
                                                                    to: null,
                                                                    dates: [],
                                                                    toOptions: [],
                                                                    fromOptions: [],
                                                                    init() {
                                                                        this.dates = dates(key)

                                                                        this.fromOptions = this.dates.filter((date) => date !== this.to)
                                                                        this.toOptions = this.dates.filter((date) => date !== this.from)

                                                                        const obj = this.tmpValue.find(item => item.metric === expand && item.type === selectedMetricType)

                                                                        if (obj && obj.dates.length >= 2) {
                                                                            this.$nextTick(() => {
                                                                                let dates = [...obj.dates]

                                                                                if (dates[0] > dates[1]) {
                                                                                    dates.reverse()
                                                                                }

                                                                                [this.from, this.to] = dates
                                                                            })
                                                                        }
                                                                    },
                                                                    onChange() {
                                                                        if (!(this.to && this.from)) {
                                                                            const idx = tmpValue.findIndex(item => item.metric === expand && item.type === selectedMetricType && item.period === key)
                                                                            if (idx !== -1) {
                                                                                tmpValue.splice(idx, 1)
                                                                            }
                                                                            return;
                                                                        }

                                                                        this.fromOptions = this.dates.filter((date) => date !== this.to)
                                                                        this.toOptions = this.dates.filter((date) => date !== this.from)

                                                                        const obj = tmpValue.find(item => item.metric === expand && item.type === selectedMetricType && item.period === key)

                                                                        if (!obj) {
                                                                            tmpValue.push({
                                                                                metric: expand,
                                                                                type: selectedMetricType,
                                                                                period: key,
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
                                                                                        x-model="from"
                                                                                        @change="onChange">
                                                                                        <option value="">-</option>
                                                                                        <template
                                                                                            x-for="date in fromOptions"
                                                                                            :key="date">
                                                                                            <option :value="date"
                                                                                                    x-text="date">
                                                                                            </option>
                                                                                        </template>
                                                                                    </select>
                                                                                </label>
                                                                                <div class="py-2">
                                                                                    <label class="text-[#7C8286] block">To</label>
                                                                                    <select
                                                                                        class="block w-full focus:ring-0 focus:border-none bg-none"
                                                                                        x-model="to" @change="onChange">
                                                                                        <option value="">-</option>
                                                                                        <template
                                                                                            x-for="date in toOptions"
                                                                                            :key="date">
                                                                                            <option :value="date"
                                                                                                    x-text="date">
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

                                    <div class="mt-2 p-6">
                                        <button type="button"
                                                class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                                                @click.prevent="showResult">
                                            Add Data
                                        </button>
                                    </div>
                                </div>
                            </x-dropdown>
                        </div>
                    </div>
                    <template x-if="value[0]" :key="id + value[0]">
                        <div class="flex gap-4">
                            <div class="flex items-center justify-between gap-x-5"
                                 x-data="{
                                    id: @js($criteriaId),
                                    selectedCriterion: null,
                                    options: ['Value', '% Growth YoY', 'CAGR'],
                                    tmpValue: '',
                                    value: '',
                                    showDropdown: false,
                                    init() {
                                        this.$watch('selectedCriterion', value => {
                                            if(value) {
                                                const metric = value.find(item => item.id === this.id);

                                                if(!metric) return

                                                const metricType = { value: 'Value', growth: '% Growth YoY', cagr: 'CAGR'} [metric.value[0].type]

                                                if (metricType === this.value) return

                                                this.value = metricType
                                                this.tmpValue = metricType
                                            }
                                        })
                                    },
                                    showResult() {
                                        this.value = this.tmpValue
                                        this.showDropdown = false

                                        const metricTypeMap = {value: 'Value', growth: '% Growth YoY', cagr: 'CAGR'}
                                        const metricKey = Object.keys(metricTypeMap).find(key => metricTypeMap[key] === this.value)

                                        this.selectedCriterion = this.selectedCriterion.map(item => {
                                             if(item.id === this.id) {
                                                return metricKey === 'cagr' ? {...item, value: [{...item.value[0], type: metricKey, period: 'annual', dates: []}]}
                                                    : {...item, value: [{...item.value[0], type: metricKey}]}
                                             }

                                             return item
                                        })
                                    },
                                    get label() {
                                       if(this?.selectedCriterion) {
                                          const metric = this.selectedCriterion.find(item => item.id === this.id)

                                          if (!metric) return 'Choose data'

                                          return { value: 'Value', growth: '% Growth YoY', cagr: 'CAGR'} [metric.value[0].type]
                                       }

                                       return 'Choose data'
                                    },
                                    get hasValueChanged() {
                                        return this.value !== this.tmpValue
                                },
                            }" x-modelable="selectedCriterion"  x-model="selectedCriteria">
                                <div class="flex items-center gap-x-2">
                                    <x-dropdown x-model="showDropdown" placement="bottom-start">
                                        <x-slot name="trigger">
                                            <div
                                                class="border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1"
                                                :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'"
                                                style="max-width: 15rem">
                                                <span class="text-sm truncate"
                                                      x-text="label">
                                                </span>

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

                                        <div class="w-[20rem] sm:w-[26rem]">
                                            <div class="flex justify-between items-start gap-2 px-6 pt-6">
                                                <div>
                                                    <p class="font-medium text-base">Choose Metric type</p>
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

                                            <div class="p-4 py-2">
                                                <template x-for="(option, index) in options" :key="option + '-' + id">
                                                    <label class="p-4 flex items-center gap-x-4 hover:bg-green-light cursor-pointer rounded">
                                                        <input type="radio" :name="option + id" class="custom-radio border-dark focus:ring-0"
                                                               :value="option" x-model="tmpValue">
                                                        <span x-text="option"></span>
                                                    </label>
                                                </template>
                                            </div>

                                            <div class="p-6 border-t">
                                                <button type="button"
                                                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                                                        @click="showResult" :disabled="!hasValueChanged">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </x-dropdown>
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-x-5"
                                 x-data="{
                                    id: @js($criteriaId),
                                    selectedCriterion: null,
                                    tmpValue: '',
                                    value: '',
                                    showDropdown: false,
                                    init() {
                                        this.$watch('selectedCriterion', value => {
                                            if(value) {
                                                const metric = value.find(item => item.id === this.id);

                                                if(!metric) return

                                                const metricPeriod = { quarter: 'Fiscal Quarterly', annual: 'Fiscal Annual'} [metric.value[0].period]

                                                if (metricPeriod === this.value) return

                                                this.value = metricPeriod
                                                this.tmpValue = metricPeriod
                                            }
                                        })
                                    },
                                    showResult() {
                                        this.value = this.tmpValue
                                        this.showDropdown = false

                                        const metricPeriodMap = {quarter: 'Fiscal Quarterly' , annual: 'Fiscal Annual'}
                                        const metricKey = Object.keys(metricPeriodMap).find(key => metricPeriodMap[key] === this.value)

                                        this.selectedCriterion = this.selectedCriterion.map(item => {
                                             if(item.id === this.id) {
                                                return {...item, value: [{...item.value[0], period: metricKey, dates: []}]}
                                             }

                                             return item
                                        })

                                    },
                                    get label() {
                                       if(this?.selectedCriterion) {
                                          const metric = this.selectedCriterion.find(item => item.id === this.id)

                                          if (!metric) return 'Choose data'

                                          return {quarter: 'Fiscal Quarterly' , annual: 'Fiscal Annual'} [metric.value[0].period]
                                       }

                                       return 'Choose data'
                                    },
                                    get hasValueChanged() {
                                        return this.value !== this.tmpValue
                                },
                                    get options() {
                                         if(!this.selectedCriterion) return []

                                         const metric = this.selectedCriterion.find(item => item.id === this.id);

                                         if(!metric) return

                                         const metricType = metric.value[0].type

                                         if (metricType === 'cagr') {
                                            return ['Fiscal Annual']
                                         }

                                         return ['Fiscal Annual', 'Fiscal Quarterly']
                                    }
                            }" x-modelable="selectedCriterion"  x-model="selectedCriteria">
                                <div class="flex items-center gap-x-2">
                                    <x-dropdown x-model="showDropdown" placement="bottom-start">
                                        <x-slot name="trigger">
                                            <div
                                                class="border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1"
                                                :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'"
                                                style="max-width: 15rem">
                                                <span class="text-sm truncate"
                                                      x-text="label">
                                                </span>

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

                                        <div class="w-[20rem] sm:w-[26rem]">
                                            <div class="flex justify-between items-start gap-2 px-6 pt-6">
                                                <div>
                                                    <p class="font-medium text-base">Choose Metric Period</p>
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

                                            <div class="p-4 py-2">
                                                <template x-for="(option, index) in options" :key="option + '-' + id">
                                                    <label class="p-4 flex items-center gap-x-4 hover:bg-green-light cursor-pointer rounded">
                                                        <input type="radio" :name="option + id" class="custom-radio border-dark focus:ring-0"
                                                               :value="option" x-model="tmpValue">
                                                        <span x-text="option"></span>
                                                    </label>
                                                </template>
                                            </div>

                                            <div class="p-6 border-t">
                                                <button type="button"
                                                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                                                        @click="showResult" :disabled="!hasValueChanged">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </x-dropdown>
                                </div>
                            </div>
                            <template x-if="!isCagrMetricType">
                                <div class="flex items-center justify-between gap-x-5"
                                     x-data="{
                                    id: @js($criteriaId),
                                    selectedCriterion: null,
                                    tmpValue: '',
                                    value: '',
                                    showDropdown: false,
                                    init() {
                                        this.$watch('selectedCriterion', value => {
                                            if(value) {
                                                const metric = value.find(item => item.id === this.id);

                                                if(!metric) return

                                                const metricDates = metric.value[0].dates

                                                if (!metricDates.length) return

                                                this.value = [...metricDates]
                                                this.tmpValue = [...metricDates]
                                            }
                                        })
                                    },
                                    showResult() {
                                        this.value = this.tmpValue
                                        this.showDropdown = false

                                        this.selectedCriterion = this.selectedCriterion.map(item => {
                                             if(item.id === this.id) {
                                                return {...item, value: [{...item.value[0], dates: [...this.value]}]}
                                             }

                                             return item
                                        })

                                    },
                                    get label() {
                                       if(this?.selectedCriterion) {
                                          const metric = this.selectedCriterion.find(item => item.id === this.id)

                                          if (!metric) return 'Choose data'

                                          const metricDates = metric.value[0].dates

                                          return metricDates.length > 0 ? metricDates[0] : 'Select Dates'
                                       }

                                       return 'Choose data'
                                    },
                                    get hasValueChanged() {
                                        return this.value !== this.tmpValue
                                },
                                    get options() {
                                         if(!this.selectedCriterion) return []

                                         const metric = this.selectedCriterion.find(item => item.id === this.id);

                                         if(!metric) return

                                         const metricPeriod = metric.value[0].period
                                         const metricKey = metric.value[0].metric.split('||')[0]

                                         return this.dates_[metricPeriod][metricKey] || []
                                    }
                            }" x-modelable="selectedCriterion"  x-model="selectedCriteria">
                                    <div class="flex items-center gap-x-2">
                                        <x-dropdown x-model="showDropdown" placement="bottom-start">
                                            <x-slot name="trigger">
                                                <div
                                                    class="border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1"
                                                    :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'"
                                                    style="max-width: 15rem">
                                                <span class="text-sm truncate"
                                                      x-text="label">
                                                </span>

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

                                            <div class="w-[20rem] sm:w-[26rem]">
                                                <div class="flex justify-between items-start gap-2 px-6 pt-6">
                                                    <div>
                                                        <p class="font-medium text-base">Choose Metric Period</p>
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

                                                <div class="p-4 py-2">
                                                    <template x-for="(option, index) in options" :key="option + '-' + id">
                                                        <label class="p-4 flex items-center gap-x-4 hover:bg-green-light cursor-pointer rounded">
                                                            <input type="checkbox" :name="option + id" class="custom-checkbox border-dark focus:ring-0"
                                                                   :value="option" x-model="tmpValue">
                                                            <span x-text="option"></span>
                                                        </label>
                                                    </template>
                                                </div>

                                                <div class="p-6 border-t">
                                                    <button type="button"
                                                            class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                                                            @click="showResult" :disabled="!hasValueChanged">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </x-dropdown>
                                    </div>
                                </div>
                            </template>
                            <template x-if="isCagrMetricType">
                                <div class="flex items-center justify-between gap-x-5"
                                     x-data="{
                                        id: @js($criteriaId),
                                        selectedCriterion: null,
                                        from: null,
                                        to: null,
                                        fromOptions: [],
                                        toOptions: [],
                                        dates: [],
                                        init() {
                                            this.$watch('selectedCriterion', (value) => {
                                                if(!value) return
                                                const metric = value.find(item => item.id === this.id)

                                                const metricPeriod = metric.value[0].period
                                                const metricKey = metric.value[0].metric.split('||')[0]
                                                const metricDates = metric.value[0].dates.sort()

                                                this.dates = [...this.dates_[metricPeriod][metricKey]]

                                                this.fromOptions = this.dates.filter((date) => date !== this.to)
                                                this.toOptions = this.dates.filter((date) => date !== this.from)

                                                this.from = metricDates[0]
                                                this.to = metricDates[1]
                                            })
                                        },
                                        onChange() {
                                            this.fromOptions = this.dates.filter((date) => date !== this.to)
                                            this.toOptions = this.dates.filter((date) => date !== this.from)

                                            this.selectedCriterion = this.selectedCriterion.map(item => {
                                                if(item.id === this.id) {
                                                return {...item, value: [{...item.value[0], dates: [this.from, this.to]}]}
                                            }

                                                return item
                                            })
                                        }
                                    }" x-modelable="selectedCriterion"  x-model="selectedCriteria">
                                    <div class="flex items-center gap-x-2">
                                        <div class="flex items-center gap-4 py-2">
                                            <label class="block">FROM</label>
                                            <select
                                                style="border: 0.5px solid #D4DDD7; appearance: none; -webkit-appearance: none; -moz-appearance: none;"
                                                class="text-[#7C8286] border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center justify-center bg-white hover:bg-[#E2E2E2] cursor-pointer focus:ring-0 text-sm truncate"
                                                x-model="from"
                                                @change="onChange">
                                                <option value="">-</option>
                                                <template
                                                    x-for="date in fromOptions"
                                                    :key="date">
                                                    <option :value="date"
                                                            x-text="date">
                                                    </option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 py-2">
                                        <label class="block">TO</label>
                                        <select
                                            style="border: 0.5px solid #D4DDD7; appearance: none; -webkit-appearance: none; -moz-appearance: none;"
                                            class="text-[#7C8286] border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center justify-center bg-white hover:bg-[#E2E2E2] cursor-pointer focus:ring-0 text-sm truncate"
                                            x-model="to" @change="onChange">
                                            <option value="">-</option>
                                            <template
                                                x-for="date in toOptions"
                                                :key="date">
                                                <option :value="date"
                                                        x-text="date">
                                                </option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                            </template>
                            <div class="flex items-center justify-between gap-x-5"
                                 x-data="{
                                    id: @js($criteriaId),
                                    selectedCriterion: null,
                                    options: ['Greater Than (>)', 'Between', 'Lesser Than (<)', null],
                                    tmpValue: '',
                                    value: '',
                                    showDropdown: false,
                                    comparisonValue: {
                                        greaterThan: 0,
                                        lesserThan: 0,
                                        between: {
                                            first: 0,
                                            second: 0,
                                        },
                                    },
                                    init() {
                                        this.$watch('selectedCriterion', value => {
                                            if(value) {
                                                const metric = value.find(item => item.id === this.id);

                                                if(!metric) return

                                                if (!metric.value[0].comparisonValue?.type) {
                                                    this.value = null
                                                    this.tmpValue = null

                                                    return
                                                }

                                                const comparisonType = { greaterThan: 'Greater Than (>)', between: 'Between', lesserThan: 'Lesser Than (<)'} [metric.value[0].comparisonValue.type]

                                                if (comparisonType === this.value) return

                                                this.value = comparisonType
                                                this.tmpValue = comparisonType
                                            }
                                        })

                                        this.$watch('comparisonValue', value => {
                                             const comparisonTypeMap = { greaterThan: 'Greater Than (>)', between: 'Between', lesserThan: 'Lesser Than (<)'}
                                             const comparisonKey = Object.keys(comparisonTypeMap).find(key => comparisonTypeMap[key] === this.value)

                                            this.selectedCriterion = this.selectedCriterion.map(item => {
                                                if (item.id === this.id) {
                                                   return {...item, value: [{...item.value[0], comparisonValue: {...item.value[0].comparisonValue, data: value[comparisonKey]}}]}
                                                }

                                                return item
                                            })
                                        })
                                    },
                                    showResult() {
                                        this.value = this.tmpValue
                                        this.showDropdown = false

                                        const comparisonTypeMap = {greaterThan: 'Greater Than (>)', between: 'Between', lesserThan: 'Lesser Than (<)'}
                                        const comparisonKey = Object.keys(comparisonTypeMap).find(key => comparisonTypeMap[key] === this.value)

                                        this.selectedCriterion = this.selectedCriterion.map(item => {
                                             if (item.id === this.id) {
                                                return {...item, value: [{...item.value[0], comparisonValue: {type: comparisonKey, data: this.comparisonValue[comparisonKey]}}]}
                                             }

                                             return item
                                        })
                                    },
                                    get label() {
                                       if(this?.selectedCriterion) {
                                          debugger
                                          const metric = this.selectedCriterion.find(item => item.id === this.id)

                                          if (!metric.value[0].comparisonValue?.type) return 'Choose comparison criteria'

                                          return {greaterThan: 'Greater Than (>)', between: 'Between', lesserThan: 'Lesser Than (<)'} [metric.value[0].comparisonValue.type]
                                       }

                                       return 'Choose comparison criteria'
                                    },
                                    get hasValueChanged() {
                                        return this.value !== this.tmpValue
                                },
                            }" x-modelable="selectedCriterion"  x-model="selectedCriteria">
                                <div class="flex items-center gap-x-2">
                                    <x-dropdown x-model="showDropdown" placement="bottom-start">
                                        <x-slot name="trigger">
                                            <div
                                                class="border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1"
                                                :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'"
                                                style="max-width: 15rem">
                                                <span class="text-sm truncate"
                                                      x-text="label">
                                                </span>

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

                                        <div class="w-[20rem] sm:w-[26rem]">
                                            <div class="flex justify-between items-start gap-2 px-6 pt-6">
                                                <div>
                                                    <p class="font-medium text-base">Choose Metric type</p>
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

                                            <div class="p-4 py-2">
                                                <template x-for="(option, index) in options" :key="option + '-' + id">
                                                    <label class="p-4 flex items-center gap-x-4 hover:bg-green-light cursor-pointer rounded">
                                                        <input type="radio" :name="option + id" class="custom-radio border-dark focus:ring-0"
                                                               :value="option" x-model="tmpValue">
                                                        <span x-text="option ? option : 'None'"></span>
                                                    </label>
                                                </template>
                                            </div>

                                            <div class="p-6 border-t">
                                                <button type="button"
                                                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                                                        @click="showResult" :disabled="!hasValueChanged">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </x-dropdown>
                                </div>
                                <template x-if="value === 'Greater Than (>)'">
                                    <input x-model.debounce="comparisonValue.greaterThan" class="w-[80px] border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1 bg-white focus:ring-0 text-sm" type="number"/>
                                </template>
                                <template x-if="value === 'Lesser Than (<)'">
                                    <input x-model.debounce="comparisonValue.lesserThan" class="w-[80px] border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1 bg-white focus:ring-0 text-sm" type="number"/>
                                </template>
                                <template x-if="value === 'Between'">
                                    <div class="flex items-center gap-x-2">
                                        <input x-model.debounce="comparisonValue.between.first" class="w-[80px] border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1 bg-white focus:ring-0 text-sm" type="number"/>
                                        <span>AND</span>
                                        <input x-model.debounce="comparisonValue.between.second" class="w-[80px] border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1 bg-white focus:ring-0 text-sm" type="number"/>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div class="justify-self-end flex items-center children-border-left">
            @if($counter > 0)
                <div>
                    <p class="bg-blue py-1 px-2 rounded-full text-white font-medium">{{ $counter }} Results</p>
                </div>
            @endif
            <div class="px-4">
                <button x-on:click="$wire.removeFinancialCriteria()" type="button" class="text-red text-sm hover:opacity-80">Remove</button>
            </div>
        </div>
    </div>
</div>


