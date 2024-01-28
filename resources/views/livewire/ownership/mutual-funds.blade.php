<div>
    <div class="grid grid-cols-12 items-center gap-2 mb-2">
        <div class="col-span-12 lg:col-span-4 bg-white flex items-center p-4 gap-x-4 border border-[#D4DDD7] rounded">
            <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
                    fill="#828C85" />
            </svg>

            <input type="search" placeholder="Search"
                class="placeholder:text-gray-medium2 border-none flex-1 focus:outline-none focus:ring-0 h-6 min-w-0"
                wire:model.debounce.500ms="filters.search">
        </div>

        <div class="col-span-12 lg:col-span-8 px-4 py-3 bg-white border border-[#D4DDD7] rounded">
            <div class="items-center gap-2 text-sm inline-flex" wire:ignore>
                <span class="hidden sm:inline">Period</span>

                <div x-data="{
                    showDropdown: false,
                    value: $wire.entangle('filters.periodRange'),
                    tmpValue: [null, null],
                    get valueText() {
                        if (!this.value) {
                            return 'All';
                        }
                
                        return this.value[0] + ' - ' + this.value[1];
                    },
                    get isDisabled() {
                        if (
                            (this.value == null && !this.tmpValue[0] && !this.tmpValue[1]) ||
                            (this.value && this.tmpValue[0] == this.value[0] && this.tmpValue[1] == this.value[1])
                        ) {
                            return true;
                        }
                
                        return false;
                    },
                    init() {
                        $watch('showDropdown', value => {
                            this.tmpValue = this.value || [null, null]
                        })
                    },
                    selectValue() {
                        if (this.tmpValue[0] && this.tmpValue[1]) {
                            this.value = this.tmpValue;
                        } else {
                            this.value = null;
                        }
                
                        this.showDropdown = false;
                    },
                }" class="inline-block">
                    <x-dropdown x-model="showDropdown" placement="bottom-start">
                        <x-slot name="trigger">
                            <div class="border-[0.5px] border-[#93959880] p-2 rounded-full flex items-center gap-x-1"
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
                                <span class="font-medium text-base">Period</span>

                                <div class="flex items-center gap-x-1">
                                    <button class="text-danger hover:underline text-sm"
                                        x-show="tmpValue[0] && tmpValue[1]"
                                        @click="tmpValue = [null, null]">Clear</button>

                                    <button @click="dropdown.hide()">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                                fill="#686868" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="p-6">
                                <x-range-calendar x-model="tmpValue" class="flex justify-center" wire:ignore />
                            </div>

                            <div class="p-6">
                                <button type="button"
                                    class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-gray-medium2 text-base"
                                    @click="selectValue()" :disabled="isDisabled">
                                    Show Result
                                </button>
                            </div>
                        </div>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>

    <livewire:ownership.mutual-funds-table :ticker="$ticker" />
</div>
{{-- extra div just to fix some bug --}}
</div>
