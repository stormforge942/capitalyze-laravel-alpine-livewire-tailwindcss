<div>
    @include('livewire.ownership.insider-ownership-filters')

    <div class="mt-4">
        <livewire:ownership.insider-ownership-table :ticker="$ticker">
    </div>
</div>