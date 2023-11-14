<div>
    @if (count($quarters))
        <label class="items-center hidden gap-2 text-sm lg:flex" x-data="{ quarter: @entangle('quarter') }">
            <span>Quarter to view</span>
            <x-select :options="$quarters" placeholder="Select a quarter" x-model="quarter"></x-select>

            <x-tab-slot id="ownership-tab">
                <x-select :options="$quarters" placeholder="Select a quarter" x-model="quarter"></x-select>
            </x-tab-slot>
        </label>
    @endif


    <livewire:ownership.shareholders-table :ticker="$ticker" :quarter="$quarter" />
</div>
