<div>
    @if (count($quarters))
        {{-- @todo: doing wire:ignore to remove alpinejs console errors due to x-tab-slot (but works), need to investigate it later --}}
        <div class="items-center hidden gap-2 text-sm lg:inline-flex" x-data="{ quarter: @entangle('quarter') }" wire:ignore> 
            <span>Quarter to view</span>
            <x-select name="quarter" :options="$quarters" placeholder="Select a quarter" x-model="quarter"></x-select>
        </div>
        
        <x-tab-slot id="ownership-tab">
            <x-select name="quarter" :options="$quarters" placeholder="Select a quarter" x-model="quarter"></x-select>
        </x-tab-slot>
    @endif

    <livewire:ownership.shareholders-table :ticker="$ticker" :quarter="$quarter" />
</div>
