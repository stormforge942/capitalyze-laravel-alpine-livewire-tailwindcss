<div>
    <div class="hidden lg:flex items-baseline justify-between">
        <h2 class="text-xl font-semibold">Discover Funds</h2>
    </div>

    <div class="mt-6 grid gap-2 grid-cols-12 items-center">
        <div class="col-span-4">
            <x-search-filter wire:model.debounce.800ms="search" />
        </div>

        <div class="col-span-8">
            <x-filter-box>
                <x-select-number-range label="Market Value" longLabel="Market Value (in millions)"></x-select-number-range>

                <x-select-number-range label="Turnover" longLabel="Turnover (in millions)"></x-select-number-range>
                
                <x-select-number-range label="Number of Holdings"></x-select-number-range>
            </x-filter-box>
        </div>
    </div>

    <div class="mt-6">
        <div wire:loading.block wire:target="search, runSearch">
            <div class="py-10 grid place-items-center">
                <span class="mx-auto simple-loader !text-green-dark"></span>
            </div>
        </div>

        <div wire:loading.remove wire:target="search, runSearch">
            @if (!count($funds ?? []))
                <div class="text-dark-light2">
                    No funds found @if ($search)
                        for search "{{ $search }}"
                    @endif
                </div>
            @else
                <div
                    class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fill,minmax(17.19rem,1fr))]">
                    @foreach ($funds as $fund)
                        <livewire:track-investor.fund-card :fund="$fund" :wire:key="Str::random(5)" />
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
        </div>
    </div>
</div>
