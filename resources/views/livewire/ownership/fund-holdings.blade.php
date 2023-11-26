<div>
    @if (count($quarters))
        <div class="items-center hidden gap-2 text-sm lg:inline-flex" x-data="{ quarter: @entangle('quarter') }" wire:ignore> 
            <span>Quarter to view</span>
            <x-select name="quarter" :options="$quarters" placeholder="Select a quarter" x-model="quarter"></x-select>

            <x-tab-slot id="company-fund-tab">
                <x-select name="quarter" :options="$quarters" placeholder="Select a quarter" x-model="quarter"></x-select>
            </x-tab-slot>
        </div>
    @endif

    <livewire:ownership.fund-holdings-table :cik="$cik" :quarter="$quarter" />
</div>
