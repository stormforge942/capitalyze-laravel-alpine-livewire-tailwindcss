<div class="bg-white p-6 rounded-lg border-[0.5px] border-[#D4DDD7]" x-data="{
    search: '',
    options: @js($options),
    value: $wire.entangle('selected', true),
    tmpValue: [],
    showDropdown: false,
    activeOption: null,
    width: '320px',
    init() {
        this.activeOption = [this.options[0].title]

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
                    id="select-chart-metrics-input" placeholder="Metrics" x-model.debounce.500ms="search"
                    @click.prevent="if(showDropdown) { $event.stopPropagation(); }">
            </x-slot>

            <div :style="`width: ${width}`">
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

                <div class="relative mt-2 px-6 grid grid-cols-2 gap-4" style="min-height: 350px;">
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
                </div>

                <div class="mt-2 p-6 border-t flex items-center gap-x-4">
                    <button type="button"
                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                        @click.prevent="tmpValue = [...value];" :disabled="!hasValueChanged">
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

        <div class="mt-6 flex flex-wrap gap-3 text-sm font-semibold" x-show="value.length" x-cloak>
            <template x-for="item in value.slice(0, 4)" :key="item">
                <div class="bg-green-light rounded-full p-2 flex items-center gap-x-2.5">
                    <span x-text="metricsMap[item].title"></span>

                    <button class="transition-all text-blue p-0.5 rounded-sm"
                        :class="metricAttributes[item]?.type === 'line' ? 'bg-dark text-green-dark' :
                            'hover:bg-dark hover:text-green-dark'"
                        @click.prevent="metricAttributes[item].type = 'line'" data-tooltip-content="Line Chart"
                        data-tooltip-offset="15">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.83333 2C3.10948 2 3.33333 2.22386 3.33333 2.5V12.6667H13.5C13.7761 12.6667 14 12.8905 14 13.1667V13.5C14 13.7761 13.7761 14 13.5 14H2V2.5C2 2.22386 2.22386 2 2.5 2H2.83333ZM12.9393 4.31314C13.1346 4.11786 13.4512 4.11785 13.6464 4.31312L14.3536 5.02022C14.5488 5.21548 14.5488 5.53207 14.3536 5.72733L10.6667 9.4142L8.66667 7.414L6.394 9.68687C6.19874 9.88215 5.88214 9.88216 5.68687 9.68688L4.97977 8.97975C4.78451 8.78449 4.78452 8.46791 4.97978 8.27265L8.66667 4.58579L10.6667 6.586L12.9393 4.31314Z" />
                        </svg>
                    </button>

                    <button class="transition-all text-blue p-0.5 rounded-sm"
                        :class="metricAttributes[item]?.type === 'bar' ? 'bg-dark text-green-dark' :
                            'hover:bg-dark hover:text-green-dark'"
                        @click.prevent="metricAttributes[item].type = 'bar'" data-tooltip-content="Bar Chart"
                        data-tooltip-offset="15">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.33594 9.66667C1.33594 9.11438 1.78365 8.66667 2.33594 8.66667H4.33594C4.88822 8.66667 5.33594 9.11438 5.33594 9.66667V13C5.33594 13.5523 4.88822 14 4.33594 14H2.33594C1.78365 14 1.33594 13.5523 1.33594 13V9.66667ZM6.0026 3C6.0026 2.44772 6.45032 2 7.0026 2H9.0026C9.55489 2 10.0026 2.44772 10.0026 3V13C10.0026 13.5523 9.55489 14 9.0026 14H7.0026C6.45032 14 6.0026 13.5523 6.0026 13V3ZM10.6693 6.33333C10.6693 5.78105 11.117 5.33333 11.6693 5.33333H13.6693C14.2216 5.33333 14.6693 5.78105 14.6693 6.33333V13C14.6693 13.5523 14.2216 14 13.6693 14H11.6693C11.117 14 10.6693 13.5523 10.6693 13V6.33333Z" />
                        </svg>
                    </button>

                    <button class="transition-all text-blue p-0.5 rounded-sm"
                        :class="metricAttributes[item]?.type === 'stacked-bar' ? 'bg-dark text-green-dark' :
                            'hover:bg-dark hover:text-green-dark'"
                        @click.prevent="metricAttributes[item].type = 'stacked-bar'"
                        data-tooltip-content="Stacked Bar Chart" data-tooltip-offset="15">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12.5 2C12.7761 2 13 2.22386 13 2.5V4.16667C13 4.44281 12.7761 4.66667 12.5 4.66667H3.5C3.22386 4.66667 3 4.44281 3 4.16667V2.5C3 2.22386 3.22386 2 3.5 2H12.5ZM12.5 11.3333C12.7761 11.3333 13 11.5572 13 11.8333V13.5C13 13.7761 12.7761 14 12.5 14H3.5C3.22386 14 3 13.7761 3 13.5V11.8333C3 11.5572 3.22386 11.3333 3.5 11.3333H12.5ZM12.5 6.66667C12.7761 6.66667 13 6.89052 13 7.16667V8.83333C13 9.10948 12.7761 9.33333 12.5 9.33333H3.5C3.22386 9.33333 3 9.10948 3 8.83333V7.16667C3 6.89052 3.22386 6.66667 3.5 6.66667H12.5Z"
                                fill="currentColor" />
                        </svg>
                    </button>

                    <button class="transition-all text-blue p-0.5 rounded-sm"
                        :class="metricAttributes[item]?.sAxis ? 'bg-dark text-green-dark' :
                            'hover:bg-dark hover:text-green-dark'"
                        @click.prevent="metricAttributes[item].sAxis = !metricAttributes[item]?.sAxis"
                        data-tooltip-content="Toggle Separate Axis" data-tooltip-offset="15">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.33917 3.044C5.83314 2.77982 6.36986 2.66732 7.4248 2.66732H8.57C9.62493 2.66732 10.1617 2.77982 10.6556 3.044C11.0751 3.26835 11.3964 3.5896 11.6207 4.00909C11.8849 4.50306 11.9974 5.03978 11.9974 6.09472V9.90658C11.9974 10.9615 11.8849 11.4983 11.6207 11.9922C11.3964 12.4117 11.0751 12.733 10.6556 12.9573C10.1617 13.2214 9.62493 13.334 8.57 13.334H7.4248C6.36986 13.334 5.83314 13.2214 5.33917 12.9573C4.91968 12.733 4.59843 12.4117 4.37408 11.9922C4.1099 11.4983 3.9974 10.9615 3.9974 9.90658V6.09472C3.9974 5.03978 4.1099 4.50306 4.37408 4.00909C4.59843 3.5896 4.91968 3.26835 5.33917 3.044ZM8.57 1.33398H7.4248C6.0822 1.33398 5.36222 1.51964 4.71037 1.86825C4.05852 2.21686 3.54694 2.72844 3.19833 3.38029C2.84972 4.03214 2.66406 4.75212 2.66406 6.09472V9.90658C2.66406 11.2492 2.84972 11.9692 3.19833 12.621C3.54694 13.2729 4.05852 13.7845 4.71037 14.1331C5.36222 14.4817 6.0822 14.6673 7.4248 14.6673H8.57C9.9126 14.6673 10.6326 14.4817 11.2844 14.1331C11.9363 13.7845 12.4479 13.2729 12.7965 12.621C13.1451 11.9692 13.3307 11.2492 13.3307 9.90658V6.09472C13.3307 4.75212 13.1451 4.03214 12.7965 3.38029C12.4479 2.72844 11.9363 2.21686 11.2844 1.86825C10.6326 1.51964 9.9126 1.33398 8.57 1.33398ZM8.66406 4.00065H7.33073V7.33398H8.66406V4.00065ZM5.16927 9.17265L7.99773 12.0011L10.8261 9.17265L9.88333 8.22985L7.99773 10.1155L6.11208 8.22985L5.16927 9.17265Z"
                                fill="currentColor" />
                        </svg>
                    </button>

                    <button class="transition-all p-0.5 rounded-sm hover:bg-dark hover:text-green-dark"
                        @click.prevent="metricAttributes[item].show = !metricAttributes[item].show"
                        :data-tooltip-content="metricAttributes[item]?.show ? 'Show' : 'Hide'"
                        data-tooltip-offset="15">
                        <svg class="h-4 w-4 text-blue" data-slot="icon" fill="none" stroke-width="2"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true" x-show="metricAttributes[item]?.show">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                        </svg>
                        <svg class="h-4 w-4 text-red" data-slot="icon" fill="none" stroke-width="2"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true" x-show="!metricAttributes[item]?.show">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88">
                            </path>
                        </svg>
                    </button>

                    <button class="transition-all hover:opacity-80" type="button"
                        @click.prevent="value = value.filter(i => i !== item); dispatchValueChanged()">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.99479 14.6693C4.31289 14.6693 1.32812 11.6845 1.32812 8.0026C1.32812 4.3207 4.31289 1.33594 7.99479 1.33594C11.6767 1.33594 14.6615 4.3207 14.6615 8.0026C14.6615 11.6845 11.6767 14.6693 7.99479 14.6693ZM7.99479 7.0598L6.10917 5.17418L5.16636 6.11698L7.05199 8.0026L5.16636 9.8882L6.10917 10.831L7.99479 8.9454L9.88039 10.831L10.8232 9.8882L8.93759 8.0026L10.8232 6.11698L9.88039 5.17418L7.99479 7.0598Z"
                                fill="#C22929" />
                        </svg>
                    </button>
                </div>
            </template>

            <div class="flex items-center">
                <x-dropdown placement="bottom-start" class="font-normal text-base" x-show="value.length > 4" x-cloak>
                    <x-slot name="trigger">
                        <div class="flex items-center gap-x-2 px-2 py-1 rounded-full"
                            :class="open ? 'bg-gray-light' : 'hover:bg-gray-light'">
                            <span class="font-medium">More</span>
                            <div class="font-bold bg-dark text-white h-4 w-4 rounded-full shrink-0 text-xs grid place-content-center"
                                x-text="value.length - 4"></div>
                            <svg width="13" height="16" viewBox="0 0 13 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                    fill="#121A0F" />
                            </svg>
                        </div>
                    </x-slot>

                    <div class="p-5 flex flex-wrap gap-3 text-sm font-semibold w-full max-w-[400px]">
                        <template x-for="item in value.slice(4, value.length)" :key="item">
                            <div class="bg-green-light rounded-full p-2 flex items-center gap-x-2.5">
                                <span x-text="metricsMap[item].title" class="text-ellipsis truncate max-w-[150px]"
                                    :data-tooltip-content="metricsMap[item].title"></span>

                                <button class="transition-all text-blue p-0.5 rounded-sm"
                                    :class="metricAttributes[item]?.type === 'line' ? 'bg-dark text-green-dark' :
                                        'hover:bg-dark hover:text-green-dark'"
                                    @click.prevent="metricAttributes[item].type = 'line'"
                                    data-tooltip-content="Line Chart" data-tooltip-offset="15">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.83333 2C3.10948 2 3.33333 2.22386 3.33333 2.5V12.6667H13.5C13.7761 12.6667 14 12.8905 14 13.1667V13.5C14 13.7761 13.7761 14 13.5 14H2V2.5C2 2.22386 2.22386 2 2.5 2H2.83333ZM12.9393 4.31314C13.1346 4.11786 13.4512 4.11785 13.6464 4.31312L14.3536 5.02022C14.5488 5.21548 14.5488 5.53207 14.3536 5.72733L10.6667 9.4142L8.66667 7.414L6.394 9.68687C6.19874 9.88215 5.88214 9.88216 5.68687 9.68688L4.97977 8.97975C4.78451 8.78449 4.78452 8.46791 4.97978 8.27265L8.66667 4.58579L10.6667 6.586L12.9393 4.31314Z" />
                                    </svg>
                                </button>

                                <button class="transition-all text-blue p-0.5 rounded-sm"
                                    :class="metricAttributes[item]?.type === 'bar' ? 'bg-dark text-green-dark' :
                                        'hover:bg-dark hover:text-green-dark'"
                                    @click.prevent="metricAttributes[item].type = 'bar'"
                                    data-tooltip-content="Bar Chart" data-tooltip-offset="15">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.33594 9.66667C1.33594 9.11438 1.78365 8.66667 2.33594 8.66667H4.33594C4.88822 8.66667 5.33594 9.11438 5.33594 9.66667V13C5.33594 13.5523 4.88822 14 4.33594 14H2.33594C1.78365 14 1.33594 13.5523 1.33594 13V9.66667ZM6.0026 3C6.0026 2.44772 6.45032 2 7.0026 2H9.0026C9.55489 2 10.0026 2.44772 10.0026 3V13C10.0026 13.5523 9.55489 14 9.0026 14H7.0026C6.45032 14 6.0026 13.5523 6.0026 13V3ZM10.6693 6.33333C10.6693 5.78105 11.117 5.33333 11.6693 5.33333H13.6693C14.2216 5.33333 14.6693 5.78105 14.6693 6.33333V13C14.6693 13.5523 14.2216 14 13.6693 14H11.6693C11.117 14 10.6693 13.5523 10.6693 13V6.33333Z" />
                                    </svg>
                                </button>

                                <button class="transition-all text-blue p-0.5 rounded-sm"
                                    :class="metricAttributes[item]?.type === 'stacked-bar' ? 'bg-dark text-green-dark' :
                                        'hover:bg-dark hover:text-green-dark'"
                                    @click.prevent="metricAttributes[item].type = 'stacked-bar'"
                                    data-tooltip-content="Stacked Bar Chart" data-tooltip-offset="15">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.5 2C12.7761 2 13 2.22386 13 2.5V4.16667C13 4.44281 12.7761 4.66667 12.5 4.66667H3.5C3.22386 4.66667 3 4.44281 3 4.16667V2.5C3 2.22386 3.22386 2 3.5 2H12.5ZM12.5 11.3333C12.7761 11.3333 13 11.5572 13 11.8333V13.5C13 13.7761 12.7761 14 12.5 14H3.5C3.22386 14 3 13.7761 3 13.5V11.8333C3 11.5572 3.22386 11.3333 3.5 11.3333H12.5ZM12.5 6.66667C12.7761 6.66667 13 6.89052 13 7.16667V8.83333C13 9.10948 12.7761 9.33333 12.5 9.33333H3.5C3.22386 9.33333 3 9.10948 3 8.83333V7.16667C3 6.89052 3.22386 6.66667 3.5 6.66667H12.5Z"
                                            fill="currentColor" />
                                    </svg>
                                </button>

                                <button class="transition-all text-blue p-0.5 rounded-sm"
                                    :class="metricAttributes[item]?.sAxis ? 'bg-dark text-green-dark' :
                                        'hover:bg-dark hover:text-green-dark'"
                                    @click.prevent="metricAttributes[item].sAxis = !metricAttributes[item]?.sAxis"
                                    data-tooltip-content="Toggle Separate Axis" data-tooltip-offset="15">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.33917 3.044C5.83314 2.77982 6.36986 2.66732 7.4248 2.66732H8.57C9.62493 2.66732 10.1617 2.77982 10.6556 3.044C11.0751 3.26835 11.3964 3.5896 11.6207 4.00909C11.8849 4.50306 11.9974 5.03978 11.9974 6.09472V9.90658C11.9974 10.9615 11.8849 11.4983 11.6207 11.9922C11.3964 12.4117 11.0751 12.733 10.6556 12.9573C10.1617 13.2214 9.62493 13.334 8.57 13.334H7.4248C6.36986 13.334 5.83314 13.2214 5.33917 12.9573C4.91968 12.733 4.59843 12.4117 4.37408 11.9922C4.1099 11.4983 3.9974 10.9615 3.9974 9.90658V6.09472C3.9974 5.03978 4.1099 4.50306 4.37408 4.00909C4.59843 3.5896 4.91968 3.26835 5.33917 3.044ZM8.57 1.33398H7.4248C6.0822 1.33398 5.36222 1.51964 4.71037 1.86825C4.05852 2.21686 3.54694 2.72844 3.19833 3.38029C2.84972 4.03214 2.66406 4.75212 2.66406 6.09472V9.90658C2.66406 11.2492 2.84972 11.9692 3.19833 12.621C3.54694 13.2729 4.05852 13.7845 4.71037 14.1331C5.36222 14.4817 6.0822 14.6673 7.4248 14.6673H8.57C9.9126 14.6673 10.6326 14.4817 11.2844 14.1331C11.9363 13.7845 12.4479 13.2729 12.7965 12.621C13.1451 11.9692 13.3307 11.2492 13.3307 9.90658V6.09472C13.3307 4.75212 13.1451 4.03214 12.7965 3.38029C12.4479 2.72844 11.9363 2.21686 11.2844 1.86825C10.6326 1.51964 9.9126 1.33398 8.57 1.33398ZM8.66406 4.00065H7.33073V7.33398H8.66406V4.00065ZM5.16927 9.17265L7.99773 12.0011L10.8261 9.17265L9.88333 8.22985L7.99773 10.1155L6.11208 8.22985L5.16927 9.17265Z"
                                            fill="currentColor" />
                                    </svg>
                                </button>

                                <button class="transition-all p-0.5 rounded-sm hover:bg-dark hover:text-green-dark"
                                    @click.prevent="metricAttributes[item].show = !metricAttributes[item].show"
                                    :data-tooltip-content="metricAttributes[item]?.show ? 'Show' : 'Hide'"
                                    data-tooltip-offset="15">
                                    <svg class="h-4 w-4 text-blue" data-slot="icon" fill="none" stroke-width="2"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true" x-show="metricAttributes[item]?.show">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                    </svg>
                                    <svg class="h-4 w-4 text-red" data-slot="icon" fill="none" stroke-width="2"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true" x-show="!metricAttributes[item]?.show">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88">
                                        </path>
                                    </svg>
                                </button>

                                <button class="transition-all hover:opacity-80" type="button"
                                    @click.prevent="value = value.filter(i => i !== item); dispatchValueChanged()">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.99479 14.6693C4.31289 14.6693 1.32812 11.6845 1.32812 8.0026C1.32812 4.3207 4.31289 1.33594 7.99479 1.33594C11.6767 1.33594 14.6615 4.3207 14.6615 8.0026C14.6615 11.6845 11.6767 14.6693 7.99479 14.6693ZM7.99479 7.0598L6.10917 5.17418L5.16636 6.11698L7.05199 8.0026L5.16636 9.8882L6.10917 10.831L7.99479 8.9454L9.88039 10.831L10.8232 9.8882L8.93759 8.0026L10.8232 6.11698L9.88039 5.17418L7.99479 7.0598Z"
                                            fill="#C22929" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </x-dropdown>
            </div>
        </div>
    </div>
</div>
