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

    <div class="mt-6 relative">
        @if (count($dates))
            <div class="p-6 bg-white rounded-lg relative">
                <div
                    class="flex items-center w-full max-w-[400px] gap-x-1 border border-[#D4DDD7] rounded bg-gray-light font-medium">
                    <button class="py-2 rounded flex-1 transition"
                        :class="subSubTab === 'sources' ? 'bg-[#DCF6EC] border border-[#52D3A2] -m-[1px]' : ''"
                        @click="subSubTab = 'sources'">Sources of cash</button>
                    <button class="py-2 rounded flex-1"
                        :class="subSubTab === 'uses' ? 'bg-[#DCF6EC] border border-[#52D3A2] -m-[1px]' : ''"
                        @click="subSubTab = 'uses'">Uses of cash</button>
                </div>

                <div class="mt-6" x-show="subSubTab === 'sources'" x-cloak>
                    <x-analysis-chart-box title="Sources of Cash" :company="$company" :chart="$chart['sources']" :enclosed="true"
                        function="renderSourcesAndUsesChart"></x-analysis-chart-box>
                </div>

                <div class="mt-6" x-show="subSubTab === 'uses'" x-cloak>
                    <x-analysis-chart-box title="Uses of Cash" :company="$company" :chart="$chart['uses']" :enclosed="true"
                        function="renderSourcesAndUsesChart"></x-analysis-chart-box>
                </div>
            </div>

            <div class="mt-6 overflow-auto relative">
                <div class="mt-6 rounded-lg sticky-table-container" x-show="subSubTab === 'sources'" x-cloak>
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
                                <td class="pl-8 pt-4 pb-2 text-left">
                                    Levered Free Cash Flow
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['free_cashflow']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Sources</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['sources']['free_cashflow']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Total Debt Issued
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['net_debt']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Sources</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['sources']['net_debt']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Issuance of Preferred Stock
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['preferred_stock']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Sources</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['sources']['preferred_stock']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Issuance of Common Stock
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['common_stock']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Sources</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-4 last:pr-8">
                                        <?php $value = $data['sources']['common_stock']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>

                            <tr class="font-bold border-t border-[#D4DDD7]">
                                <td class="pl-8 pt-4 pb-2 text-left">
                                    Total Sources of Cash
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['sources']['total']['timeline'][$date]; ?>

                                    <td class="pl-6 pt-4 pb-2 last:pr-8">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-4 text-left rounded-bl-lg">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-4 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $data['sources']['total']['yoy_change'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 rounded-lg sticky-table-container" x-show="subSubTab === 'uses'" x-cloak>
                    <table class="w-full text-right whitespace-nowrap {{ sticky_table_class($freezePane) }}">
                        <thead class="font-sm font-semibold capitalize text-dark">
                            <tr class="font-bold text-base bg-[#EDEDED]">
                                <th class="pl-8 py-2 text-left">
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
                                <td class="pl-8 pt-4 pb-2 text-left">
                                    Acquisition
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['acquisition']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['uses']['acquisition']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Total Debt Repaid
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['debt_repaid']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['uses']['debt_repaid']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Repurchase of Preferred Stock
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['preferred_repurchase']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['uses']['preferred_repurchase']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Repurchase of Common Stock
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['common_repurchase']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['uses']['common_repurchase']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Total Dividends Paid
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['dividends']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-2 last:pr-8">
                                        <?php $value = $data['uses']['dividends']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="pl-8 pt-2 pb-2 text-left">
                                    Cash Build / Other
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['other']['timeline'][$date]; ?>

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
                                    <span class="pl-4">% of Total Uses</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-4 last:pr-8">
                                        <?php $value = $data['uses']['other']['total_percent'][$date]; ?>

                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>

                            <tr class="font-bold border-t border-[#D4DDD7]">
                                <td class="pl-8 pt-4 pb-2 text-left">
                                    Total Sources of Cash
                                </td>
                                @foreach ($selectedDates as $date)
                                    <?php $value = $data['uses']['total']['timeline'][$date]; ?>

                                    <td class="pl-6 pt-4 pb-2 last:pr-8">
                                        <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }">
                                            {!! redIfNegative($value) !!}
                                        </x-review-number-button>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="pl-8 pt-2 pb-4 text-left rounded-bl-lg">
                                    <span class="pl-4">% Change YoY</span>
                                </td>
                                @foreach ($selectedDates as $date)
                                    <td class="pl-6 pt-2 pb-4 last:pr-8 last:rounded-br-lg">
                                        <?php $value = $data['uses']['total']['yoy_change'][$date]; ?>

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
