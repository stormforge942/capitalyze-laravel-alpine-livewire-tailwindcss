<div x-data="{
    search: $wire.entangle('search', true),
    companies: @js($companies),
    value: $wire.entangle('selected', true),
    tmpValue: [],
    loading: false,
    showDropdown: false,
    init() {
        this.$watch('search', () => {
            this.loading = true
            this.$wire.getCompanies(this.tmpValue.map(item => item.ticker))
                .then((response) => {
                    this.companies = response
                })
                .finally(() => {
                    this.loading = false
                })
        })

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
    toggleCompany(company) {
        if (this.tmpValue.find(item => item === company.ticker)) {
            this.tmpValue = this.tmpValue.filter(item => item !== company.ticker)
            return;
        }

        this.tmpValue.push(company.ticker)
    },
    get hasValueChanged() {
        return [...this.value].sort().join('-') !== [...this.tmpValue].sort().join('-')
    },
    showResult() {
        this.value = [...this.tmpValue]
        this.showDropdown = false
        this.dispatchValueChanged()
    },
    dispatchValueChanged() {
        Livewire.emit('companiesChanged', this.value)
    }
}" class="flex items-center justify-between gap-x-5">
    <div class="flex items-center gap-x-2">
        <div wire:ignore>
            <x-dropdown x-model="showDropdown" placement="bottom-start">
                <x-slot name="trigger">
                    <p class="h-8 px-4 flex items-center gap-x-2 font-medium text-sm bg-[#DCF6EC] rounded" x-cloak
                        x-show="!open">
                        Add Ticker
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
                            @click="$event.stopPropagation()" x-model.debounce.500ms="search">
                    </template>
                </x-slot>

                <div class="w-[20rem] sm:w-[26rem]">
                    <div class="flex justify-between items-start gap-2 px-6 pt-6">
                        <div>
                            <p class="font-medium text-base">Search for companies or stock</p>
                            <p class="mt-2 text-sm text-[#7C8286]">Select multiple options to analyze</p>
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

                    <div class="p-4 py-2" :class="loading ? 'pointer-events-none' : ''">
                        <template x-for="company in companies" :key="company.ticker">
                            <label class="p-4 flex items-center gap-x-4 hover:bg-green-light cursor-pointer rounded">
                                <input type="checkbox" name="company" class="custom-checkbox border-dark focus:ring-0"
                                    :checked="tmpValue.find(item => item === company.ticker)"
                                    @change="toggleCompany(company)" :key="tmpValue.length">
                                <span x-text="`${company.name} (${company.ticker})`"></span>
                            </label>
                        </template>

                        <template x-if="!companies.length">
                            <p class="text-gray-medium2 text-center py-5">No result found</p>
                        </template>
                    </div>

                    <div class="p-6 border-t">
                        <button type="button"
                            class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D1D3D5] disabled:text-white text-base"
                            @click="showResult" :disabled="!hasValueChanged">
                            Show Result
                        </button>
                    </div>

                    <div class="cus-loader" x-cloak x-show="loading">
                        <div class="cus-loaderBar !bg-green-dark"></div>
                    </div>
                </div>
            </x-dropdown>
        </div>

        <div class="bg-blue rounded-full px-1.5 py-0.5 font-semibold text-xs text-white"
            x-text="value.length + ' Tickers'">
        </div>
    </div>
    <button type="button" class="text-red text-sm font-medium" @click="tmpValue = []; showResult()">Clear</button>
</div>
