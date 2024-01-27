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
            <x-analysis-chart-box title="Revenue By Product" :company="$company" :chart="$chart"
                function="renderBasicChart"></x-analysis-chart-box>

            <div class="mt-6 overflow-auto">
                <table class="w-full rounded-lg overflow-hidden text-right whitespace-nowrap">
                    <thead class="font-sm font-semibold capitalize bg-[#EDEDED] text-dark">
                        <tr class="font-bold text-base">
                            <th class="pl-8 py-2 text-left">
                                {{ $company['name'] }} ({{ $company['ticker'] }})
                            </th>

                            @foreach ($selectedDates as $date)
                                <th class="pl-6 py-2 last:pr-8">
                                    {{ $period === 'annual' ? explode('-', $date)[0] : $date }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    @foreach ($data['products'] as $product => $result)
                        <tbody class="bg-white">
                            <tr class="font-bold border-b border-[#D4DDD7]">
                                <td
                                    class="pl-8 pt-4 pb-4 text-left @if (!$loop->first) rounded-tl-lg @endif">
                                    {{ $product }}
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $result['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 pt-4 pb-4 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value, fn($val) => number_format($val)) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-4 pb-2 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-4 pb-2 last:pr-8">
                                        <?php $value = $result['yoy_change'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value, fn($val) => $val . '%') !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-4 text-left rounded-bl-lg">
                                    <span class="pl-4">% of Total</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-4 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $result['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value, fn($val) => $val . '%') !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>

                        {{-- spacer --}}
                        <tbody>
                            <tr>
                                <td class="py-2 bg-transparent"></td>
                            </tr>
                        </tbody>
                    @endforeach

                    <tbody class="bg-white">
                        <tr class="font-bold border-b border-[#D4DDD7]">
                            <td class="pl-8 pt-4 pb-4 text-left rounded-tl-lg">
                                Total Revenues
                            </td>

                            @foreach ($selectedDates as $date)
                                <?php $value = $data['total']['timeline'][$date]; ?>

                                <td class="pl-6 pt-2 pb-4 last:pr-8 last:rounded-tr-lg">
                                    <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        {!! redIfNegative($value, fn($val) => number_format($val)) !!}
                                    </x-review-number-button>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="pl-8 pt-4 pb-4 text-left">
                                <span class="pl-4">% Change YoY</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-2 pb-2 last:pr-8">
                                    <?php $value = $data['total']['yoy_change'][$date]; ?>

                                    <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                        {!! redIfNegative($value, fn($val) => $val . '%') !!}
                                    </x-review-number-button>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <p class="bg-white p-4 text-center font-bold">No data found</p>
        @endif

        <div class="cus-loader" wire:loading.block>
            <div class="cus-loaderBar"></div>
        </div>
    </div>
</div>
