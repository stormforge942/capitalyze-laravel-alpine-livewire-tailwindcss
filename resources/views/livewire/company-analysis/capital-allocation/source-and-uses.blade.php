<?php $selectedDates = $this->isReverseOrder() ? array_reverse($selectedDates) : $selectedDates; ?>

<div x-data="{
    subSubTab: 'sources',
}">
    @include('livewire.company-analysis.filters')

    @if (count($dates))
        <div class="my-6" wire:key="{{ $this->rangeSliderKey() }}">
            <x-range-slider :min="explode('-', $dates[0])[0]" :max="explode('-', $dates[count($dates) - 1])[0]" :value="$selectedDateRange"
                @range-updated="$wire.selectedDateRange = $event.detail"></x-range-slider>
        </div>
    @endif

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
        wire:loading.remove
        class="mt-6 relative"
    >
        @if (count($dates))
            <div class="p-6 bg-white rounded-lg relative">
                <div
                    class="flex items-center w-full max-w-[400px] gap-x-1 border border-[#D4DDD7] rounded bg-gray-light font-medium">
                    <button class="py-2 rounded flex-1 transition border -m-[1px]"
                        :class="subSubTab === 'sources' ? 'bg-[#DCF6EC] border-[#52D3A2]' :
                            'border-transparent hover:border-gray-medium text-gray-medium2'"
                        @click="subSubTab = 'sources'">Sources of cash</button>
                    <button class="py-2 rounded flex-1 transition border -m-[1px]"
                        :class="subSubTab === 'uses' ? 'bg-[#DCF6EC] border-[#52D3A2]' :
                            'border-transparent hover:border-gray-medium text-gray-medium2'"
                        @click="subSubTab = 'uses'">Uses of cash</button>
                </div>

                <div class="mt-6" x-show="subSubTab === 'sources'" x-cloak>
                    <x-analysis-chart-box title="Sources of Cash" :company="$company" :chart="$chart['sources']" :enclosed="true"
                        :unit="$unit" :decimal-places="$decimalPlaces" function="renderSourcesAndUsesChart"></x-analysis-chart-box>
                </div>

                <div class="mt-6" x-show="subSubTab === 'uses'" x-cloak>
                    <x-analysis-chart-box title="Uses of Cash" :company="$company" :chart="$chart['uses']" :enclosed="true"
                        :unit="$unit" :decimal-places="$decimalPlaces"
                        function="renderSourcesAndUsesChart"></x-analysis-chart-box>
                </div>
            </div>

            <div class="mt-6 overflow-auto relative">
                <div class="rounded-lg sticky-table-container" x-show="subSubTab === 'sources'" x-cloak>
                    <table class="w-full text-right whitespace-nowrap {{ sticky_table_class($freezePane) }}">
                        <thead class="font-sm font-semibold capitalize text-dark">
                            <tr class="font-bold text-base">
                                <th class="pl-8 py-2 text-left bg-[#EDEDED]">
                                    Sources Of Cash
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
                                    Levered Free Cash Flow
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['free_cashflow']['timeline'][$date] ?? null; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['free_cashflow'][$date]['hash'] ?? null,
                                        'secondHash' => $formulaHashes['free_cashflow'][$date]['secondHash'] ?? null,
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
                                    <span class="pl-4">% of Total Sources</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['sources']['free_cashflow']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['sources']['formulas']['free_cashflow']['total_percent'][$date] ?? null
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
                                    Total Debt Issued
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['net_debt']['timeline'][$date] ?? null; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['net_debt'][$date]['hash'] ?? null,
                                        'secondHash' => $formulaHashes['net_debt'][$date]['secondHash'] ?? null,
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
                                    <span class="pl-4">% of Total Sources</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['sources']['net_debt']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['sources']['formulas']['net_debt']['total_percent'][$date] ?? null
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
                                    Issuance of Preferred Stock
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['preferred_stock']['timeline'][$date] ?? null; ?>

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
                                    <span class="pl-4">% of Total Sources</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['sources']['preferred_stock']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['sources']['formulas']['preferred_stock']['total_percent'][$date] ?? null
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
                                    Issuance of Common Stock
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['common_stock']['timeline'][$date] ?? null; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['common_stock'][$date]['hash'] ?? null,
                                        'secondHash' => $formulaHashes['common_stock'][$date]['secondHash'] ?? null,
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
                                <td class="pl-8 pt-1 pb-2 text-left">
                                    <span class="pl-4">% of Total Sources</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8">
                                        <?php $value = $data['sources']['common_stock']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['sources']['formulas']['common_stock']['total_percent'][$date] ?? null
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
                                    Total Sources of Cash
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['total']['timeline'][$date] ?? null; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['uses']['formulas']['total']['value'][$date] ?? null
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
                            <tr>
                                <td class="pl-8 pt-1 pb-2 text-left rounded-bl-lg">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $data['sources']['total']['yoy_change'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['sources']['formulas']['total']['yoy_change'][$date] ?? null
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

                <div class="rounded-lg sticky-table-container" x-show="subSubTab === 'uses'" x-cloak>
                    <table class="w-full text-right whitespace-nowrap {{ sticky_table_class($freezePane) }}">
                        <thead class="font-sm font-semibold capitalize text-dark">
                            <tr class="font-bold text-base">
                                <th class="pl-8 py-2 text-left bg-[#EDEDED]">
                                    Uses Of Cash
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
                                    Acquisition
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['acquisition']['timeline'][$date] ?? null; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['acquisition'][$date]['hash'] ?? null,
                                        'secondHash' => $formulaHashes['acquisition'][$date]['secondHash'] ?? null,
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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['uses']['acquisition']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['uses']['formulas']['acquisition']['total_percent'][$date] ?? null
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
                                    Total Debt Repaid
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['debt_repaid']['timeline'][$date] ?? null; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['debt_repaid'][$date]['hash'] ?? null,
                                        'secondHash' => $formulaHashes['debt_repaid'][$date]['secondHash'] ?? null,
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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['uses']['debt_repaid']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['uses']['formulas']['debt_repaid']['total_percent'][$date] ?? null
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
                                    Repurchase of Preferred Stock
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['preferred_repurchase']['timeline'][$date] ?? null; ?>

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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['uses']['preferred_repurchase']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['uses']['formulas']['preferred_repurchase']['total_percent'][$date] ?? null
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
                                    Repurchase of Common Stock
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['common_repurchase']['timeline'][$date] ?? null; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['common_stock'][$date]['hash'] ?? null,
                                        'secondHash' => $formulaHashes['common_stock'][$date]['secondHash'] ?? null,
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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['uses']['common_repurchase']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['uses']['formulas']['common_repurchase']['total_percent'][$date] ?? null
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
                                    Total Dividends Paid
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['dividends']['timeline'][$date] ?? null; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $formulaHashes['dividends'][$date]['hash'] ?? null,
                                        'secondHash' => $formulaHashes['dividends'][$date]['secondHash'] ?? null,
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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data['uses']['dividends']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['uses']['formulas']['dividends']['total_percent'][$date] ?? null
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
                                    Cash Build / Other
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">

                                        <?php $value = $data['uses']['other']['timeline'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['uses']['formulas']['other']['value'][$date] ?? null
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
                                <td class="pl-8 pt-1 pb-2 text-left">
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8">
                                        <?php $value = $data['uses']['other']['total_percent'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['uses']['formulas']['other']['total_percent'][$date] ?? null
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
                                    Total Sources of Cash
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['total']['timeline'][$date] ?? null; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['uses']['formulas']['total']['value'][$date] ?? null
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
                            <tr>
                                <td class="pl-8 pt-1 pb-2 text-left rounded-bl-lg">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $data['uses']['total']['yoy_change'][$date] ?? null; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['uses']['formulas']['total']['yoy_change'][$date] ?? null
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
    </div>
    <div wire:loading class="py-10 w-full">
        <div class="w-full flex justify-center">
            <div class="simple-loader !text-green-dark"></div>
        </div>
    </div>
</div>
