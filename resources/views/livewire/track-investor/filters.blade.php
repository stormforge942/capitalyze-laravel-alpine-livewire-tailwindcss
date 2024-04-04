<div class="mt-6 grid gap-2 grid-cols-12 items-center" x-data="{
    search: $wire.entangle('search'),
    marketValue: $wire.entangle('marketValue'),
    turnOver: $wire.entangle('turnover'),
    holdings: $wire.entangle('holdings'),
}">
    <div class="col-span-4">
        <x-search-filter wire:model.debounce.800ms="search" />
    </div>

    <div class="col-span-8">
        <x-filter-box>
            <x-select-number-range label="Market Value" unit="M" prefix="$" longLabel="Market Value (in millions)"
                x-model="marketValue"></x-select-number-range>

            <x-select-number-range label="Turnover" unit="M" prefix="$" :allow-negative="true" longLabel="Turnover (in millions)"
                x-model="turnOver"></x-select-number-range>

            <x-select-number-range label="Number of Holdings" unit="" x-model="holdings"></x-select-number-range>
        </x-filter-box>
    </div>
</div>
