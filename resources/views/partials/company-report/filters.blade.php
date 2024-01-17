<div class="py-3 px-4 bg-white rounded-lg border border-[#D4DDD7]">
    <div class="flex flex-wrap gap-4 items-center text-sm">
        <div class="flex items-center gap-x-1" x-show="$wire.activeTab === 'disclosure' && disclosureTab === 'footnotes'"
            x-cloak>
            <span>Footnotes</span>
            <x-select :options="$disclosureFootnotes" placeholder="Footnotes" :searchable="true" :large="true"
                x-model="filters.footnote"></x-select>
        </div>
        <div class="flex items-center gap-x-1"
            x-show="!($wire.activeTab === 'disclosure' && disclosureTab === 'footnotes')" x-cloak>
            <span>View</span>
            <x-select :options="$viewTypes" placeholder="View" x-model="filters.view"></x-select>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Period Type</span>
            <x-select :options="$periodTypes" placeholder="Period Type" x-model="filters.period"></x-select>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Unit Type</span>
            <x-select :options="$unitTypes" placeholder="Unit Type" x-model="filters.unitType"></x-select>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Decimal</span>
            <x-select-decimal-places x-model="filters.decimalPlaces"></x-select-decimal-places>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Order</span>
            <x-select :options="$orderTypes" placeholder="Order" x-model="filters.order"></x-select>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Freeze Panes</span>
            <x-select :options="$freezePaneTypes" placeholder="Freeze Panes" x-model="filters.freezePane"></x-select>
        </div>
    </div>
</div>
