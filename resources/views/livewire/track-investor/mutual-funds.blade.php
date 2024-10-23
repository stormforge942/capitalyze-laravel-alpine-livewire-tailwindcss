<div x-data="{
    loading: $wire.entangle('loading', true),
    showingRss: false,
}" @toggle-rss.window = "showingRss = !showingRss;">
    <h2 class="text-xl font-semibold">Discover Mutual Funds</h2>

    @include('livewire.track-investor.filters')

    <div class="mt-6 relative" x-show="showingRss" x-data="{
        search: $wire.entangle('search'),
        view: $wire.entangle('view'),

        init() {
            ['search', 'view'].map(propName => this.$watch(propName, (val) => {
                Livewire.emit('filtersChanged', {
                    search: this.search,
                    view: this.view,
                });
            }));
        }
    }">
        <livewire:track-investor.mutual-fund-feed-table :filters="$filters" :views="$views" />
    </div>

    <div class="mt-6 relative" x-show="! showingRss">
        <div class="py-10 grid place-items-center absolute top-0 left-0 w-full" x-show="loading" x-cloak>
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>

        <div :class="loading ? 'invisible' : ''" x-cloak>
            @if ($listStyle === 'list')
                <div>
                    <livewire:track-investor.listing-table type="mutual-funds" :filters="$filters" :views="$views" :wire:key="\Str::random(5)" />
                </div>
            @else
                @if (!count($funds ?? []))
                    <div class="text-dark-light2 text-center">
                        No funds found @if ($search)
                            for search "{{ $search }}"
                        @endif
                    </div>
                @else
                    <div
                        class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fill,minmax(17.19rem,1fr))]">
                        @foreach ($funds as $fund)
                            <livewire:track-investor.mutual-fund-card :fund="$fund" :wire:key="Str::random(5)" />
                        @endforeach
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
                @endif
            @endif
        </div>
    </div>
</div>
