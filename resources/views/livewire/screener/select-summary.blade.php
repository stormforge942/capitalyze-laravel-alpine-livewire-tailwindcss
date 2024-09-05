<div class="flex items-center justify-between gap-x-5" x-data="{
    tmpValue: [],
    value: [],
    showDropdown: false,
    init() {
        this.$watch('showDropdown', value => {
            this.tmpValue = [...this.value]
        })
    },
    showResult() {
        this.value = [...this.tmpValue]
        this.showDropdown = false
        this.$wire.emit('makeScreenerSummaryRows', this.value)
    },
    get hasValueChanged() {
        return [...this.value].sort().join('-') !== [...this.tmpValue].sort().join('-')
    },
}" x-modelable="value" x-model="summaries">
    <div class="flex items-center gap-x-2">
        <x-dropdown x-model="showDropdown" placement="bottom-start">
            <x-slot name="trigger">
                <p class="px-4 py-1 flex items-center gap-x-2 font-medium border border-[#D4DDD7]  rounded-lg" :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'">
                    Add Summary
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

            <div class="w-[20rem] sm:w-[26rem]">
                <div class="flex justify-between items-start gap-2 px-6 pt-6">
                    <div>
                        <p class="font-medium text-base">Choose Summary</p>
                        <p class="mt-2 text-sm text-[#7C8286]">Know the summary statistics of the chosen tickers</p>
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
                    <template x-for="s in ['Max', 'Min', 'Sum', 'Median']" :key="s">
                        <label class="p-4 flex items-center gap-x-4 hover:bg-green-light cursor-pointer rounded">
                            <input type="checkbox" name="company" class="custom-checkbox border-dark focus:ring-0"
                                   :value="s" x-model="tmpValue">
                            <span x-text="s"></span>
                        </label>
                    </template>
                </div>

                <div class="p-6 border-t">
                    <button type="button"
                            class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                            @click="showResult" :disabled="!hasValueChanged">
                        Show Result
                    </button>
                </div>
            </div>
        </x-dropdown>
    </div>
</div>
