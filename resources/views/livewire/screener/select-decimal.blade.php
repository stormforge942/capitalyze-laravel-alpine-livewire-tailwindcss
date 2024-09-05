<div class="flex items-center justify-between gap-x-5"
     x-data="{
                    showDropdown: false,
                    value: null,
                    tmpValue: {
                        value: 0,
                        percentage: 0,
                        perShare: 0
                    },
                    get valueText() {
                        const fn = (val) => val > 0 ? '.' + '0'.repeat(val) : '-'

                        return [
                            fn(this.value.decimalPlaces),
                            fn(this.value.percentageDecimalPlaces),
                            fn(this.value.perShareDecimalPlaces),
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
                    get showResult() {
                        let result = false

                        if (!this.value) return false

                        Object.values(this.value).forEach(value => {
                            if (value !== 0) {
                                result = true
                            }
                        })

                        return result
                    },
                    init() {
                        $watch('showDropdown', value => {

                            this.tmpValue = {
                                value: this.value.decimalPlaces,
                                percentage: this.value.percentageDecimalPlaces,
                                perShare: this.value.perShareDecimalPlaces
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
                        this.value.decimalPlaces = this.tmpValue.value
                        this.value.percentageDecimalPlaces = this.tmpValue.percentage
                        this.value.perShareDecimalPlaces = this.tmpValue.perShare
                        this.showDropdown = false
                    },
                    clear() {
                        this.value = {
                           decimalPlaces: 0,
                           percentageDecimalPlaces: 0,
                           perShareDecimalPlaces: 0
                        }
                    }
}" x-modelable="value" x-model="decimal">
    <div class="flex items-center">
        <x-dropdown x-model="showDropdown" placement="bottom-start">
            <x-slot name="trigger">
                <p class="flex items-center border-[0.5px] border-[#D4DDD7] dropdown-trigger rounded-tl-full rounded-bl-full p-2 text-sm"
                   :class="[
                        showResult ? 'rounded-tr-none rounded-br-none' : 'rounded-tr-full rounded-br-full',
                        showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'
                    ]">
                    Decimal
                    <span :class="showDropdown ? 'rotate-180' : ''" class="transition-transform shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                         fill="none">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </span>
                </p>
            </x-slot>

            <div x-data="{ selectedOption: 'values' }" class="p-4 w-[20rem] sm:w-[26rem]">
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
                        class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none text-base"
                        @click="onSave">
                    Save
                </button>
            </div>
        </x-dropdown>

        <div class="flex items-center gap-1 border-[0.5px] border-[#D4DDD7] rounded-tr-full rounded-br-full">
            <template x-if="showResult">
                <div class="flex items-center bg-[#E2E2E2] p-2 rounded-tr-full rounded-br-full">
                    <span class="text-sm truncate mr-1" x-text="valueText"></span>
                    <button type="button" @click="clear()">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.00045 7.05767L11.0882 3.96994C11.2053 3.85279 11.3953 3.85279 11.5124 3.96995L12.031 4.48849C12.1481 4.60564 12.1481 4.79559 12.031 4.91275L8.94325 8.00047L12.031 11.0881C12.1481 11.2053 12.1481 11.3952 12.031 11.5124L11.5124 12.0309C11.3953 12.1481 11.2053 12.1481 11.0882 12.0309L8.00045 8.94327L4.91276 12.0309C4.7956 12.1481 4.60565 12.1481 4.48849 12.0309L3.96995 11.5124C3.85279 11.3952 3.85279 11.2053 3.96995 11.0881L7.05765 8.00047L3.96994 4.91275C3.85279 4.79559 3.85279 4.60564 3.96995 4.48849L4.48849 3.96994C4.60565 3.85279 4.7956 3.85279 4.91276 3.96995L8.00045 7.05767Z" fill="#C22929"/>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>
