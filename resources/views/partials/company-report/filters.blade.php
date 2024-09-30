<div class="relative rounded-lg">
    <div class="py-3 px-4 bg-white rounded-lg border border-[#D4DDD7]">
        <div class="flex flex-wrap gap-4 items-center text-sm">
            <div class="flex items-center gap-x-1"
                x-show="$wire.activeTab === 'disclosure' && disclosureTab === 'footnotes'" x-cloak>
                <span>Footnotes</span>
                <x-select :options="$disclosureFootnotes" placeholder="Footnotes" :searchable="true" :large="true"
                    x-model="filters.footnote"></x-select>
            </div>
            <div class="flex items-center gap-x-1"
                x-show="!($wire.activeTab === 'disclosure' && disclosureTab === 'footnotes')" x-cloak>
                <span>View</span>
                <x-select :options="$viewTypes" placeholder="View" x-model="filters.view"></x-select>
            </div>
            <div class="flex items-center gap-x-1">
                <span>Period Type</span>
                <x-select :options="$periodTypes" placeholder="Period Type" x-model="filters.period"></x-select>
            </div>
            <div class="flex items-center gap-x-1">
                <span>Unit Type</span>
                <x-select :options="$unitTypes" placeholder="Unit Type" x-model="filters.unitType"></x-select>
            </div>
            <div class="flex items-center gap-x-1">
                <span>Decimal</span>
                <div x-data="{
                    showDropdown: false,
                    tmpValue: null,
                    get valueText() {
                        const fn = (val) => val > 0 ? '.' + '0'.repeat(val) : '-'
                        
                        return [
                            fn(filters.decimalPlaces),
                            fn(filters.percentageDecimalPlaces),
                            fn(filters.perShareDecimalPlaces),
                        ].join('|')
                    },
                    get tmpValueText() {
                        const fn = (val) => val > 0 ? val + ' Decimal Places(.' + '0'.repeat(val) + ')' : '0 Decimal Places'

                        return {
                            value: fn(this.tmpValue?.value),
                            percentage: fn(this.tmpValue?.percentage),
                            perShare: fn(this.tmpValue?.perShare),
                        }
                    },
                    get filtersChanged() {
                        const value = this.valueText.split('|').map(item => item.slice(1).length).sort().join('');
                        const tmpValue = this.tmpValue && Object.values(this.tmpValue).sort().join('');

                        return value === tmpValue;
                    },
                    init() {
                        $watch('showDropdown', value => {
                            this.tmpValue = {
                                value: filters.decimalPlaces,
                                percentage: filters.percentageDecimalPlaces,
                                perShare: filters.perShareDecimalPlaces
                            }
                        })
                    },
                    increase(type) {
                        this.tmpValue[type] = Number(this.tmpValue[type]) + 1
                    },
                    decrease(type) {
                        if (this.tmpValue[type] <= 0) return;
                
                        this.tmpValue[type] = Number(this.tmpValue[type]) - 1
                    },
                    onSave() {
                        filters.decimalPlaces = this.tmpValue.value
                        filters.percentageDecimalPlaces = this.tmpValue.percentage
                        filters.perShareDecimalPlaces = this.tmpValue.perShare
                        this.showDropdown = false
                    }
                }" class="inline-block dropdown-scroll">
                    <x-dropdown x-model="showDropdown" placement="bottom-start">
                        <x-slot name="trigger">
                            <div class="border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1"
                                :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'">
                                <span class="text-sm truncate" x-text="valueText">
                                </span>

                                <span :class="showDropdown ? 'rotate-180' : ''" class="transition-transform shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none">
                                        <path
                                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                            fill="#121A0F" />
                                    </svg>
                                </span>
                            </div>
                        </x-slot>

                        <div class="w-[20rem] sm:w-[26rem]">
                            <div class="flex justify-between gap-2 px-6 pt-6">
                                <span class="font-medium text-base">Decimal</span>

                                <button @click="dropdown.hide()">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                            fill="#C22929" />
                                    </svg>
                                </button>
                            </div>

                            <div x-data="{ selectedOption: 'values' }" class="p-6">
                                <div>
                                    <label @click.prevent="selectedOption = selectedOption !== 'values' ? 'values' : null" class="cursor-pointer rounded flex items-center p-4 hover:bg-green-light gap-x-4 relative">
                                        <input x-model="selectedOption" type="radio" name="option" value="values" class="custom-radio border-dark focus:ring-0 cursor-pointer">
                                        <span>Values</span>
                                        <svg class="transition-transform ml-auto" :class="{'rotate-90': selectedOption === 'values'}" :class="showChildren ? 'rotate-90' : ''" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z" fill="#121A0F"></path>
                                        </svg>
                                        <div class="absolute inset-0"></div>
                                    </label>

                                    <div x-show="selectedOption === 'values'" class="mb-1">
                                        <div class="p-4 pt-2 flex items-center justify-between m-auto max-w-[85%]">
                                            <button @click="decrease('value')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM7 11H17V13H7V11Z"
                                                        fill="#121A0F" />
                                                </svg>
                                            </button>
                                            <div class="flex-1 text-center font-semibold">
                                                <span class="text-sm text-blue">Set values to</span><br>
                                                <span x-text="tmpValueText.value"></span>
                                            </div>
                                            <button @click="increase('value')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M11 11V7H13V11H17V13H13V17H11V13H7V11H11ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                                                        fill="#121A0F" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label @click.prevent="selectedOption = selectedOption !== 'percentage' ? 'percentage' : null" class="cursor-pointer rounded flex items-center p-4 hover:bg-green-light gap-x-4 relative">
                                        <input x-model="selectedOption" type="radio" name="option" value="percentage" class="custom-radio border-dark focus:ring-0 cursor-pointer">
                                        <span>Percentage</span>
                                        <svg class="transition-transform ml-auto" :class="{'rotate-90': selectedOption === 'percentage'}" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z" fill="#121A0F"></path>
                                        </svg>
                                        <div class="absolute inset-0"></div>
                                    </label>

                                    <div x-show="selectedOption === 'percentage'" class="mb-1">
                                        <div class="p-4 pt-2 flex items-center justify-between m-auto max-w-[85%]">
                                            <button @click="decrease('percentage')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM7 11H17V13H7V11Z"
                                                        fill="#121A0F" />
                                                </svg>
                                            </button>
                                            <div class="flex-1 text-center font-semibold">
                                                <span class="text-sm text-blue">Set values to</span><br>
                                                <span x-text="tmpValueText.percentage"></span>
                                            </div>
                                            <button @click="increase('percentage')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M11 11V7H13V11H17V13H13V17H11V13H7V11H11ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                                                        fill="#121A0F" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label @click.prevent="selectedOption = selectedOption !== 'share' ? 'share' : null" class="cursor-pointer rounded flex items-center p-4 hover:bg-green-light gap-x-4 relative">
                                        <input x-model="selectedOption" type="radio" name="option" value="share" class="custom-radio border-dark focus:ring-0 cursor-pointer">
                                        <span>Per Share Metrics</span>
                                        <svg class="transition-transform ml-auto" :class="{'rotate-90': selectedOption === 'share'}" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z" fill="#121A0F"></path>
                                        </svg>
                                        <div class="absolute inset-0"></div>
                                    </label>

                                    <div x-show="selectedOption === 'share'" class="mb-1">
                                        <div class="p-4 pt-2 flex items-center justify-between m-auto max-w-[85%]">
                                            <button @click="decrease('perShare')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM7 11H17V13H7V11Z"
                                                        fill="#121A0F" />
                                                </svg>
                                            </button>
                                            <div class="flex-1 text-center font-semibold">
                                                <span class="text-sm text-blue">Set values to</span><br>
                                                <span x-text="tmpValueText.perShare"></span>
                                            </div>
                                            <button @click="increase('perShare')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M11 11V7H13V11H17V13H13V17H11V13H7V11H11ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                                                        fill="#121A0F" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 pt-0">
                                <button type="button"
                                    class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-gray-medium2 text-base"
                                    @click="onSave"
                                    :disabled="filtersChanged">
                                    Show Result
                                </button>
                            </div>
                        </div>
                    </x-dropdown>
                </div>
            </div>
            <div class="flex items-center gap-x-1">
                <span>Order</span>
                <x-select :options="$orderTypes" placeholder="Order" x-model="filters.order"></x-select>
            </div>
            <div class="flex items-center gap-x-1">
                <span>Freeze Panes</span>
                <x-select :options="$freezePaneTypes" placeholder="Freeze Panes" x-model="filters.freezePane"></x-select>
            </div>
        </div>
    </div>

    <div class="cus-loader" wire:loading.block>
        <div class="cus-loaderBar"></div>
    </div>
</div>
