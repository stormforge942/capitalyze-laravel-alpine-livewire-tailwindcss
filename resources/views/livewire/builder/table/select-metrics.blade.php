<div x-data="{
    search: '',
    options: @js($options),
    value: $wire.entangle('selected', true),
    tmpValue: [],
    showDropdown: false,
    activeOption: null,
    expand: null,
    init() {
        this.activeOption = [this.options[0].title]

        this.$watch('showDropdown', value => {
            this.tmpValue = [...this.value]

            this.$nextTick(() => {
                if (value) {
                    window.dispatchEvent(new Event('resize')) // this fixes the dropdown position
                    this.$el.querySelector(`input[type='search']`).focus()
                }
            })
        })
    },
    get filteredOptions() {
        if (!this.search.length) {
            return this.options
        }

        return this.options;
    },
    get subOptions() {
        if (!this.activeOption) {
            return []
        }

        const item = this.options.find(option => option.title === this.activeOption[0]) || {}

        if (!item.has_children) {
            return item?.items
        }

        return item?.items[this.activeOption[1]] || [];
    },
    isActive(title) {
        if (Array.isArray(title)) {
            return this.activeOption && this.activeOption[0] === title[0] && this.activeOption[1] === title[1]
        }

        return this.activeOption && this.activeOption[0] === title
    },
    get hasValueChanged() {
        return [...this.value].sort().map(item => item).join('-') !== [...this.tmpValue].sort().map(item => item).join('-')
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
                        <template x-for="(option, idx) in filteredOptions" :key="idx">
                            <button type="button" class="px-3 border rounded -m-[0.5px]"
                                :class="isActive(option.title) ? 'border-green-dark bg-green-light4 text-dark' :
                                    'border-transparent hover:border-green-muted'"
                                @click="activeOption = [option.title]" x-text="option.title"></button>
                        </template>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 overflow-y-scroll" style="max-height: 25rem">
                        <div>
                            <template x-for="(option, value) in subOptions" :key="value">
                                <div x-data="{
                                    selected: null,
                                    get open() {
                                        return expand === option.title
                                    },
                                    init() {
                                        console.log(value)
                                    }
                                }">
                                    <button type="button"
                                        class="w-full p-4 rounded flex items-center gap-5 justify-between"
                                        @click.prevent="() => {
                                                if(expand === option.title){
                                                    expand = null
                                                } else {
                                                    expand = option.title
                                                }
                                            }">
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
                                                :class="selected === key ? 'bg-green-light4 border-green-dark' :
                                                    'hover:bg-green-light4 bg-[#EDEDED] border-green-muted hover:border-green-dark'"
                                                @click="selected = key" x-text="label">
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div></div>
                    </div>
                </div>

                {{-- <div class="relative mt-2 px-6 grid grid-cols-2 gap-4" style="min-height: 350px;">
                        <div class="space-y-2 overflow-y-auto show-scrollbar left-scrollbar" style="max-height: 340px;">
                            <template x-for="(option, idx) in filteredOptions" :key="idx">
                                <div x-data="{
                                    showChildren: activeOption && activeOption[0] === option.title,
                                }">
                                    <button class="text-left w-full p-4 flex items-center justify-between gap-x-4 rounded"
                                        :class="isActive(option.title) && !option.has_children ? 'bg-green-light' :
                                            'hover:bg-green-light'"
                                        style="letter-spacing: -0.5%"
                                        @click.prevent="showChildren = !showChildren; if(!option.has_children) { activeOption = [option.title] }">
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
                                                    :class="isActive([option.title, title]) ? 'bg-green-light' :
                                                        'hover:bg-green-light'"
                                                    style="letter-spacing: -0.5%"
                                                    @click.prevent="activeOption = [option.title, title]">
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
    
                        <div>
                            <div class="font-semibold" x-text="!activeOption ? '' : activeOption[activeOption.length - 1]">
                            </div>
                            <div class="mt-2 space-y-2 overflow-y-auto show-scrollbar" style="max-height: 310px;">
                                <template x-for="(option, value) in subOptions" :key="value">
                                    <label
                                        class="p-4 flex items-center gap-x-4 cursor-pointer hover:bg-gray-100 rounded-lg">
                                        <input type="checkbox" name="metrics" :value="value" x-model="tmpValue"
                                            class="custom-checkbox border-dark focus:ring-0" />
    
                                        <span x-text="option.title"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div> --}}

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

    <div class="bg-blue rounded-full px-1.5 py-0.5 font-semibold text-xs text-white" x-text="value.length + ' Metrics'">
    </div>
</div>
