<?php $selectedDates = $this->isReverseOrder() ? array_reverse($selectedDates) : $selectedDates; ?>

<div x-data="{
    subSubTab: 'market-value',
}">
    @include('livewire.company-analysis.filters')

    @if (count($dates))
        <div class="my-6" wire:key="{{ $this->rangeSliderKey() }}">
            <x-range-slider :min="explode('-', $dates[0])[0]" :max="explode('-', $dates[count($dates) - 1])[0]" :value="$selectedDateRange"
                @range-updated="$wire.selectedDateRange = $event.detail"></x-range-slider>
        </div>
    @endif

    <div class="mt-6 relative">
        @if (count($dates))
            <div class="p-6 bg-white rounded-lg relative">
                <div
                    class="flex items-center w-full max-w-[400px] gap-x-1 border border-[#D4DDD7] rounded bg-gray-light font-medium">
                    <button class="py-2 rounded flex-1 transition border -m-[1px]"
                        :class="subSubTab === 'market-value' ? 'bg-[#DCF6EC] border-[#52D3A2]' :
                            'border-transparent hover:border-gray-medium text-gray-medium2'"
                        @click="subSubTab = 'market-value'">Market Value</button>

                    <button class="py-2 rounded flex-1 transition border -m-[1px]"
                        :class="subSubTab === 'book-value' ? 'bg-[#DCF6EC] border-[#52D3A2]' :
                            'border-transparent hover:border-gray-medium text-gray-medium2'"
                        @click="subSubTab = 'book-value'">Book Value</button>
                </div>

                <div class="mt-6" x-show="subSubTab === 'book-value'" x-cloak>
                    <x-analysis-chart-box title="Capital Structure (Book Value)" :enclosed="true" :company="$company"
                        :unit="$unit" :decimal-places="$decimalPlaces" :hasPercentageMix="false" :chart="$chart['book']"
                        function="renderCapitalStructureChart"></x-analysis-chart-box>
                </div>

                <div class="mt-6" x-show="subSubTab === 'market-value'" x-cloak>
                    <x-analysis-chart-box title="Capital Structure (Market Value)" :enclosed="true" :company="$company"
                        :unit="$unit" :decimal-places="$decimalPlaces" :hasPercentageMix="false" :chart="$chart['market']"
                        function="renderCapitalStructureChart"></x-analysis-chart-box>
                </div>
            </div>

            <div
                x-data="{
                    publicView: $wire.entangle('publicView', false),
                    init() {
                        this.$watch('publicView', () => {
                            window.updateUserSettings({
                                publicView: this.publicView
                            })
                        })
                    }
                }"
                class="mt-6 overflow-auto"
            >
                <div class="rounded-lg sticky-table-container" x-show="subSubTab === 'book-value'" x-cloak>
                    <table class="w-full text-right whitespace-nowrap {{ sticky_table_class($freezePane) }}">
                        <thead class="font-sm font-semibold capitalize text-dark">
                            <tr class="font-bold text-base">
                                <th class="pl-8 py-2 text-left bg-[#EDEDED]">
                                    Book Value
                                </th>

                                @foreach ($selectedDates as $date)
                                    <th class="pl-6 py-2 last:pr-8 bg-[#EDEDED]">
                                        {{ $period === 'annual' ? explode('-', $date)[0] : $date }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            <tr>
                                <td class="pl-8 pt-2 pb-1 text-left">
                                    Book Value of Common Equity
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['equity']['timeline'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['total_equity'][$date]['hash'],
                                        'secondHash' => $formulaHashes['total_equity'][$date]['secondHash'],
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                    ]; ?>

                                    <td
                                        class="pl-6 pt-2 pb-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                                 x-cloak x-show="!publicView">
                                                {!! redIfNegative($value, fn($val) => number_format($val)) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['book']['equity']['yoy_change'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['book']['formulas']['equity']['yoy_change'][$date]  ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['book']['equity']['total_percent'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['book']['formulas']['equity']['total_percent'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    Total Net Debt
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['net_debt']['timeline'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['net_debt'][$date]['hash'],
                                        'secondHash' => $formulaHashes['net_debt'][$date]['secondHash'],
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                    ]; ?>

                                    <td
                                        class="pl-6 py-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                                 x-cloak x-show="!publicView">
                                                {!! redIfNegative($value, fn($val) => number_format($val)) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['book']['net_debt']['yoy_change'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['book']['formulas']['net_debt']['yoy_change'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['book']['net_debt']['total_percent'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['book']['formulas']['net_debt']['total_percent'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    Preferred Equity
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['preferred_equity']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 py-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>

                                        <div x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['book']['preferred_equity']['total_percent'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['book']['formulas']['preferred_equity']['total_percent'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    Minority Interest
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['minority_interest']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 py-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>

                                        <div x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-1 pb-2 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8">
                                        <?php $value = $data['book']['minority_interest']['total_percent'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['book']['formulas']['minority_interest']['total_percent'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>

                            <tr class="font-bold border-t border-[#D4DDD7]">
                                <td class="pl-8 pt-2 pb-1 text-left">
                                    Total Capital (Book Value)
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['total_value']['timeline'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['book']['formulas']['total_value']['value'][$date] ?? null
                                    ]; ?>

                                    <td class="pl-6 pt-2 pb-1 last:pr-8">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="font-bold">
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['book']['total_value']['yoy_change'][$date]; ?>
                                            <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['book']['formulas']['total_value']['yoy_change'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="font-bold">
                                <td class="pl-8 pt-1 pb-2 text-left rounded-bl-lg">
                                    Net Debt / Capital
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $data['book']['net_debt_by_capital'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['book']['formulas']['net_debt_by_capital'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="rounded-lg sticky-table-container" x-show="subSubTab === 'market-value'" x-cloak>
                    <table class="w-full text-right whitespace-nowrap {{ sticky_table_class($freezePane) }}">
                        <thead class="font-sm font-semibold capitalize text-dark">
                            <tr class="font-bold text-base">
                                <th class="pl-8 py-2 text-left bg-[#EDEDED]">
                                    Market Value
                                </th>

                                @foreach ($selectedDates as $date)
                                    <th class="pl-6 py-2 last:pr-8 bg-[#EDEDED]">
                                        {{ $period === 'annual' ? explode('-', $date)[0] : $date }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            <tr>
                                <td class="pl-8 pt-2 pb-1 text-left">
                                    Market Value of Equity
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['equity']['timeline'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimals' => 2,
                                        'formulaPreset' => $data['market']['formulas']['equity']['market_value_of_equity'][$date] ?? null
                                    ]; ?>

                                    <td
                                        class="pl-6 pt-2 pb-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['market']['equity']['yoy_change'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['market']['formulas']['equity']['yoy_change'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['market']['equity']['total_percent'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['market']['formulas']['equity']['total_percent'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    Total Net Debt
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['net_debt']['timeline'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['net_debt'][$date]['hash'],
                                        'secondHash' => $formulaHashes['net_debt'][$date]['secondHash'],
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                    ]; ?>

                                    <td
                                        class="pl-6 py-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                                 x-cloak x-show="!publicView">
                                                {!! redIfNegative($value, fn($val) => number_format($val)) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['market']['net_debt']['yoy_change'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['market']['formulas']['net_debt']['yoy_change'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['market']['net_debt']['total_percent'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['market']['formulas']['net_debt']['total_percent'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    Preferred Equity
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['preferred_equity']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 py-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>

                                        <div x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['market']['preferred_equity']['total_percent'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['market']['formulas']['preferred_equity']['total_percent'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    Minority Interest
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['minority_interest']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 py-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>

                                        <div x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-1 pb-2 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8">
                                        <?php $value = $data['market']['minority_interest']['total_percent'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['market']['formulas']['minority_interest']['total_percent'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>

                            <tr class="font-bold border-t border-[#D4DDD7]">
                                <td class="pl-8 pt-2 pb-1 text-left">
                                    Total Enterprise Value
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['total_value']['timeline'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimals' => 2,
                                        'formulaPreset' => $data['market']['formulas']['total_value']['value'][$date] ?? null
                                    ]; ?>

                                    <td class="pl-6 pt-2 pb-1 last:pr-8">
                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="font-bold">
                                <td class="pl-8 py-1 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['market']['total_value']['yoy_change'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['market']['formulas']['total_value']['yoy_change'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="font-bold">
                                <td class="pl-8 pt-1 pb-2 text-left rounded-bl-lg">
                                    Net Debt / Capital
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $data['market']['net_debt_by_capital'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['market']['formulas']['net_debt_by_capital'][$date] ?? null
                                        ]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak>
                                                {!! redIfNegative($value) !!}
                                            </div>
                                        </x-review-number-button>

                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-1/2 md:mx-auto">
                No data available
            </div>
        @endif

        <div class="cus-loader" wire:loading.block>
            <div class="cus-loaderBar"></div>
        </div>
    </div>
</div>
