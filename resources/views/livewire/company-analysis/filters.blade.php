@php
    $periodTypes = [
        'annual' => 'Annual',
        'quarterly' => 'Quarterly',
    ];
    $unitTypes = ['As Stated', 'Thousands', 'Millions', 'Billions'];
    $orderTypes = [
        'ltr' => 'Latest on the Right',
        'ltl' => 'Latest on the Left',
    ];
    $freezePaneTypes = ['Top Row', 'First Column', 'Top Row & First Column'];
@endphp

<div x-data="{
    period: $wire.entangle('period'),
    unit: $wire.entangle('unit'),
    decimalPlaces: $wire.entangle('decimalPlaces'),
    order: $wire.entangle('dateOrder'),
    freezePane: $wire.entangle('freezePane', true),
    init() {
        this.$watch('freezePane', (val) => this.onFreezePaneChange(val));

        this.$watch('decimalPlaces', (val) => {
            window.updateUserSettings({
                decimalPlaces: this.decimalPlaces
            })
        });
    },
    onFreezePaneChange(value) {
        const classes = {
            'Top Row': ['sticky-row'],
            'First Column': ['sticky-column'],
            'Top Row & First Column': ['sticky-row', 'sticky-column']
        }

        const table = this.$el?.closest('.subtab-container').querySelector('.sticky-table');

        if (!table) return;

        table.classList.remove('sticky-column');
        table.classList.remove('sticky-row');

        table.classList.add(...(classes[value] || ''));
    }
}" wire:ignore>
    <x-filter-box>
        <div class="flex items-center gap-x-1">
            <span class="text-sm text-dark-light2">Period Type</span>
            <x-select placeholder="Period Type" :options="$periodTypes" x-model="period"></x-select>
        </div>

        <div class="flex items-center gap-x-1">
            <span class="text-sm text-dark-light2">Unit Type</span>
            <x-select placeholder="Unit Type" :options="$unitTypes" x-model="unit"></x-select>
        </div>

        <div class="flex items-center gap-x-1">
            <span class="text-sm text-dark-light2">Decimal</span>
            <x-select-decimal-places x-model="decimalPlaces"></x-select-decimal-places>
        </div>

        <div class="flex items-center gap-x-1">
            <span class="text-sm text-dark-light2">Order</span>
            <x-select placeholder="Order" :options="$orderTypes" x-model="order"></x-select>
        </div>

        <div class="flex items-center gap-x-1">
            <span class="text-sm text-dark-light2">Freeze Panes</span>
            <x-select placeholder="Freeze Panes" :options="$freezePaneTypes" x-model="freezePane"></x-select>
        </div>
    </x-filter-box>
</div>
