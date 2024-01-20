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
            <x-analysis-chart-box title="Revenue By Employee" :company="$company" :chart="$chart" :hasPercentageMix="false"
                function="renderRevenueByEmployeeChart"></x-analysis-chart-box>

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

                    <tbody class="bg-white">
                        <tr>
                            <td class="pl-8 pt-4 pb-2 text-left">
                                Revenues
                            </td>
                            @foreach ($selectedDates as $date)
                                <?php $value = $data['revenues']['timeline'][$date]; ?>

                                <td
                                    class="pl-6 pt-4 pb-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                    {!! redIfNegative($value) !!}

                                    <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }"></x-review-number-button>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="pl-8 pt-2 pb-2 text-left">
                                <span class="pl-4">% Change YoY</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-2 pb-2 last:pr-8">
                                    <?php $value = $data['revenues']['yoy_change'][$date]; ?>

                                    {!! redIfNegative($value) !!}

                                    <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }"></x-review-number-button>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="pl-8 pt-2 pb-2 text-left">
                                Employees
                            </td>
                            @foreach ($selectedDates as $date)
                                <?php $value = $data['employee_count']['timeline'][$date]; ?>

                                <td
                                    class="pl-6 pt-2 pb-2 last:pr-8 @if (!$loop->first) last:rounded-tr-lg @endif">
                                    {!! redIfNegative($value) !!}

                                    <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }"></x-review-number-button>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="pl-8 pt-2 pb-4 text-left">
                                <span class="pl-4">% Change YoY</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-2 pb-4 last:pr-8">
                                    <?php $value = $data['employee_count']['yoy_change'][$date]; ?>

                                    {!! redIfNegative($value) !!}

                                    <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }"></x-review-number-button>
                                </td>
                            @endforeach
                        </tr>

                        <tr class="font-bold border-t border-[#D4DDD7]">
                            <td class="pl-8 pt-4 pb-2 text-left">
                                Revenue / Employee ('000s)
                            </td>
                            @foreach ($selectedDates as $date)
                                <?php $value = $data['rev_by_emp']['timeline'][$date]; ?>

                                <td class="pl-6 pt-4 pb-2 last:pr-8">
                                    {!! redIfNegative($value) !!}

                                    <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }"></x-review-number-button>
                                </td>
                            @endforeach
                        </tr>
                        <tr class="font-bold">
                            <td class="pl-8 pt-2 pb-4 text-left rounded-bl-lg">
                                <span class="pl-4">% Change YoY</span>
                            </td>
                            @foreach ($selectedDates as $date)
                                <td class="pl-6 pt-2 pb-4 last:pr-8 last:rounded-br-lg">
                                    <?php $value = $data['rev_by_emp']['yoy_change'][$date]; ?>

                                    {!! redIfNegative($value) !!}

                                    <x-review-number-button x-data="{ amount: '{{ $value['value'] }}', date: '{{ $date }}' }"></x-review-number-button>
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
