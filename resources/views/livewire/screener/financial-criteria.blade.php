<div class="py-3 flex items-center flex-1 border border-[#D4DDD7] rounded-lg children-border-right max-w-[1230px]"
    x-init="$watch('criteria.type', () => criteria.dates = [])">
    <div class="flex-none px-4" x-data="{
        search: '',
        options: [],
        _options: @js($metrics),
        value: null,
        tmpValue: null,
        showDropdown: false,
        activeOption: null,
        width: '320px',
        init() {
            this.onSearchChange()
    
            this.activeOption = [this.options[0].title]
    
            this.$watch('showDropdown', value => {
                this.tmpValue = this.value
                this.activeOption = [this.options[0].title]
                this.search = ''
            })
    
            this.$watch('search', () => this.onSearchChange())
        },
        onSearchChange() {
            const search = this.search.toLowerCase().trim();
    
            if (!search.length) {
                this.options = this._options;
                return
            }
    
            const options = [];
    
            this._options.forEach(option => {
                if (!option.has_children) {
                    let items = {};
    
                    for (const [key, item] of Object.entries(option.items)) {
                        if (item.title.toLowerCase().includes(search)) {
                            items[key] = item
                        }
                    }
    
                    if (Object.keys(items).length) {
                        options.push({
                            ...option,
                            items
                        })
                    }
    
                    return;
                }
    
                let items = {};
    
                for (const [key, item] of Object.entries(option.items)) {
                    let _items = {}
    
                    for (const [_key, _item] of Object.entries(item)) {
                        if (_item.title.toLowerCase().includes(search)) {
                            _items[_key] = _item
                        }
                    }
    
                    if (Object.keys(_items).length) {
                        items[key] = _items
                    }
                }
    
                if (Object.keys(items).length) {
                    options.push({
                        ...option,
                        items
                    })
                }
            })
    
            this.options = options;
        },
        get pillText() {
            if (!this.value) return 'Choose Data';
    
            const flattened = @js($flattenedMetrics);
    
            return flattened[this.value].title;
        },
        get subOptions() {
            if (!this.activeOption) {
                return []
            }
    
            const item = this.options.find(option => option.title === this.activeOption[0]) || {}
    
            if (!item.has_children) {
                return item?.items || []
            }
    
            return item?.items[this.activeOption[1]] || [];
        },
        isActive(title) {
            if (Array.isArray(title)) {
                return this.activeOption && this.activeOption[0] === title[0] && this.activeOption[1] === title[1]
            }
    
            return this.activeOption && this.activeOption[0] === title
        },
        showResult() {
            this.value = this.tmpValue;
            this.showDropdown = false;
    
            this.dispatchValueChanged()
        },
        dispatchValueChanged() {
            Livewire.emit('metricsChanged', this.value)
        }
    }" x-modelable="value" x-model="criteria.metric">
        <x-dropdown x-model="showDropdown" placement="bottom-start" :fullWidthTrigger="true">
            <x-slot name="trigger">
                <div class="border border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1"
                    :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'" style="max-width: 15rem">
                    <span class="truncate text-sm" x-text="pillText"></span>

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

            <div style="width: 600px">
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

                <div class="relative mt-2 px-6 grid grid-cols-2 gap-4" style="min-height: 350px">
                    <div class="space-y-2 overflow-y-auto show-scrollbar left-scrollbar" style="max-height: 340px">
                        <template x-for="(option, idx) in options" :key="idx">
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
                        <p class="text-gray-500" x-show="!options.length && search.length" x-cloak>
                            No metrics found for the search
                        </p>
                    </div>

                    <div x-show="options.length" x-cloak>
                        <div class="font-semibold" x-text="!activeOption ? '' : activeOption[activeOption.length - 1]">
                        </div>
                        <div class="mt-2 space-y-2 overflow-y-auto show-scrollbar" style="max-height: 310px">
                            <template x-for="(option, value) in subOptions" :key="value">
                                <label
                                    class="p-4 flex items-center gap-x-4 cursor-pointer hover:bg-gray-100 rounded-lg">
                                    <input type="radio" name="metrics" :value="value" x-model="tmpValue"
                                        class="custom-radio border-dark focus:ring-0" />

                                    <span x-text="option.title"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-2 p-6 border-t">
                    <button type="button"
                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                        :disabled="!tmpValue" @click.prevent="showResult">
                        Add Data
                    </button>
                </div>
            </div>
        </x-dropdown>
    </div>

    <x-select class="flex-none px-4" placeholder="Choose Data Type" :options="['value' => 'Value', 'changeYoY' => '% Change YoY']" x-model="criteria.type"
        x-show="criteria.metric" :auto-disable="false" btn-text="Done"></x-select>

    <x-select class="flex-none px-4" placeholder="Choose Period" :options="['annual' => 'Fiscal Annual', 'quarterly' => 'Fiscal Quarterly']" x-model="criteria.period"
        x-show="criteria.metric" :auto-disable="false" btn-text="Done"></x-select>

    <template x-if="criteria.metric && criteria.period === 'annual'">
        <x-select class="flex-none px-4" placeholder="Dates" :options="$dates['annual']" x-model="criteria.dates"
            :multiple="true" :auto-disable="false" btn-text="Done"></x-select>
    </template>

    <template x-if="criteria.metric && criteria.period === 'quarterly'">
        <x-select class="flex-none px-4" placeholder="Dates" :options="$dates['quarterly']" x-model="criteria.dates"
            :multiple="true" :auto-disable="false" btn-text="Done"></x-select>
    </template>

    <template x-if="criteria.metric && criteria.dates.length">
        <x-select class="flex-none px-4" placeholder="Choose Operation" :options="$_options['operators']"
            x-model="criteria.operator" :auto-disable="false" btn-text="Done"
            @selected="() => {
                criteria.value = event.detail.selected === 'between' ? [null, null] : null
            }"></x-select>
    </template>

    <template x-if="criteria.dates.length && criteria.metric && criteria.operator">
        <div class="flex-none">
            <template x-if="criteria.operator === 'between'">
                <div class="flex items-center gap-x-2">
                    <input x-model.debounce="criteria.value[0]"
                        class="w-[80px] border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1 bg-white focus:ring-0 text-sm"
                        type="number" />
                    <span>AND</span>
                    <input x-model.debounce="criteria.value[1]"
                        class="w-[80px] border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1 bg-white focus:ring-0 text-sm"
                        type="number" />
                </div>
            </template>

            <template x-if="criteria.operator !== 'between'">
                <input x-model.debounce="criteria.value"
                    class="w-[80px] border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1 bg-white focus:ring-0 text-sm"
                    type="number" />
            </template>
        </div>
    </template>

    <button class="flex-end text-red flex-none ml-auto px-4 mr-1 text-sm font-medium hover:underline"
        @click="removeFinancialCriteria(criteria.id)">
        Remove
    </button>
</div>
