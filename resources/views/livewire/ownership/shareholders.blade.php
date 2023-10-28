<div>
    @if(count($quarters))
    <label class="items-center hidden gap-1 text-sm lg:flex">
        <span>Quarter to view</span>
        <x-select :options="$quarters" placeholder="Select a quarter" wire:model="quarter"></x-select>
    </label>
    @endif

    <livewire:ownership.shareholders-table :ticker="$ticker" :quarter="$quarter" />
</div>
