<?php $selectedDates = $this->isReverseOrder() ? array_reverse($selectedDates) : $selectedDates; ?>

<div>
    @include('livewire.company-analysis.filters')

    @if (count($dates))
        <div class="my-6" wire:key="{{ $this->rangeSliderKey() }}">
            <x-range-slider :min="explode('-', $dates[0])[0]" :max="explode('-', $dates[count($dates) - 1])[0]" :value="$selectedDateRange"
                @range-updated="$wire.selectedDateRange = $event.detail"></x-range-slider>
        </div>
    @endif

    <div wire:loading.remove class="mt-6 relative">
        @if (count($dates))
            <x-analysis-chart-box title="Revenue By Product" :company="$company" :chart="$chart" :unit="$unit"
                :decimal-places="$decimalPlaces" function="renderBasicChart"></x-analysis-chart-box>

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
                class="mt-6 rounded-lg sticky-table-container"
                wire:loading.remove
            >
                <table class="w-full text-right whitespace-nowrap {{ sticky_table_class($freezePane) }}">
                    <thead class="font-sm font-semibold capitalize text-dark">
                        <tr class="font-bold text-base">
                            <th class="pl-8 py-2 text-left bg-[#EDEDED]">
                                {{ $company['name'] }} ({{ $company['ticker'] }})
                            </th>

                            @foreach ($selectedDates as $date)
                                <th class="pl-6 py-2 last:pr-8 bg-[#EDEDED]">
                                    {{ $period === 'annual' ? explode('-', $date)[0] : $date }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    @foreach ($data['products'] as $product => $result)
                        <tbody class="bg-white">
                            <tr class="font-bold border-b border-[#D4DDD7]">
                                <td
                                    class="pl-8 pt-2 pb-2 text-left @if (!$loop->first) rounded-tl-lg @endif">
                                    {{ $product }}
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $result['timeline'][$date]; ?>
                                    <?php $hash = $result['hash'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $hash,
                                        'secondHash' => $result['secondHash'][$date],
                                        'isLink' => false,
                                        'decimalPlaces' => 3
                                    ]; ?>

                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
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
                                <td class="pl-8 pt-2 pb-1 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-1 last:pr-8">
                                        <?php $value = $result['yoy_change'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $result['formulas']['yoy_change'][$date]
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
                                <td class="pl-8 pt-1 pb-2 text-left rounded-bl-lg">
                                    <span class="pl-4">% of Total</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $result['total_percent'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => null,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $result['formulas']['total_percent'][$date]
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

                        <x-table-spacer></x-table-spacer>
                    @endforeach

                    <tbody class="bg-white">
                        <tr class="font-bold border-b border-[#D4DDD7]">
                            <td class="pl-8 pt-2 pb-2 text-left rounded-tl-lg">
                                Total Revenues
                            </td>

                            @foreach ($selectedDates as $date)
                                <?php $value = $data['total']['timeline'][$date]; ?>
                                <?php $hash = $result['hash'][$date]; ?>
                                <?php $sliderData = [
                                    'ticker' => $company['ticker'],
                                    'value' =>$value['value'],
                                    'hash' => $hash,
                                    'secondHash' => $result['secondHash'][$date],
                                    'isLink' => false,
                                    'decimalPlaces' => 3
                                ]; ?>

                                <td class="pl-6 pt-2 pb-2 last:pr-8 last:rounded-tr-lg">
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
                            <td class="pl-8 pt-2 pb-2 text-left">
                                <span class="pl-4">% Change YoY</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-2 pb-2 last:pr-8">
                                    <?php $value = $data['total']['yoy_change'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['total']['formulas'][$date]
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
        @else
            <p class="bg-white p-4 text-center font-bold">No data found</p>
        @endif
    </div>
    <div wire:loading class="py-10 w-full">
        <div class="w-full flex justify-center">
            <div class="simple-loader !text-green-dark"></div>
        </div>
    </div>
</div>
