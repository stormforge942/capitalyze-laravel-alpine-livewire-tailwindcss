<div>
    @if (count($funds) || count($mutualFunds))
        <div class="mb-6">
            <h2 class="mb-2.5 text-md font-semibold">Summary of selected Favorites</h2>

            <livewire:track-investor.favorites-summary :funds="$funds->pluck('investor_name', 'cik')->toArray()" :mutual-funds="$mutualFunds->pluck('registrant_name', 'fund_symbol')->toArray()" :wire:key="$summaryKey" />
        </div>
    @endif

    <div x-data="{
        loading: $wire.entangle('loading', true),
    }">
        <h2 class="text-xl font-semibold">My Favorites</h2>

        @include('livewire.track-investor.filters')

        <div class="mt-6 relative">
            <div :class="loading ? 'invisible' : ''" x-cloak>
                @if ($listStyle === 'list')
                    <livewire:track-investor.listing-table type="funds" :filters="$filters" :pagination="false" :source="$funds" />

                    <hr class="my-4 md:my-6">

                    <livewire:track-investor.listing-table type="mutual-funds" :filters="$filters" :pagination="false" :source="$mutualFunds" />
                @elseif (count($funds ?? []) || count($mutualFunds ?? []))
                    <div
                        class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fill,minmax(17.19rem,1fr))]">
                        @foreach ($funds as $idx => $fund)
                            <livewire:track-investor.fund-card :fund="$fund" :wire:key="$idx . $fund['cik']"
                                :hide-if-not-favorite="true" />
                        @endforeach
                    </div>

                    @if (count($funds) && count($mutualFunds))
                        <hr class="my-4 md:my-6">
                    @endif

                    <div
                        class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fill,minmax(17.19rem,1fr))]">
                        @foreach ($mutualFunds as $idx => $fund)
                            <livewire:track-investor.mutual-fund-card :fund="$fund"
                                :wire:key="$idx . $fund['fund_symbol']" :hide-if-not-favorite="true" />
                        @endforeach
                    </div>
                @else
                    <div class="text-dark-light2">
                        No result found @if ($search)
                            for search "{{ $search }}"
                        @endif
                    </div>
                @endif
            </div>

            <div class="py-10 grid place-items-center absolute top-0 left-0 w-full" x-show="loading" x-cloak>
                <span class="mx-auto simple-loader !text-green-dark"></span>
            </div>
        </div>
    </div>
</div>