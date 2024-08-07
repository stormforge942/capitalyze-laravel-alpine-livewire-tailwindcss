<div class="grid grid-cols-12 items-end gap-2 mb-2" x-data="{
    filters: {
        search: '{{ data_get($filters, 'search') }}',
    },
    init() {
        this.$watch('filters', (value) => {
            window.Livewire.emit('filterOwnershipProxyStatementTable', value);

            let url = new URL(window.location.href);
            url.searchParams.set('search', value.search);

            window.history.replaceState({}, '', url);
        }, { deep: true });
    },
}">
    <div class="col-span-12">
        <x-search-filter x-model.debounce.500ms="filters.search" placeholder="Search Company Name..."
            font-size="base"></x-search-filter>
    </div>
</div>
