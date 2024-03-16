<div class="grid grid-cols-1 gap-y-4">
    <?php
    $cards = [
        [
            'title' => 'Market Data',
            'items' => [
                [
                    'key' => '52 Week High',
                    'value' => $profile['fiftytwo_week_range_high'] ?? '-',
                ],
                [
                    'key' => '52 Week Low',
                    'value' => $profile['fiftytwo_week_range_low'] ?? '-',
                ],
                [
                    'key' => 'Avg. 3mths Vol.',
                    'value' => is_numeric($profile['average_3month_volume']) ? formatNiceNumber($profile['average_3month_volume']) : '-',
                ],
                [
                    'key' => 'Beta',
                    'value' => $profile['beta'],
                ],
                [
                    'key' => 'Short Interest',
                    'value' => '0.4%',
                ],
            ],
        ],
        [
            'title' => 'Capital Structure',
            'items' => [
                [
                    'key' => 'Market Capital',
                    'value' => '$133.74',
                ],
                [
                    'key' => 'Total Enterprise Value',
                    'value' => '$83.3434',
                ],
                [
                    'key' => 'Shares Outstanding',
                    'value' => '31.54MM',
                ],
                [
                    'key' => 'LTM Net Debt',
                    'value' => '1.06',
                ],
                [
                    'key' => 'LTM Net Debt/EBITDA',
                    'value' => '0.4%',
                ],
            ],
        ],
        [
            'title' => 'Profitability',
            'items' => [
                [
                    'key' => 'Gross Margin',
                    'value' => '$133.74',
                ],
                [
                    'key' => 'EBIT Margin',
                    'value' => '$83.3434',
                ],
                [
                    'key' => 'ROA',
                    'value' => '31.54MM',
                ],
                [
                    'key' => 'ROE',
                    'value' => '1.06',
                ],
                [
                    'key' => 'ROIC',
                    'value' => '0.4%',
                ],
            ],
        ],
        [
            'title' => 'LTM Valuation',
            'items' => [
                [
                    'key' => 'EV/Revenues',
                    'value' => '$133.74',
                ],
                [
                    'key' => 'LTM EV/Gross Profit',
                    'value' => '$83.3434',
                ],
                [
                    'key' => 'LTM EV/Adj. EBIT',
                    'value' => '31.54MM',
                ],
                [
                    'key' => 'LTM EV/Adj. P/E',
                    'value' => '1.06',
                ],
                [
                    'key' => 'LTM P/BV',
                    'value' => '0.4%',
                ],
            ],
        ],
    ];
    ?>
    <div
        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-x-6 xl:gap-x-4 gap-y-4 text-base leading-normal order-2 lg:order-1">
        @foreach ($cards as $card)
            <div class="bg-white p-4 md:p-6 xl:p-4 2xl:p-6 rounded-lg">
                <div class="mb-4 text-sm font-semibold text-blue">
                    {{ $card['title'] }}
                </div>

                <div class="grid grid-cols-3 xl:grid-cols-2 gap-x-3 gap-y-5">
                    @foreach ($card['items'] as $item)
                        <div>
                            <div
                                class="text-dark-light2 xl:text-[11px] 2xl:text-sm xl:tracking-[-0.33px] 2xl:tracking-normal">
                                {{ $item['key'] }}</div>
                            <div class="font-semibold">{{ $item['value'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="order-1 lg:order-2">
        <livewire:company-profile.company-overview-graph :ticker="$profile['symbol']" />
    </div>

    <x-card title="Business Information" class="order-3">
        <div class="leading-6 text-base">
            {{ $profile['description'] ?? 'Description not found' }}
        </div>
    </x-card>

    <x-card title="Company Profile" x-data="{
        expanded: false,
        showCount: 0,
        updateCount() {
            const width = window.innerWidth;
    
            if (width >= 1536) {
                this.showCount = 6;
            } else if (width >= 1280) {
                this.showCount = 10;
            } else if (width >= 1024) {
                this.showCount = 8;
            } else {
                this.showCount = 6;
            }
        }
    }" @resize.window.throttle="updateCount()"
        x-init="updateCount()" class="text-base order-4">
        <x-slot name="topRight">
            <button class="text-sm font-bold hover:text-black"
                x-text="expanded ? 'Hide full profile': 'View full profile'" @click="expanded = !expanded">
                Hide full profile
            </button>
        </x-slot>

        <div class="grid gap-x-4 gap-y-6 grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
            @foreach ($profile['profile'] as $idx => $item)
                <div class="flex gap-2" x-show="expanded || {{ $idx }} < showCount" x-cloak>
                    <div
                        class="{{ !isset($item['icon']) ? 'hidden invisible' : 'grid' }} bg-[#52D3A233] bg-opacity-20 md:grid place-items-center h-8 w-8 rounded">
                        {!! $item['icon'] ?? '' !!}
                    </div>

                    <div class="[&>*]:leading-[0.89rem]">
                        <div class="text-sm text-dark-light2">{{ $item['key'] }}</div>
                        <div class="mt-0.5 font-medium text-sm+ lg:text-base">
                            @if ($item['value'])
                                @if (data_get($item, 'type') === 'link')
                                    <a href="{{ $item['value'] }}" target="_blank"
                                        class="text-green-dark hover:underline">
                                        {{ getSiteNameFromUrl($item['value']) }}
                                    </a>
                                @else
                                    {{ $item['value'] }}
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>

    {{-- @todo: extract all the value logic to component itself --}}
    <div class="overflow-auto order-5">
        <div class="flex items-center justify-between gap-x-3">
            <div class="warning-wrapper">
                <div class="warning-text text-sm">
                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.99967 14.6663C4.31777 14.6663 1.33301 11.6815 1.33301 7.99967C1.33301 4.31777 4.31777 1.33301 7.99967 1.33301C11.6815 1.33301 14.6663 4.31777 14.6663 7.99967C14.6663 11.6815 11.6815 14.6663 7.99967 14.6663ZM7.99967 13.333C10.9452 13.333 13.333 10.9452 13.333 7.99967C13.333 5.05415 10.9452 2.66634 7.99967 2.66634C5.05415 2.66634 2.66634 5.05415 2.66634 7.99967C2.66634 10.9452 5.05415 13.333 7.99967 13.333ZM7.33301 9.99967H8.66634V11.333H7.33301V9.99967ZM7.33301 4.66634H8.66634V8.66634H7.33301V4.66634Z"
                            fill="#DA680B" />
                    </svg>
                    {{ $profile['symbol'] }} Key Metrics (millions)
                </div>
            </div>

            <div class="flex items-center">
                <span class="currency-font">Currency: &nbsp;</span>
                <select class="inline-flex font-bold !pr-8 bg-transparent">
                    <option value="USD">USD</option>
                </select>
            </div>

        </div>
        <table class="mt-3 w-full rounded-lg overflow-hidden text-right whitespace-nowrap text-base" id="main-table">
            <thead class="font-semibold capitalize bg-[#EDEDED] text-dark">
                <tr class="font-bold text-base">
                    <th class="pl-8 py-2 text-left">{{ $profile['registrant_name'] }}
                        ({{ $profile['symbol'] }})</th>
                    @foreach ($table['dates'] as $date)
                        <th class="pl-6 py-2 last:pr-8">
                            {{ explode('-', $date)[0] }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="bg-white">
                @foreach ($table['products'] as $name => $product)
                    <tr class="font-bold">
                        <td class="pl-8 pt-2 pb-1 text-left">
                            {{ $name }}
                        </td>
                        @foreach ($table['dates'] as $date)
                            <td class="pl-6 pt-2 pb-1 last:pr-8">
                                <?php $value = $product['timeline'][$date]; ?>

                                <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                    {!! format_overview_numbers($value) !!}
                                </x-review-number-button>
                            </td>
                        @endforeach
                    </tr>
                    <tr class="border-b border-[#D4DDD7]">
                        <td class="pl-8 pt-1 pb-2 text-left">
                            <span class="pl-4">% Change YoY</span>
                        </td>
                        @foreach ($table['dates'] as $date)
                            <td class="pl-6 pt-1 pb-2 last:pr-8">
                                <?php $value = $product['yoy_change'][$date]; ?>

                                <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                    {!! redIfNegative($value, fn($val) => round($val, 2) . '%') !!}
                                </x-review-number-button>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                <tr class="font-bold">
                    <td class="pl-8 pt-2 pb-1 text-left">
                        Total Revenues
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="pl-6 pt-2 pb-1 last:pr-8">
                            <?php $value = $table['total_revenue']['timeline'][$date]; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! format_overview_numbers($value) !!}
                            </x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="rounded-bl-lg pl-8 pt-1 pb-2 text-left">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="last:rounded-br-lg pl-6 pt-1 pb-2 last:pr-8">
                            <?php $value = $table['total_revenue']['yoy_change'][$date]; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! redIfNegative($value, fn($val) => round($val, 2) . '%') !!}
                            </x-review-number-button>
                        </td>
                    @endforeach
                </tr>
            </tbody>

            <x-table-spacer></x-table-spacer>

            <tbody class="bg-white">
                <tr class="font-bold">
                    <td class="bg-white rounded-tl-lg pl-8 pt-2 pb-1 text-left">
                        EBITDA
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="last:rounded-tr-lg pl-6 pt-2 pb-1 last:pr-8">
                            <?php $value = $table['ebitda']['timeline'][$date]; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! format_overview_numbers($value) !!}
                            </x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="pl-8 py-1 text-left">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="pl-6 py-1 last:pr-8">
                            <?php $value = $table['ebitda']['yoy_change'][$date]; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! redIfNegative($value, fn($val) => round($val, 2) . '%') !!}
                            </x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="rounded-bl-lg pl-8 pt-1 pb-2 text-left">
                        <span class="pl-4">% Margins</span>
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="last:rounded-br-lg pl-6 pt-1 pb-2 last:pr-8">
                            <?php $value = $table['ebitda']['margin'][$date] ?? 0; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! redIfNegative($value, fn($val) => round($val) . '%') !!}
                            </x-review-number-button>
                        </td>
                    @endforeach
                </tr>
            </tbody>

            <x-table-spacer></x-table-spacer>

            <tbody class="bg-white">
                <tr class="font-bold">
                    <td class="bg-white rounded-tl-lg pl-8 pt-2 pb-1 text-left">
                        Adj. Net Income
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="last:rounded-tr-lg pl-6 pt-2 pb-1 last:pr-8">
                            <?php $value = $table['adj_net_income']['timeline'][$date] ?? 0; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! format_overview_numbers($value) !!}
                            </x-review-number-button>

                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="pl-8 py-1 text-left">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="pl-6 py-1 last:pr-8">
                            <?php $value = $table['adj_net_income']['yoy_change'][$date] ?? 0; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! redIfNegative($value, fn($val) => round($val, 2) . '%') !!}
                            </x-review-number-button>

                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="pl-8 py-1 text-left">
                        <span class="pl-4">% Margins</span>
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="pl-6 py-1 last:pr-8">
                            <?php $value = $table['adj_net_income']['margin'][$date] ?? 0; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! redIfNegative($value, fn($val) => round($val, 2) . '%') !!}
                            </x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="pl-8 py-1 text-left">
                        <span class="pl-4">Diluted Shares Out</span>
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="pl-6 py-1 last:pr-8">
                            <?php $value = $table['diluted_shares_out']['timeline'][$date] ?? 0; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! format_overview_numbers($value) !!}
                            </x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="rounded-bl-lg pl-8 pt-1 pb-2 text-left">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach ($table['dates'] as $date)
                        <td class="last:rounded-br-lg pl-6 pt-1 pb-2 last:pr-8">
                            <?php $value = $table['diluted_shares_out']['yoy_change'][$date] ?? 0; ?>

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                {!! redIfNegative($value, fn($val) => round($val, 2) . '%') !!}
                            </x-review-number-button>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        <div class="mt-4 bg-white rounded-lg p-2" x-data="{
            init() {
                    const mainCells = document.querySelectorAll('#main-table thead th');
                    const targetCells = $el.querySelectorAll('table thead th');
        
                    this.copyMainTableWidth(mainCells, targetCells);
        
                    setInterval(() => {
                        this.copyMainTableWidth(mainCells, targetCells);
                    }, 2000);
                },
        
                copyMainTableWidth(mainCells, targetCells) {
                    mainCells.forEach((cell, index) => {
                        {{-- subtract the padding size from each cell --}}
                        targetCells[index].style.minWidth = (cell.offsetWidth - {{ count($table['dates']) ? 16 / count($table['dates']) : 0 }}) + 'px';
                    });
                }
        }" style="min-width: max-content">
            <table class="w-full rounded-lg overflow-hidden text-left whitespace-nowrap text-base"
                style="background: rgba(82, 198, 255, 0.10)">
                <thead>
                    <tr>
                        <th class="pl-6 pt-2 font-bold whitespace-nowrap text-dark">Adj. Diluted EPS</th>
                        @foreach ($table['dates'] as $date)
                            <th class="pl-6 last:pr-8 pt-2 font-bold whitespace-nowrap text-dark text-right">
                                <?php $value = $table['adj_diluted_eps']['timeline'][$date]; ?>

                                <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                    {!! redIfNegative($value, fn($val) => number_format($val, 2)) !!}
                                </x-review-number-button>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="pl-6 py-2">
                            <span class="pl-4 whitespace-nowrap font-bold">% Change YoY</span>
                        </td>
                        @foreach ($table['dates'] as $date)
                            <td class="pl-6 py-2 last:pr-8 text-right font-bold">
                                <?php $value = $table['adj_diluted_eps']['yoy_change'][$date]; ?>

                                <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }">
                                    {!! redIfNegative($value, fn($val) => round($val, 2)) !!}%
                                </x-review-number-button>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
