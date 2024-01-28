<?php $selectedDates = $this->isReverseOrder() ? array_reverse($selectedDates) : $selectedDates; ?>

<div x-data="{
    subSubTab: 'book-value',
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
                    <button class="py-2 rounded flex-1 transition"
                        :class="subSubTab === 'book-value' ? 'bg-[#DCF6EC] border border-[#52D3A2] -m-[1px]' : ''"
                        @click="subSubTab = 'book-value'">Book Value</button>
                    <button class="py-2 rounded flex-1"
                        :class="subSubTab === 'market-value' ? 'bg-[#DCF6EC] border border-[#52D3A2] -m-[1px]' : ''"
                        @click="subSubTab = 'market-value'">Market Value</button>
                </div>

                <div class="mt-6" x-show="subSubTab === 'book-value'" x-cloak>
                    <x-analysis-chart-box title="Capital Structure (Book Value)" :enclosed="true" :company="$company"
                        :hasPercentageMix="false" :chart="$chart['book']" :toggle="false"
                        function="renderCapitalStructureChart"></x-analysis-chart-box>
                </div>

                <div class="mt-6" x-show="subSubTab === 'market-value'" x-cloak>
                    <x-analysis-chart-box title="Capital Structure (Market Value)" :enclosed="true" :company="$company"
                        :hasPercentageMix="false" :chart="$chart['market']" :toggle="false"
                        function="renderCapitalStructureChart"></x-analysis-chart-box>
                </div>
            </div>

            <div class="mt-6 overflow-auto">
                <div x-show="subSubTab === 'book-value'" x-cloak>
                    <table class="w-full rounded-lg overflow-hidden text-right whitespace-nowrap">
                        <thead class="font-sm font-semibold capitalize bg-[#EDEDED] text-dark">
                            <tr class="font-bold text-base">
                                <th class="pl-8 py-2 text-left">
                                    Book Value
                                </th>

                                @foreach ($selectedDates as $date)
                                    <th class="pl-6 py-2 last:pr-8">
                                        {{ $period === 'annual' ? explode('-', $date)[0] : $date }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            <tr>
                                <td class="pl-8 pt-4 pb-2 text-left">
                                    Book Value of Common Equity
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['equity']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 pt-4 pb-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['book']['equity']['yoy_change'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['book']['equity']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Total Net Debt
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['net_debt']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 pt-2 pb-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['book']['net_debt']['yoy_change'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['book']['net_debt']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Preferred Equity
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['preferred_equity']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 pt-2 pb-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['book']['preferred_equity']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Minority Interest
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['minority_interest']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 pt-2 pb-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-4 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-4 last:pr-8">
                                        <?php $value = $data['book']['minority_interest']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>

                            <tr class="font-bold border-t border-[#D4DDD7]">
                                <td class="pl-8 pt-4 pb-2 text-left">
                                    Total Capital (Book Value)
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['book']['total_value']['timeline'][$date]; ?>

                                    <td class="pl-6 pt-4 pb-2 last:pr-8">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="font-bold">
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['book']['total_value']['yoy_change'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="font-bold">
                                <td class="pl-8 pt-2 pb-4 text-left rounded-bl-lg">
                                    Net Debt / Capital
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-4 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $data['book']['net_debt_by_capital'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div x-show="subSubTab === 'market-value'" x-cloak>
                    <table class="w-full rounded-lg overflow-hidden text-right whitespace-nowrap">
                        <thead class="font-sm font-semibold capitalize bg-[#EDEDED] text-dark">
                            <tr class="font-bold text-base">
                                <th class="pl-8 py-2 text-left">
                                    Market Value
                                </th>

                                @foreach ($selectedDates as $date)
                                    <th class="pl-6 py-2 last:pr-8">
                                        {{ $period === 'annual' ? explode('-', $date)[0] : $date }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            <tr>
                                <td class="pl-8 pt-4 pb-2 text-left">
                                    Market Value of Equity
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['equity']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 pt-4 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['market']['equity']['yoy_change'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['market']['equity']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Total Net Debt
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['net_debt']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 pt-2 pb-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['market']['net_debt']['yoy_change'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['market']['net_debt']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Preferred Equity
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['preferred_equity']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 pt-2 pb-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['market']['preferred_equity']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Minority Interest
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['minority_interest']['timeline'][$date]; ?>

                                    <td
                                        class="pl-6 pt-2 pb-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-4 text-left">
                                    <span class="pl-4">% of Total Capital</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-4 last:pr-8">
                                        <?php $value = $data['market']['minority_interest']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>

                            <tr class="font-bold border-t border-[#D4DDD7]">
                                <td class="pl-8 pt-4 pb-2 text-left">
                                    Total Enterprise Value
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['market']['total_value']['timeline'][$date]; ?>

                                    <td class="pl-6 pt-4 pb-2 last:pr-8">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="font-bold">
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['market']['total_value']['yoy_change'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="font-bold">
                                <td class="pl-8 pt-2 pb-4 text-left rounded-bl-lg">
                                    Net Debt / Capital
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-4 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $data['market']['net_debt_by_capital'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
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
