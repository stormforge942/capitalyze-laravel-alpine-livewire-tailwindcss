<div class="mt-6 grid gap-2 grid-cols-12 items-center" x-data="{
    search: $wire.entangle('search'),
    marketValue: $wire.entangle('marketValue'),
    turnOver: $wire.entangle('turnover'),
    holdings: $wire.entangle('holdings'),
    view: $wire.entangle('view'),
    listStyle: $wire.entangle('listStyle'),
    init() {
        ['search', 'marketValue', 'turnOver', 'holdings', 'view', 'listStyle'].forEach((key) => {
            this.$watch(key, (value, oldVal) => {
                if (Array.isArray(value)) {
                    value = value.join(',')
                }

                if (Array.isArray(oldVal)) {
                    oldVal = oldVal.join(',')
                }

                if (value != oldVal && !this.loading) {
                    this.loading = true
                }
            })
        })
    },
    reset() {
        this.search = null
        this.marketValue = null
        this.turnOver = null
        this.holdings = null
        this.view = 'most-recent'
    },
    toggleListStyle() {
        this.listStyle = this.listStyle === 'grid' ? 'list' : 'grid';
    },
}" wire:ignore>
    <div class="col-span-12 xl:col-span-3">
        <x-search-filter x-model.debounce.800ms="search" />
    </div>

    <div class="col-span-12 xl:col-span-9">
        <x-filter-box>
            @if (isset($views))
                <x-select placeholder="View" :options="$views" x-model="view"></x-select>
            @endif

            <x-select-number-range label="Market Value" unit="M" prefix="$"
                longLabel="Market Value (in millions)" x-model="marketValue"></x-select-number-range>

            <x-select-number-range label="Turnover" unit="M" prefix="$" :allow-negative="true"
                longLabel="Turnover (in millions)" x-model="turnOver"></x-select-number-range>

            <x-select-number-range label="Number of Holdings" unit="" x-model="holdings"></x-select-number-range>

            <button class="hidden md:inline-block ml-2.5 border-l pl-3" @click="reset">
                <span class="text-red px-2">Reset</span>
            </button>

            <button class="ml-auto flex items-center gap-x-2 p-2 text-sm font-medium text-dark"
                @click="toggleListStyle()">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.33333 2.66634H14V3.99967H5.33333V2.66634ZM2 2.33301H4V4.33301H2V2.33301ZM2 6.99967H4V8.99967H2V6.99967ZM2 11.6663H4V13.6663H2V11.6663ZM5.33333 7.33301H14V8.66634H5.33333V7.33301ZM5.33333 11.9997H14V13.333H5.33333V11.9997Z"
                        fill="#121A0F" />
                </svg>

                <span x-text="'View as '  + (listStyle === 'grid' ? 'list' : 'grid')"></span>
            </button>
        </x-filter-box>
    </div>
</div>
