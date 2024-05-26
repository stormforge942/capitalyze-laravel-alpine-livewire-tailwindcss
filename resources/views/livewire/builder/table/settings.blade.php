<div x-data="{
    opened: 'decimals',
    showDropdown: false,
    tmpValue: null,
    init() {
        this.tmpValue = JSON.parse(JSON.stringify(settings))

        this.$watch('showDropdown', value => {
            this.tmpValue = JSON.parse(JSON.stringify(settings))
        })
    },
    showResult() {
        settings = this.tmpValue
        this.showDropdown = false
    }
}">
    <x-dropdown placement="bottom-end" x-model="showDropdown">
        <x-slot name="trigger">
            <div class="inline-flex items-center gap-x-1">
                <span class="font-semibold text-sm+">Settings</span>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6.6347 1.47406C7.52376 1.28795 8.4525 1.28208 9.36196 1.47222C9.47996 2.24526 9.93523 2.9596 10.6652 3.38101C11.395 3.80241 12.2414 3.83955 12.9698 3.55519C13.5892 4.24778 14.0485 5.05501 14.3318 5.918C13.7222 6.40671 13.3318 7.15766 13.3318 7.99979C13.3318 8.84246 13.7226 9.59379 14.3329 10.0825C14.192 10.5094 14.0056 10.9285 13.772 11.3331C13.5383 11.7379 13.2686 12.1088 12.9693 12.4443C12.241 12.1601 11.3949 12.1973 10.6652 12.6186C9.93583 13.0397 9.4807 13.7533 9.36223 14.5256C8.47323 14.7117 7.5445 14.7175 6.63498 14.5274C6.51702 13.7544 6.0617 13.04 5.33181 12.6186C4.60192 12.1972 3.75562 12.1601 3.02718 12.4445C2.40774 11.7519 1.94847 10.9446 1.66512 10.0816C2.27478 9.59292 2.66515 8.84192 2.66515 7.99979C2.66515 7.15719 2.27432 6.40584 1.66406 5.91715C1.80492 5.4902 1.99132 5.07118 2.22498 4.66648C2.45864 4.26177 2.72832 3.89083 3.02764 3.55537C3.75598 3.83953 4.60208 3.80232 5.33181 3.38101C6.06112 2.95994 6.5163 2.24639 6.6347 1.47406ZM7.9985 9.99979C9.10303 9.99979 9.9985 9.10439 9.9985 7.99979C9.9985 6.89526 9.10303 5.99981 7.9985 5.99981C6.8939 5.99981 5.99848 6.89526 5.99848 7.99979C5.99848 9.10439 6.8939 9.99979 7.9985 9.99979Z"
                        fill="#121A0F" />
                </svg>
            </div>
        </x-slot>
        <div class="w-[25rem] p-6">
            <div class="flex items-center justify-between">
                <span class="font-medium">Settings</span>
                <button type="button" @click="dropdown.hide()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>
            <div class="mt-2" x-data="{
                expand: 'decimals',
                toggle(expand) {
                    if (this.expand === expand) {
                        this.expand = null
                    } else {
                        this.expand = expand
                    }
                },
            }">
                <div class="p-4" x-data="{
                    get text() {
                        if (tmpValue.decimalPlaces > 0) {
                            return tmpValue.decimalPlaces + ' Decimal Places(.' + '0'.repeat(tmpValue.decimalPlaces) + ')';
                        }
                
                        return '0 Decimal Places'
                    },
                    increase() {
                        tmpValue.decimalPlaces += 1
                    },
                    decrease() {
                        if (tmpValue.decimalPlaces === 0) return
                
                        tmpValue.decimalPlaces -= 1
                    }
                }">
                    <button class="w-full flex items-center justify-between" @click="toggle('decimals')">
                        <span>Decimals</span>
                        <svg class="transition-transform" :class="expand === 'decimals' ? 'rotate-90' : ''"
                            width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.145 12.0316L9.18314 7.09389L10.5939 5.67624L16.9734 12.0247L10.6249 18.4041L9.20728 16.9933L14.145 12.0316Z"
                                fill="#121A0F" />
                        </svg>
                    </button>
                    <div class="mt-5 flex items-center justify-between gap-x-4 px-6" x-show="expand === 'decimals'" x-cloak>
                        <button @click="decrease">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.9974 18.3327C5.39502 18.3327 1.66406 14.6017 1.66406 9.99935C1.66406 5.39697 5.39502 1.66602 9.9974 1.66602C14.5997 1.66602 18.3307 5.39697 18.3307 9.99935C18.3307 14.6017 14.5997 18.3327 9.9974 18.3327ZM9.9974 16.666C13.6793 16.666 16.6641 13.6813 16.6641 9.99935C16.6641 6.31745 13.6793 3.33268 9.9974 3.33268C6.3155 3.33268 3.33073 6.31745 3.33073 9.99935C3.33073 13.6813 6.3155 16.666 9.9974 16.666ZM5.83073 9.16602H14.1641V10.8327H5.83073V9.16602Z"
                                    fill="#121A0F" />
                            </svg>
                        </button>
                        <span class="font-medium" x-text="text"></span>
                        <button @click="increase">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.16406 9.16602V5.83268H10.8307V9.16602H14.1641V10.8327H10.8307V14.166H9.16406V10.8327H5.83073V9.16602H9.16406ZM9.9974 18.3327C5.39502 18.3327 1.66406 14.6017 1.66406 9.99935C1.66406 5.39697 5.39502 1.66602 9.9974 1.66602C14.5997 1.66602 18.3307 5.39697 18.3307 9.99935C18.3307 14.6017 14.5997 18.3327 9.9974 18.3327ZM9.9974 16.666C13.6793 16.666 16.6641 13.6813 16.6641 9.99935C16.6641 6.31745 13.6793 3.33268 9.9974 3.33268C6.3155 3.33268 3.33073 6.31745 3.33073 9.99935C3.33073 13.6813 6.3155 16.666 9.9974 16.666Z"
                                    fill="#121A0F" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <button class="w-full flex items-center justify-between" @click="toggle('unitType')">
                        <span>Unit Type</span>
                        <svg class="transition-transform" :class="expand === 'unitType' ? 'rotate-90' : ''"
                            width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.145 12.0316L9.18314 7.09389L10.5939 5.67624L16.9734 12.0247L10.6249 18.4041L9.20728 16.9933L14.145 12.0316Z"
                                fill="#121A0F" />
                        </svg>
                    </button>
                    <div class="mt-8 space-y-6" x-show="expand === 'unitType'" x-cloak>
                        <template x-for="unit in ['Thousands', 'Millions', 'Billions']" :key="unit">
                            <label class="flex items-center gap-x-6">
                                <input type="radio" name="unitType" :value="unit" class="custom-radio" x-model="tmpValue.unit">
                                <span x-text="unit"></span>
                            </label>
                        </template>
                    </div>
                </div>
                <button type="button"
                    class="mt-6 w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D4DDD7] disabled:text-gray-medium2 text-base"
                    @click="showResult">
                    Show Result
                </button>
            </div>
        </div>
    </x-dropdown>
</div>
