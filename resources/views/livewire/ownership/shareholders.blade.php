<div>
    <div class="grid grid-cols-12 gap-2 mb-2">
        <div class="col-span-12 lg:col-span-4">
            <x-search-filter wire:model.debounce.500ms="search" placeholder="Search" font-size="base"></x-search-filter>
        </div>

        <div class="hidden lg:col-span-8 px-4 py-3 bg-white lg:block border border-[#D4DDD7] rounded-lg">
            <div class="items-center gap-2 text-sm hidden lg:inline-flex" x-data="{ quarter: @entangle('quarter') }" wire:ignore>
                <span>Quarter to view</span>
                <x-select name="quarter" :options="$quarters" placeholder="Select a quarter" x-model="quarter"></x-select>

                <x-tab-slot id="ownership-tab" tab="shareholders">
                    <x-select name="quarter" :options="$quarters" placeholder="Select a quarter"
                        x-model="quarter"></x-select>
                </x-tab-slot>
            </div>
        </div>
    </div>

    <livewire:ownership.shareholders-table :ticker="$ticker" :quarter="$quarter" :search="$search" />
</div>
{{-- extra div just to fix some bug --}}
</div>
