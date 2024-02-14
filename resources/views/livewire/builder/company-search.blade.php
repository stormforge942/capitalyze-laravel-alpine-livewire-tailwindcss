<div class="bg-white p-6 rounded-lg border-[0.5px] border-[#D4DDD7]" x-data="{
    search: $wire.entangle('search', true),
    companies: @js($companies),
    selectedCompanies: [],
    loading: false,
    init() {
        this.$watch('search', () => {
            this.loading = true
            this.$wire.getCompanies(this.selectedCompanies.map(item => item.ticker))
                .then((response) => {
                    this.companies = response
                })
                .finally(() => {
                    this.loading = false
                })
        })
    },
    toggleCompany(company) {
        if (this.selectedCompanies.find(item => item.ticker === company.ticker)) {
            this.selectedCompanies = this.selectedCompanies.filter(item => item.ticker !== company.ticker)
        }

        this.selectedCompanies.push(company)
    },
}">
    <label class="font-medium">Search for Companies</label><br>
    <div wire:ignore>
        <x-dropdown placement="bottom-start" :fullWidthTrigger="true">
            <x-slot name="trigger">
                <input type="search"
                    class="text-basde mt-4 p-4 block w-full border border-[#D4DDD7] rounded-lg placeholder:text-gray-medium2 focus:ring-0 focus:border-green-dark"
                    placeholder="Company" x-model.debounce.500ms="search">
            </x-slot>

            <div class="w-[20rem] sm:w-[26rem]">
                <div class="flex justify-between gap-2 px-6 pt-6">
                    <span class="font-medium text-base">Select Company</span>

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
                                :checked="selectedCompanies.find(item => item.ticker === company.ticker)"
                                @change="toggleCompany(company)">
                            <span x-text="`${company.name} (${company.ticker})`"></span>
                        </label>
                    </template>

                    <template x-if="!companies.length">
                        <p class="text-gray-medium2 text-center py-5">No result found</p>
                    </template>
                </div>

                <div class="cus-loader" x-cloak x-show="loading">
                    <div class="cus-loaderBar !bg-green-dark"></div>
                </div>        
            </div>
        </x-dropdown>

        <div class="mt-6 flex flex-wrap gap-3 text-sm font-semibold" x-show="selectedCompanies.length" x-cloak>
            <template x-for="company in selectedCompanies" :key="company.ticker">
                <span class="bg-green-light rounded-full p-2 flex items-center gap-x-2">
                    <span x-text="`${company.name} (${company.ticker})`"></span>
                    <button type="button"
                        @click="selectedCompanies = selectedCompanies.filter(item => item.ticker !== company.ticker)">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.99479 14.6693C4.31289 14.6693 1.32812 11.6845 1.32812 8.0026C1.32812 4.3207 4.31289 1.33594 7.99479 1.33594C11.6767 1.33594 14.6615 4.3207 14.6615 8.0026C14.6615 11.6845 11.6767 14.6693 7.99479 14.6693ZM7.99479 7.0598L6.10917 5.17418L5.16636 6.11698L7.05199 8.0026L5.16636 9.8882L6.10917 10.831L7.99479 8.9454L9.88039 10.831L10.8232 9.8882L8.93759 8.0026L10.8232 6.11698L9.88039 5.17418L7.99479 7.0598Z"
                                fill="#C22929" />
                        </svg>
                    </button>
                </span>
            </template>
        </div>
    </div>
</div>
