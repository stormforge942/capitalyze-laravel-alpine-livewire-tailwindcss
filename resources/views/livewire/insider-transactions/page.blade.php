<div>
    <div>
        <h1 class="text-xl font-bold">Insider Transactions</h1>
        <p class="mt-2 text-dark-light2">Track all insider transaction activities</p>
    </div>

    <div class="mt-6">
        @include('livewire.insider-transactions.filters')

        <div class="mt-4">
            <livewire:insider-transactions.table :filters="$filters" />
        </div>
    </div>
</div>
