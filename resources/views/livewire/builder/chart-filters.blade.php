<x-filter-box x-data="{
    period: 'annual',
    unit: 'Millions',
    decimalPlaces: 2,
}">
    <div class="flex items-center gap-x-1">
        <span class="text-sm text-dark-light2">Period Type</span>
        <x-select placeholder="Period Type" :options="['annual' => 'Annual', 'quarter' => 'Quarterly']" x-model="period"></x-select>
    </div>

    <div class="flex-1">
        <x-range-slider :min="2002" :max="date('Y')"></x-range-slider>
    </div>

    <div class="flex items-center gap-x-1">
        <span class="text-sm text-dark-light2">Unit Type</span>
        <x-select placeholder="Unit Type" :options="['As Stated', 'Thousands', 'Millions', 'Billions']" x-model="unit"></x-select>
    </div>

    <div class="flex items-center gap-x-1">
        <span class="text-sm text-dark-light2">Decimal</span>
        <x-select-decimal-places x-model="decimalPlaces"></x-select-decimal-places>
    </div>
</x-filter-box>
