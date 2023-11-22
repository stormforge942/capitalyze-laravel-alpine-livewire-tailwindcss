<div x-data="{ search: $wire.query }" x-init="$watch('search', (val) => $wire.search(val))">
    <div class="hidden lg:flex items-baseline justify-between">
        <h2 class="text-xl font-semibold">Discover Funds</h2>

        @include('livewire.track-investor.search')
    </div>

    <x-tab-slot id="track-ownership-tabs" tab="discover">
        @include('livewire.track-investor.search')
    </x-tab-slot>

    <div class="mt-6">
        <div wire:loading.block wire:target="search">
            <div class="py-10 grid place-items-center">
                <span class="mx-auto simple-loader !text-green-dark"></span>
            </div>
        </div>

        <div wire:loading.remove wire:target="search">
            @if (!count($funds ?? []))
                <div class="text-dark-light2">
                    No funds found @if ($query)
                        for search "{{ $query }}"
                    @endif
                </div>
            @endif

            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fill,minmax(17.19rem,1fr))]">
                @foreach ($funds as $fund)
                    <livewire:track-investor.fund-card :fund="$fund" :wire:key="Str::random(5)" />
                @endforeach
            </div>
        </div>
    </div>

    @if ($funds->hasMorePages())
        <div x-data="{
            loading: false,
            observe() {
                if (this.loading) return;
        
                let observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            $wire.call('loadMore').finally(() => {
                                this.loading = false;
                            });
                        }
                    })
                }, {
                    root: null
                })
                observer.observe(this.$el)
            },
        }" x-init="observe" wire:key="{{ $perPage }}"></div>

        <div class="place-items-center" wire:loading.grid wire:target="loadMore">
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
    @endif
</div>
