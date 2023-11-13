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

    <div class="mt-6" id="track-ownership-tabs">
        <x-primary-tabs :tabs="['discover' => 'Discover', 'favorite' => 'My Favorites']">
            <x-slot name="head">
                @include('livewire.track-investor.search')
            </x-slot>

            <div x-show="active === 'discover'" x-cloak>
                <livewire:track-investor.discover />
            </div>
    
            <div x-show="active === 'favorite'" x-cloak>
                <livewire:track-investor.favorites />
            </div>
        </x-primary-tabs>
    </div>
</div>
