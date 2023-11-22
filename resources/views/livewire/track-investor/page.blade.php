<div x-data @tab-changed="$refs.breadItem1.innerText = $event.detail.title">
    <h2 class="block mb-4 text-xl font-semibold lg:hidden text-blue">Track Investors</h2>

    <x-breadcrumb :items="[
        [
            'text' => 'Track Investors',
        ],
        [
            'text' => 'Discover',
            'href' => '#',
        ],
    ]" />

    <div class="mt-6" id="track-ownership-tabs">
        <livewire:tabs :tabs="$tabs" :ssr="false">
    </div>
</div>
