<div class="bg-white p-6 rounded-lg border-[0.5px] border-[#D4DDD7]" x-data="{
    search: '',
    options: @js($options),
    value: @js($options),
    tmpValue: [],
    showDropdown: false,
    activeOption: null,
    width: '320px',
    init() {
        const _options = @js($options)

        this.activeOption = [_options.find(option => !option.has_children)?.title]

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


                        if (!tmp.length) {
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
    get subOptions() {
        if (!this.activeOption) {
            return []
        }

        const item = this.value.find(option => option.title === this.activeOption[0]) || {}

        if (!item.has_children) {
            return item?.items
        }

        return item?.items[this.activeOption[1]] || [];
    },
    toggleValue(company) {
        if (this.tmpValue.find(item => item.ticker === company.ticker)) {
            this.tmpValue = this.tmpValue.filter(item => item.ticker !== company.ticker)
        }

        this.tmpValue.push(company)
    },
    isActive(title) {
        if (Array.isArray(title)) {
            return this.activeOption && this.activeOption[0] === title[0] && this.activeOption[1] === title[1]
        }

        return this.activeOption && this.activeOption[0] === title
    }
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

                <div class="mt-2 px-6 grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <template x-for="(option, idx) in value" :key="idx">
                            <div x-data="{
                                showChildren: activeOption && activeOption[0] === option.title,
                            }">
                                <button class="text-left w-full p-4 flex items-center justify-between gap-x-4 rounded"
                                    :class="isActive(option.title) && !option.has_children ? 'bg-green-light' : 'hover:bg-green-light'"
                                    style="letter-spacing: -0.5%"
                                    @click="showChildren = !showChildren; activeOption = [option.title]">
                                    <span :class="option.has_children ? 'font-semibold' : ''"
                                        x-text="option.title"></span>

                                    <template x-if="!option.has_children">
                                        <svg width="24" height="24" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.0026 7.33398V5.33398L10.6693 8.00065L8.0026 10.6673V8.66732H5.33594V7.33398H8.0026ZM8.0026 1.33398C11.6826 1.33398 14.6693 4.32065 14.6693 8.00065C14.6693 11.6807 11.6826 14.6673 8.0026 14.6673C4.3226 14.6673 1.33594 11.6807 1.33594 8.00065C1.33594 4.32065 4.3226 1.33398 8.0026 1.33398ZM8.0026 13.334C10.9493 13.334 13.3359 10.9473 13.3359 8.00065C13.3359 5.05398 10.9493 2.66732 8.0026 2.66732C5.05594 2.66732 2.66927 5.05398 2.66927 8.00065C2.66927 10.9473 5.05594 13.334 8.0026 13.334Z"
                                                fill="#121A0F" />
                                        </svg>
                                    </template>
                                    <template x-if="option.has_children">
                                        <svg class="transition-transform" :class="showChildren ? 'rotate-90' : ''"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z"
                                                fill="#121A0F" />
                                        </svg>
                                    </template>
                                </button>

                                <template x-if="option.has_children && showChildren">
                                    <div class="pl-4">
                                        <template x-for="title in Object.keys(option.items)" :key="title">
                                            <button
                                                class="text-left w-full mt-2 px-4 py-2 flex items-center justify-between gap-x-4 rounded"
                                                :class="isActive([option.title, title]) ? 'bg-green-light' : 'hover:bg-green-light'"
                                                style="letter-spacing: -0.5%" @click="activeOption = [option.title, title]">
                                                <span x-text="title"></span>
    
                                                <svg width="24" height="24" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M8.0026 7.33398V5.33398L10.6693 8.00065L8.0026 10.6673V8.66732H5.33594V7.33398H8.0026ZM8.0026 1.33398C11.6826 1.33398 14.6693 4.32065 14.6693 8.00065C14.6693 11.6807 11.6826 14.6673 8.0026 14.6673C4.3226 14.6673 1.33594 11.6807 1.33594 8.00065C1.33594 4.32065 4.3226 1.33398 8.0026 1.33398ZM8.0026 13.334C10.9493 13.334 13.3359 10.9473 13.3359 8.00065C13.3359 5.05398 10.9493 2.66732 8.0026 2.66732C5.05594 2.66732 2.66927 5.05398 2.66927 8.00065C2.66927 10.9473 5.05594 13.334 8.0026 13.334Z"
                                                        fill="#121A0F" />
                                                </svg>
                                            </button>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div class="space-y-2">
                        <div class="">

                        </div>
                        <template x-for="option in subOptions" :key="option">
                            <label class="p-4 flex items-center gap-x-4 cursor-pointer hover:bg-gray-100 rounded-lg">
                                <input type="checkbox" class="custom-checkbox border-dark focus:ring-0" />

                                <span x-text="option"></span>
                            </label>
                        </template>
                    </div>
                </div>

                <div class="mt-2 p-6 border-t flex items-center gap-x-4">
                    <button type="button"
                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                        @click="tmpValue = [...value];">
                        Reset
                    </button>
                    <button type="button"
                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                        @click="value = [...tmpValue]; showDropdown = false;">
                        Show Result
                    </button>
                </div>
            </div>
        </x-dropdown>
    </div>
</div>
