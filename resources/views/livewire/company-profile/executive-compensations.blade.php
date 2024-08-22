<div x-data="{
    search: $wire.entangle('search').defer,
    year: $wire.entangle('year').defer,

    init() {
        this.$watch('search', value => {
            Livewire.emit('updateExecutiveCompensationTable', this.search, this.year);
        });
        this.$watch('year', value => {
            Livewire.emit('updateExecutiveCompensationTable', this.search, this.year);
        });
    }
}">
    <div class="grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <x-search-filter x-model.debounce.500ms="search" placeholder="Search Position..."
                font-size="base"></x-search-filter>
        </div>
        <div class="col-span-12 lg:col-span-8">
            <x-filter-box>
                <x-select placeholder="Select year" :options="$years" x-model="year"></x-select>
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
