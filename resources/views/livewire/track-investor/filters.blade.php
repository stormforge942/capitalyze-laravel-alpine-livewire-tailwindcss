<div class="mt-6 grid gap-2 grid-cols-12 items-center" x-data="{
    filters: {
        search: $wire.entangle('search'),
        marketValue: $wire.entangle('marketValue'),
        turnOver: $wire.entangle('turnover'),
        holdings: $wire.entangle('holdings'),
        view: $wire.entangle('view'),
    },
    init() {
        this.$watch('filters', value => {
            this.loading = true
        }, { deep: true })
    }
}" wire:ignore>
    <div class="col-span-4">
        <x-search-filter x-model.debounce.800ms="filters.search" />
    </div>

    <div class="col-span-8">
        <x-filter-box>
            @if (isset($views))
                <x-select placeholder="View" :options="$views" x-model="filters.view"></x-select>
            @endif

            <x-select-number-range label="Market Value" unit="M" prefix="$"
                longLabel="Market Value (in millions)" x-model="filters.marketValue"></x-select-number-range>

            <x-select-number-range label="Turnover" unit="M" prefix="$" :allow-negative="true"
                longLabel="Turnover (in millions)" x-model="filters.turnOver"></x-select-number-range>

            <x-select-number-range label="Number of Holdings" unit=""
                x-model="filters.holdings"></x-select-number-range>
        </x-filter-box>
    </div>
</div>
