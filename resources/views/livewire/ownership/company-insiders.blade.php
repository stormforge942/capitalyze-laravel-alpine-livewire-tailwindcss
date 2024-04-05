<div>
    @include('livewire.insider-transactions.filters')

    <div class="mt-4">
        <livewire:ownership.company-insiders-table :ticker="$ticker" />
    </div>
</div>
