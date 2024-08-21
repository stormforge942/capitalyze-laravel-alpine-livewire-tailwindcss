<div x-data="{
    search: @entangle('search'),

    init() {
        this.$watch('search', value => {
            Livewire.emit('updateExecutiveCompensationTable', [], value);
        })
    }
}">
    <div class="col-span-12">
        <x-search-filter x-model.debounce.500ms="search" placeholder="Search Position..."
            font-size="base"></x-search-filter>
    </div>
    <div class="mt-4">
        <livewire:company-profile.executive-compensation-table :symbol="$profile['symbol']">
    </div>
</div>
