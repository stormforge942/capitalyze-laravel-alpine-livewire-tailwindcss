<div x-data="{
    loading: $wire.entangle('loading', true),
}">
    <div x-show="loading" x-cloak>
        <div class="py-10 grid place-items-center">
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
    </div>

    <div x-show="!loading" x-cloak>
        @if (!count($funds ?? []) && !count($mutualFunds ?? []))
            <div class="text-dark-light2">
                No result found @if ($search)
                    for search "{{ $search }}"
                @endif
            </div>
        @else
            {{-- <livewire:track-investor.favorites-summary :funds="$funds->pluck('investor_name', 'cik')->toArray()" :mutual-funds="$mutualFunds->toArray()" /> --}}

            {{-- <div class="mt-6"> --}}
            <div>
                <h2 class="text-xl font-semibold">My Favorites</h2>

                @include('livewire.track-investor.filters')

                <div class="mt-6">
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
                            <livewire:track-investor.mutual-fund-card :fund="$fund" :wire:key="$idx . $fund['id']"
                                :hide-if-not-favorite="true" />
                        @endforeach
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>
