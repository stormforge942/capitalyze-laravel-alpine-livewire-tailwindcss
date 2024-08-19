<div class="mt-6 grid gap-2 grid-cols-12 items-center" x-data="{
    search: $wire.entangle('search'),
    marketValue: $wire.entangle('marketValue'),
    turnOver: $wire.entangle('turnover'),
    holdings: $wire.entangle('holdings'),
    view: $wire.entangle('view'),
    init() {
        ['search', 'marketValue', 'turnOver', 'holdings', 'view'].forEach((key) => {
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
    }
}" wire:ignore>
    <div class="col-span-12 md:col-span-3">
        <x-search-filter x-model.debounce.800ms="search" />
    </div>

    <div class="col-span-12 md:col-span-9">
        <x-filter-box>
            @if (isset($views))
                <x-select placeholder="View" :options="$views" x-model="view"></x-select>
            @endif

            <x-select-number-range label="Market Value" unit="M" prefix="$"
                longLabel="Market Value (in millions)" x-model="marketValue"></x-select-number-range>

            <x-select-number-range label="Turnover" unit="M" prefix="$" :allow-negative="true"
                longLabel="Turnover (in millions)" x-model="turnOver"></x-select-number-range>

            <x-select-number-range label="Number of Holdings" unit="" x-model="holdings"></x-select-number-range>
        </x-filter-box>
    </div>
</div>
