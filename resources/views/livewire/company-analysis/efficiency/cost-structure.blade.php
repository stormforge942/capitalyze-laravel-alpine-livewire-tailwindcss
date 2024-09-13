<?php $selectedDates = $this->isReverseOrder() ? array_reverse($selectedDates) : $selectedDates; ?>

<div>
    @include('livewire.company-analysis.filters')

    @if (count($dates))
        <div class="my-6" wire:key="{{ $this->rangeSliderKey() }}">
            <x-range-slider :min="explode('-', $dates[0])[0]" :max="explode('-', $dates[count($dates) - 1])[0]" :value="$selectedDateRange"
                @range-updated="$wire.selectedDateRange = $event.detail"></x-range-slider>
        </div>
    @endif

    <div class="mt-6 relative">
        @if (count($dates))
            <x-analysis-chart-box title="Cost Structure" :company="$company" :chart="$chart" :unit="$unit"
                :decimal-places="$decimalPlaces" function="renderCostStructureChart"></x-analysis-chart-box>

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
            >
                <table class="w-full text-right whitespace-nowrap {{ sticky_table_class($freezePane) }}">
                    <thead class="font-sm font-semibold capitalize text-dark">
                        <tr class="font-bold text-base">
                            <th class="pl-8 py-2 text-left bg-[#EDEDED]">
                                Efficiency Analysis
                            </th>

                            @foreach ($selectedDates as $date)
                                <th class="pl-6 py-2 last:pr-8 bg-[#EDEDED]">
                                    {{ $period === 'annual' ? explode('-', $date)[0] : $date }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    @foreach ($data['segments'] as $result)
                        <tbody class="bg-white">
                            <tr class="font-bold border-b border-[#D4DDD7]">
                                <td class="pl-8 py-2 text-left @if (!$loop->first) rounded-tl-lg @endif">
                                    {{ $result['title'] }}
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

                                    <td
                                        class="pl-6 py-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
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
                                             x-cloak x-show="publicView"
                                        >
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
                                    <span class="pl-4">% of Revenues</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 py-1 last:pr-8">
                                        <?php $value = $result['revenue_percentage'][$date]; ?>

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
                                <td class="pl-8 pt-1 pb-2 text-left rounded-bl-lg">
                                    <span class="pl-4">% of Total Expenses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-1 pb-2 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $result['expense_percentage'][$date]; ?>

                                        <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>

                                        <div x-show="publicView">
                                            {!! redIfNegative($value) !!}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>

                        <x-table-spacer></x-table-spacer>
                    @endforeach

                    <tbody class="bg-white font-bold">
                        <tr>
                            <td class="pl-8 pt-2 pb-1 text-left rounded-tl-lg">
                                Total Expenses
                            </td>

                            @foreach ($selectedDates as $date)
                                <?php $value = $data['total_expenses']['timeline'][$date]; ?>
                                <?php $hash =  $data['total_expenses']['hash'][$date]; ?>
                                <?php $sliderData = [
                                    'ticker' => $company['ticker'],
                                    'value' => $value['value'],
                                    'hash' => $hash,
                                    'secondHash' => $data['total_expenses']['secondHash'][$date],
                                    'isLink' => false,
                                    'decimalPlaces' => 3
                                ]; ?>

                                <td class="pl-6 pt-2 pb-1 last:pr-8 last:rounded-tr-lg">
                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        <div x-data="{data: @js($sliderData)}" class="hover:underline cursor-pointer clickable"
                                             @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', { data })"
                                             x-cloak>
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
                                    <?php $value = $data['total_expenses']['yoy_change'][$date]; ?>

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
                            <td class="pl-8 pt-1 pb-2 text-left rounded-bl-lg">
                                <span class="pl-4">% of Revenues</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-1 pb-2 last:pr-8 rounded-br-lg">
                                    <?php $value = $data['total_expenses']['revenue_percentage'][$date]; ?>

                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        {!! redIfNegative($value) !!}
                                    </x-review-number-button>

                                    <div x-show="publicView">
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
                                         x-cloak x-show="publicView">
                                        {!! redIfNegative($value) !!}
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="pl-8 pt-1 pb-2 text-left">
                                <span class="pl-4">% Change YoY</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-1 pb-2 last:pr-8">
                                    <?php $value = $data['revenues']['yoy_change'][$date]; ?>

                                    <x-review-number-button x-show="!publicView" x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        {!! redIfNegative($value) !!}
                                    </x-review-number-button>

                                    <div x-show="publicView">
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
