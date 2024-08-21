<div>
    <h2 class="text-xl font-semibold">RSS Feeds</h2>

    <div class="mt-6 grid gap-2 grid-cols-12 items-center" x-data="{
        search: $wire.entangle('search'),
        quarter: $wire.entangle('quarter'),
        init() {
            ['search', 'quarter'].forEach((key) => {
                this.$watch(key, (value, oldVal) => {
                    Livewire.emit('filtersChanged', {
                        search: this.search,
                        quarter: this.quarter,
                    });
                })
            })
        }
    }" wire:ignore>
        <div class="col-span-12 md:col-span-3">
            <x-search-filter x-model.debounce.800ms="search" />
        </div>

        <div class="col-span-12 md:col-span-9">
            <x-filter-box>
                @if (isset($quarters))
                    <x-select placeholder="View" :options="$quarters" x-model="quarter"></x-select>
                @endif
            </x-filter-box>
        </div>
    </div>


    <div class="mt-6">
        <livewire:track-investor.rss-feed-table :quarter="$quarter" />
    </div>
</div>

</div>
