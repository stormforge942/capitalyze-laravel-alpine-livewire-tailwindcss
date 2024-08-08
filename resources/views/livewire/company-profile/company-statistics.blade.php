<div class="columns-2">
    <livewire:company-profile.statistics.key-metrics-table :symbol="$profile['symbol']" :company_name="$profile['registrant_name']" />
    <livewire:company-profile.statistics.short-interest-table :symbol="$profile['symbol']" />
</div>
