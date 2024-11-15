<div x-data="{
    loading: $wire.entangle('loading', true),
}">
    <h2 class="block mb-4 text-xl font-semibold lg:hidden text-blue">Investor Advisers</h2>

    <x-breadcrumb :items="[
        [
            'text' => 'Investor Advisers',
        ],
        [
            'text' => 'Overview',
            'href' => '#',
        ],
    ]" />

    @include('livewire.investor-adviser.filters')

    <div class="mt-6 relative">
        <div class="py-10 grid place-items-center absolute top-0 left-0 w-full" x-show="loading" x-cloak>
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>

        <div :class="loading ? 'invisible' : ''" x-cloak>
            @if ($listStyle === 'list')
                <livewire:investor-adviser.investor-adviser-table :filters="$filters" :views="$views" />
            @else
                @if (!count($advisers ?? []))
                    <div class="text-dark-light2 text-center">
                        No advisers found @if ($search)
                            for search "{{ $search }}"
                        @endif
                    </div>
                @else
                    <div
                        class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fill,minmax(17.19rem,1fr))]">
                        @foreach ($advisers as $adviser)
                            <livewire:investor-adviser.adviser-card :adviser="(array) $adviser" :wire:key="Str::random(5)" />
                        @endforeach
                    </div>

                    @if ($advisers->hasMorePages())
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
