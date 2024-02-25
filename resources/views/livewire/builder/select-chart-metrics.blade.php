<div class="bg-white p-6 rounded-lg border-[0.5px] border-[#D4DDD7]" x-data="{
    search: '',
    options: @js($options),
    value: [],
    tmpValue: [],
    showDropdown: false,
    activeOption: [0],
    width: '320px',
    init() {
        const _options = @js($options)

        this.$watch('search', () => {
            if (!this.search.length) {
                this.value = _options
                return
            }

            const term = this.search.toLowerCase()
            let tmp = []

            _options.forEach(option => {
                if (!option.title.toLowerCase().includes(term)) {
                    return;
                }

                let group = {
                    title: option.title,
                    has_children: option.has_children || false,
                    items: []
                };

                if (!option.has_children) {
                    group.items = option.items.filter(item => item.toLowerCase().includes(term))

                    if (!group.items.length) {
                        group.items = option.items
                    }

                    tmp.push(group)

                    return
                }

                Object.items(option.items).forEach(([key, value]) => {
                    if (key.toLowerCase().includes(term)) {
                        let tmp = value.filter(item => item.toLowerCase().includes(term))


                        if(!tmp.length) {
                            tmp = value
                        }

                        group.items[key] = tmp

                        tmp.push(group)
                    }
                })
            })

            this.value = tmp

            console.log(this.value)
        })

        this.$watch('showDropdown', value => {
            this.tmpValue = [...this.value]
        })

        this.$nextTick(() => {
            this.width = document.getElementById('select-chart-metrics-input').offsetWidth + 'px'
            window.addEventListener('resize', () => {
                this.width = document.getElementById('select-chart-metrics-input').offsetWidth + 'px'
            })
        })
    },
    toggleValue(company) {
        if (this.tmpValue.find(item => item.ticker === company.ticker)) {
            this.tmpValue = this.tmpValue.filter(item => item.ticker !== company.ticker)
        }

        this.tmpValue.push(company)
    },
}">
    <label class="font-medium flex items-center gap-x-4">
        <div>Search for Metrics</div>
        <div class="flex items-center gap-x-2 bg-[#EDF4ED] px-4 py-1 rounded-lg">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8 1C4.136 1 1 4.136 1 8C1 11.864 4.136 15 8 15C11.864 15 15 11.864 15 8C15 4.136 11.864 1 8 1ZM7.9998 4.5C7.61321 4.5 7.2998 4.8134 7.2998 5.2C7.2998 5.5866 7.61321 5.9 7.9998 5.9C8.3864 5.9 8.6998 5.5866 8.6998 5.2C8.6998 4.8134 8.3864 4.5 7.9998 4.5ZM8.6998 10.8C8.6998 11.185 8.3848 11.5 7.9998 11.5C7.6148 11.5 7.2998 11.185 7.2998 10.8V8C7.2998 7.615 7.6148 7.3 7.9998 7.3C8.3848 7.3 8.6998 7.615 8.6998 8V10.8ZM2.40039 8C2.40039 11.087 4.91339 13.6 8.00039 13.6C11.0874 13.6 13.6004 11.087 13.6004 8C13.6004 4.913 11.0874 2.4 8.00039 2.4C4.91339 2.4 2.40039 4.913 2.40039 8Z"
                    fill="#464E49" />
            </svg>

            <span class="text-dark-light2">Metrics are applied to all companies</span>
        </div>
    </label>
    <div wire:ignore>
        <x-dropdown x-model="showDropdown" placement="bottom-start" :fullWidthTrigger="true">
            <x-slot name="trigger">
                <input type="search"
                    class="text-basde mt-4 p-4 block w-full border border-[#D4DDD7] rounded-lg placeholder:text-gray-medium2 focus:ring-0 focus:border-green-dark"
                    id="select-chart-metrics-input" placeholder="Company" x-model.debounce.500ms="search"
                    @click="if(showDropdown) { $event.stopPropagation(); }">
            </x-slot>

            <div :style="`width: ${width}`">
                <div class="flex justify-between gap-2 px-6 pt-6">
                    <span class="font-medium text-base">Metrics</span>

                    <button @click="dropdown.hide()">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                fill="#C22929" />
                        </svg>
                    </button>
                </div>
            </div>
        </x-dropdown>

        <div class="mt-6 flex flex-wrap gap-3 text-sm font-semibold" x-show="value.length" x-cloak>
            <template x-for="(option, idx) in value" :key="idx">
                <div>
                    
                </div>
            </template>

            <template x-for="(option, idx)">

            </template>
        </div>
    </div>
</div>
