<div>
    <div class="hidden md:flex items-baseline justify-between">
        <h2 class="text-xl font-semibold">My Favorites</h2>

        @include('livewire.track-investor.search')
    </div>

    <x-tab-slot id="track-ownership-tabs" tab="my-favorites">
        @include('livewire.track-investor.search', ['useAlpine' => true, 'event' => 'search:favorites'])
    </x-tab-slot>

    <div class="mt-6">
        <div wire:loading.block wire:target="search, $refresh">
            <div class="py-10 grid place-items-center">
                <span class="mx-auto simple-loader !text-green-dark"></span>
            </div>
        </div>

        <div wire:loading.remove wire:target="search">
            @if (!count($funds ?? []) && !count($mutualFunds ?? []))
                <div class="text-dark-light2">
                    No result found @if ($search)
                        for search "{{ $search }}"
                    @endif
                </div>
            @else
                <div
                    class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fill,minmax(17.19rem,1fr))]">
                    @foreach ($funds as $fund)
                        <livewire:track-investor.fund-card :fund="$fund" :wire:key="$fund['id']"
                            :hide-if-not-favorite="true" />
                    @endforeach
                </div>

                @if (count($funds) && count($mutualFunds))
                    <hr class="my-4 md:my-6">
                @endif

                <div
                    class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fill,minmax(17.19rem,1fr))]">
                    @foreach ($mutualFunds as $fund)
                        <livewire:track-investor.mutual-fund-card :fund="$fund" :wire:key="$fund['id']"
                            :hide-if-not-favorite="true" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
