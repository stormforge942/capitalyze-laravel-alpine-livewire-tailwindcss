<div x-data="{
    loading: $wire.entangle('loading', true),
}">
    <h2 class="text-xl font-semibold">Discover Mutual Funds</h2>

    @include('livewire.track-investor.filters')

    <div class="mt-6">
        <div x-show="loading" x-cloak>
            <div class="py-10 grid place-items-center">
                <span class="mx-auto simple-loader !text-green-dark"></span>
            </div>
        </div>

        <div x-show="!loading" x-cloak>
            @if (!count($funds ?? []))
                <div class="text-dark-light2">
                    No funds found @if ($search)
                        for search "{{ $search }}"
                    @endif
                </div>
            @else
                <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fill,minmax(17.19rem,1fr))]">
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
        </div>
    </div>
</div>
