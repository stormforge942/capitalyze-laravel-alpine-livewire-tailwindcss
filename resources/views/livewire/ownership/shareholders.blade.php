<div>
    @if (count($quarters))
        <label class="items-center hidden gap-1 text-sm lg:flex" x-data>
            <span>Quarter to view</span>
            <x-select :options="$quarters" placeholder="Select a quarter" wire:model="quarter"></x-select>

            <template x-teleport="#ownership-tab .tab-slot">
                <x-select :options="$quarters" placeholder="Select a quarter" @change="Livewire.emit('update:quarter', $event.target.value)"></x-select>
            </template>
        </label>
    @endif


    <livewire:ownership.shareholders-table :ticker="$ticker" :quarter="$quarter" />
</div>
