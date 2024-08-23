<div x-data="{
    search: $wire.entangle('search').defer,
    year: $wire.entangle('year').defer,

    init() {
        this.$watch('search', value => {
            this.update();
        });
        this.$watch('year', value => {
            this.update();
        });
    },

    update() {
        Livewire.emit('updateExecutiveCompensationTable', this.search, this.year);
    }
}">
    <div class="grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <x-search-filter x-model.debounce.500ms="search" placeholder="Search Position..."
                font-size="base"></x-search-filter>
        </div>
        <div class="col-span-12 lg:col-span-8">
            <x-filter-box>
                <x-select-digits placeholder="Select year" :options="$years" x-model="year"></x-select>
            </x-filter-box>
        </div>
    </div>

    <div class="mt-4">
        <livewire:company-profile.executive-compensation-table :symbol="$profile['symbol']" :year="$year">
    </div>

    <div class="mt-4">
        <livewire:company-profile.executive-compensation-chart :symbol="$profile['symbol']" :year="$year">
    </div>
</div>
