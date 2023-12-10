<div class="py-3 px-4 bg-white rounded-lg border border-[#D4DDD7]" x-data="{
    view: $wire.entangle('view'),
    period: $wire.entangle('period'),
    unitType: $wire.entangle('unitType'),
    decimalDisplay: $wire.entangle('decimalDisplay'),
    order: $wire.entangle('order'),
    freezePane: '',
}">
    <div class="flex flex-wrap gap-4 items-center text-sm">
        <div class="flex items-center gap-x-1">
            <span>View</span>
            <x-select :options="$viewTypes" placeholder="View" x-model="view"></x-select>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Period Type</span>
            <x-select :options="$periodTypes" placeholder="Period Type" x-model="period"></x-select>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Unit Type</span>
            <x-select :options="$unitTypes" placeholder="Unit Type" x-model="unitType"></x-select>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Decimal</span>
            <x-select :options="$decimalTypes" placeholder="Decimal" x-model="decimalDisplay"></x-select>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Order</span>
            <x-select :options="$orderTypes" placeholder="Order" x-model="order"></x-select>
        </div>
        <div class="flex items-center gap-x-1">
            <span>Freeze Panes</span>
            <x-select :options="$freezePaneTypes" placeholder="Freeze Panes" x-model="freezePane"></x-select>
        </div>
    </div>
</div>
