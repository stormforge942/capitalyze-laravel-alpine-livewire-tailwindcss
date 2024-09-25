<?php $selectedDates = $this->isReverseOrder() ? array_reverse($selectedDates) : $selectedDates; ?>

<div>
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
        class="mt-6 relative"
    >
        @if (count($dates))
            <x-analysis-chart-box title="Free Cash Flow Before WC" :company="$company" :hasPercentageMix="false" :chart="$chart"
                :unit="$unit" :decimal-places="$decimalPlaces" function="renderFcfConversionChart"></x-analysis-chart-box>

            <div class="mt-6 rounded-lg sticky-table-container">
                <table class="w-full text-right whitespace-nowrap {{ sticky_table_class($freezePane) }}">
                    <thead class="font-sm font-semibold capitalize text-dark">
                        <tr class="font-bold text-base">
                            <th class="pl-8 py-2 text-left bg-[#EDEDED]">
                                FCF Conversion
                            </th>

                            @foreach ($selectedDates as $date)
                                <th class="pl-6 py-2 last:pr-8 bg-[#EDEDED]">
                                    {{ $period === 'annual' ? explode('-', $date)[0] : $date }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        <tr class="font-bold">
                            <td class="pl-8 pt-2 pb-1 text-left">
                                Revenues
                            </td>
                            @foreach ($selectedDates as $date)
                                <?php $value = $data['revenues']['timeline'][$date]; ?>
                                <?php $hash = $data['revenues']['hash'][$date]; ?>
                                <?php $sliderData = [
                                    'ticker' => $company['ticker'],
                                    'value' => $value['value'],
                                    'hash' => $hash,
                                    'secondHash' => $data['revenues']['secondHash'][$date],
                                    'isLink' => false,
                                    'decimalPlaces' => 3
                                    ];
                                ?>

                                <td
                                    class="pl-6 pt-2 pb-1 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        {!! redIfNegative($value) !!}
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
                            <td class="pl-8 pt-1 pb-2 text-left rounded-bl-lg">
                                <span class="pl-4">% Change YoY</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                    <?php $value = $data['revenues']['yoy_change'][$date]; ?>
                                    <?php $hash = $data['revenues']['hash'][$date]; ?>
                                    <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => $hash,
                                            'secondHash' => $data['revenues']['secondHash'][$date],
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['revenues']['formulas']['yoy_change'][$date]
                                        ];
                                    ?>

                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="!publicView">
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

                    <tbody class="bg-white">
                        <tr class="font-bold border-b border-[#D4DDD7]">
                            <td class="pl-8 py-2 text-left rounded-tl-lg">
                                EBITDA
                            </td>

                            @foreach ($selectedDates as $date)
                                <?php $value = $data['ebitda']['timeline'][$date]; ?>
                                <?php $hash = $data['ebitda']['hash'][$date]; ?>
                                <?php $sliderData = [
                                    'ticker' => $company['ticker'],
                                    'value' => $value['value'],
                                    'hash' => $hash,
                                    'secondHash' => $data['ebitda']['secondHash'][$date],
                                    'isLink' => false,
                                    'decimalPlaces' => 3
                                    ];
                                ?>

                                <td class="pl-6 pt-2 last:pr-8 last:rounded-tr-lg">
                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                             x-cloak
                                        >
                                            {!! redIfNegative($value) !!}
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
                                    <?php $value = $data['ebitda']['yoy_change'][$date]; ?>
                                    <?php $hash = $data['ebitda']['hash'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $hash,
                                        'secondHash' => $data['ebitda']['secondHash'][$date],
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['ebitda']['formulas']['yoy_change'][$date]
                                    ];
                                    ?>

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
                                <span class="pl-4">% EBITDA Margins</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 py-1 last:pr-8">
                                    <?php $value = $data['ebitda']['margin'][$date]; ?>
                                    <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => $hash,
                                            'secondHash' => $data['ebitda']['secondHash'][$date],
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['ebitda']['formulas']['margin'][$date]
                                        ];
                                    ?>

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

                        <?php
                        $child = [
                            'cash_interest' => 'Cash Interest',
                            'cash_taxes' => 'Cash Taxes',
                            'capital_expenditures' => 'Capital Expenditures',
                        ];
                        ?>

                        @foreach ($child as $key => $name)
                            <tr>
                                <td class="pl-8 py-1 text-left">
                                    {{ $name }}
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data[$key]['timeline'][$date]; ?>
                                        <?php $hash = $data[$key]['hash'][$date]; ?>
                                        <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => $hash,
                                            'secondHash' => $data[$key]['secondHash'][$date],
                                            'isLink' => false,
                                            'decimalPlaces' => 3
                                        ];
                                        ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                                 x-cloak
                                            >
                                                {!! redIfNegative($value) !!}
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
                                        <?php $value = $data[$key]['yoy_change'][$date]; ?>
                                        <?php $hash = $data[$key]['hash'][$date]; ?>
                                        <?php $sliderData = [
                                                'ticker' => $company['ticker'],
                                                'value' => $value['value'],
                                                'hash' => $hash,
                                                'secondHash' => $data[$key]['secondHash'][$date],
                                                'isLink' => false,
                                                'decimalPlaces' => 3,
                                                'formulaPreset' => $data[$key]['formulas']['yoy_change'][$date]
                                            ];
                                        ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak x-show="!publicView">
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
                                    <span class="pl-4">% of EBITDA</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $data[$key]['ebitda_percentage'][$date]; ?>
                                        <?php $sliderData = [
                                                'ticker' => $company['ticker'],
                                                'value' => $value['value'],
                                                'hash' => null,
                                                'secondHash' => null,
                                                'isLink' => false,
                                                'decimalPlaces' => 3,
                                                'formulaPreset' => $data[$key]['formulas']['ebitda_percentage'][$date]
                                            ];
                                        ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                                 @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                                 x-cloak x-show="!publicView">
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
                        @endforeach
                        <tr>
                            <td class="pl-8 pt-1 pb-2 text-left rounded-bl-lg">
                                <span class="pl-4">% of Revenues</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                    <?php $value = $data[$key]['revenue_percentage'][$date]; ?>
                                    <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => $hash,
                                            'secondHash' => null,
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data[$key]['formulas']['of_total_revenue'][$date]
                                        ];
                                    ?>

                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="!publicView">
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

                    <tbody class="bg-white font-bold">
                        <tr>
                            <td class="pl-8 pt-2 pb-1 text-left rounded-tl-lg">
                                Free Cash Flow before WC
                            </td>

                            @foreach ($selectedDates as $date)
                                <?php $value = $data['free_cashflow']['timeline'][$date]; ?>
                                <?php $sliderData = [
                                    'ticker' => $company['ticker'],
                                    'value' => $value['value'],
                                    'hash' => null,
                                    'secondHash' => null,
                                    'isLink' => false,
                                    'decimalPlaces' => 3,
                                    'formulaPreset' => $data['free_cashflow']['formulas']['free_cashflow'][$date]
                                ];
                                ?>

                                <td class="pl-6 pt-2 pb-1 last:pr-8 last:rounded-tr-lg">
                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="!publicView">
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
                                    <?php $value = $data['free_cashflow']['yoy_change'][$date]; ?>
                                    <?php $hash = $data[$key]['hash'][$date]; ?>
                                    <?php $sliderData = [
                                            'ticker' => $company['ticker'],
                                            'value' => $value['value'],
                                            'hash' => $hash,
                                            'secondHash' => $data[$key]['secondHash'][$date],
                                            'isLink' => false,
                                            'decimalPlaces' => 3,
                                            'formulaPreset' => $data['free_cashflow']['formulas']['yoy_change'][$date]
                                        ];
                                    ?>

                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="!publicView">
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
                                <span class="pl-4">% of EBITDA</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 py-1 last:pr-8">
                                    <?php $value = $data['free_cashflow']['ebitda_percentage'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['free_cashflow']['formulas']['ebitda_percentage'][$date]
                                    ];
                                    ?>

                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="!publicView">
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
                                <span class="pl-4">% of Revenues</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                    <?php $value = $data['free_cashflow']['revenue_percentage'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['free_cashflow']['formulas']['of_total_revenue'][$date]
                                    ];
                                    ?>

                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        <div x-data="{data: @js($sliderData), preset: true}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data, preset })"
                                             x-cloak x-show="!publicView">
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

                    <tbody class="bg-white">
                        <tr>
                            <td class="pl-8 pt-2 pb-1 text-left rounded-tl-lg">
                                Changes in Net WC
                            </td>

                            @foreach ($selectedDates as $date)
                                <?php $value = $data['networth_change']['timeline'][$date]; ?>
                                <?php $hash = $data['networth_change']['hash'][$date]; ?>
                                <?php $sliderData = [
                                    'ticker' => $company['ticker'],
                                    'value' => $value['value'],
                                    'hash' => $hash,
                                    'secondHash' => $data['networth_change']['secondHash'][$date],
                                    'isLink' => false,
                                    'decimalPlaces' => 3
                                ]; ?>

                                <td class="pl-6 pt-2 pb-1 last:pr-8 last:rounded-tr-lg">
                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                             x-cloak
                                        >
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </x-review-number-button>

                                    <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                         @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                         x-cloak
                                         x-show="publicView"
                                    >
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
                                    <?php $value = $data['networth_change']['yoy_change'][$date]; ?>
                                    <?php $hash = $data['networth_change']['hash'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $hash,
                                        'secondHash' => $data['networth_change']['secondHash'][$date],
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['networth_change']['formulas']['yoy_change'][$date]
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
                                <span class="pl-4">% of EBITDA</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 py-1 last:pr-8">
                                    <?php $value = $data['networth_change']['ebitda_percentage'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['networth_change']['formulas']['ebitda_percentage'][$date]
                                    ];
                                    ?>

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
                                <span class="pl-4">% of Revenues</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                    <?php $value = $data['networth_change']['revenue_percentage'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['networth_change']['formulas']['revenue_percentage'][$date]
                                    ];
                                    ?>

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

                    <tbody class="bg-white font-bold">
                        <tr>
                            <td class="pl-8 pt-2 pb-1 text-left rounded-tl-lg">
                                Levered Free Cash Flow
                            </td>

                            @foreach ($selectedDates as $date)
                                <?php $value = $data['levered_free_cashflow']['timeline'][$date]; ?>
                                <?php $sliderData = [
                                    'ticker' => $company['ticker'],
                                    'value' => $value['value'],
                                    'hash' => $hash,
                                    'secondHash' => null,
                                    'isLink' => false,
                                    'decimalPlaces' => 3,
                                    'formulaPreset' => $data['levered_free_cashflow']['formulas']['levered_free_cashflow'][$date]
                                ]; ?>

                                <td class="pl-6 pt-2 pb-1 last:pr-8 last:rounded-tr-lg">
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
                                    <?php $value = $data['levered_free_cashflow']['yoy_change'][$date]; ?>
                                    <?php $hash = $data['networth_change']['hash'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $hash,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['levered_free_cashflow']['formulas']['yoy_change'][$date]
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
                                <span class="pl-4">% of EBITDA</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 py-1 last:pr-8">
                                    <?php $value = $data['levered_free_cashflow']['ebitda_percentage'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => null,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['levered_free_cashflow']['formulas']['ebitda_percentage'][$date]
                                    ];
                                    ?>

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
                                <span class="pl-4">% LFCF Margins</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-1 pb-2 last:pr-8">
                                    <?php $value = $data['levered_free_cashflow']['margin'][$date]; ?>
                                    <?php $sliderData = [
                                        'ticker' => $company['ticker'],
                                        'value' => $value['value'],
                                        'hash' => $hash,
                                        'secondHash' => null,
                                        'isLink' => false,
                                        'decimalPlaces' => 3,
                                        'formulaPreset' => $data['levered_free_cashflow']['formulas']['lcf_margin'][$date]
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
            <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-1/2 md:mx-auto">
                No data available
            </div>
        @endif

        <div class="cus-loader" wire:loading.block>
            <div class="cus-loaderBar"></div>
        </div>
    </div>
</div>
