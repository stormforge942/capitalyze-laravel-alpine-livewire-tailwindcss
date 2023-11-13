<div x-data @tab-changed="$refs.breadItem1.innerText = $event.detail.title">
    <h2 class="block mb-4 text-xl font-semibold lg:hidden text-blue">Track Investors</h2>

    <x-breadcrumb :items="[
        [
            'text' => 'Track Investors',
        ],
        [
            'text' => 'Discover',
            'href' => route('company.track-investor', 'AAPL'),
        ],
    ]" />

    <x-primary-tabs class="mt-6" :tabs="['discover' => 'Discover', 'favorite' => 'My Favorites']">
        <x-slot name="head">
            @include('livewire.track-investor.search')
        </x-slot>
        
        <template x-if="active == 'discover'">
            Hello wold
        </template>

        <template x-if="active === 'favorite'">
            Hello wold2
        </template>
    </x-primary-tabs>
</div>
