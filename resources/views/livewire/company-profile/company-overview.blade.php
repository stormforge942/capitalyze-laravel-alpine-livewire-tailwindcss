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
                    'value' => '31.54MM',
                ],
                [
                    'key' => 'Beta',
                    'value' => '1.06',
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
        class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-x-6 gap-y-4 text-base leading-normal order-2 lg:order-1">
        @foreach ($cards as $card)
            <x-card :title="$card['title']">
                <div class="grid grid-cols-3 2xl:grid-cols-2 gap-5">
                    @foreach ($card['items'] as $item)
                        <div>
                            <div class="text-dark-light2 text-sm">{{ $item['key'] }}</div>
                            <div class="font-semibold">{{ $item['value'] }}</div>
                        </div>
                    @endforeach
                </div>
            </x-card>
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
            <button class="text-sm font-extrabold hover:text-black"
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

    <div class="overflow-auto rounded-lg order-5">
        <table class="w-full rounded-lg text-left">
            <thead class="font-sm font-semibold capitalize bg-[#EDEDED] text-dark">
                <tr class="border-b-2 border-b-[#E6E6E6]">
                    <th class="pl-6 py-2 whitespace-nowrap font-extrabold">{{ $profile['registrant_name'] }}
                        ({{ $profile['symbol'] }})</th>
                    @foreach (array_keys($products) as $date)
                        <th class="pl-6 py-2 whitespace-nowrap font-extrabold last:pr-6 text-right">
                            {{ $date }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($segments as $index => $segment)
                    <tr class="border-b-2 border-b-[#E6E6E6]">
                        <th class="bg-white pl-6 py-3 whitespace-nowrap font-extrabold">
                            {{ str_replace('[Member]', '', $segment) }}
                        </th>
                        @foreach (array_keys($products) as $date)
                            @if (array_key_exists($segment, $products[$date]))
                                <th class="bg-white pl-6 py-3 last:pr-6 text-right font-extrabold">
                                    {{ number_format($products[$date][$segment]) }}
                                </th>
                            @endif
                        @endforeach
                    </tr>
                    <tr class="border-b-2 border-b-[#E6E6E6]">
                        <td class="bg-white pl-6 py-4 whitespace-nowrap">
                            <span class="pl-4">% Change YoY</span>
                        </td>
                        @foreach (array_keys($products) as $key => $date)
                            @if (array_key_exists($segment, $products[$date]))
                                <td class="bg-white pl-6 py-4 last:pr-6 text-right">
                                    @if ($key == 0)
                                        0.0%
                                    @else
                                        {!! redIfNegative(
                                            round(
                                                (($products[$date][$segment] - $products[array_keys($products)[$key - 1]][$segment]) /
                                                    $products[$date][$segment]) *
                                                    100,
                                                2,
                                            ),
                                            fn($v) => $v . '%',
                                        ) !!}
                                    @endif
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th class="bg-white pl-6 pt-4 whitespace-nowrap font-extrabold">
                        Total Revenues
                    </th>
                    @foreach (array_keys($products) as $date)
                        <th class="bg-white pl-6 pt-4 whitespace-nowrap font-extrabold last:pr-6 text-right">
                            {{ number_format(array_sum($products[$date])) }}
                        </th>
                    @endforeach
                </tr>
                <tr>
                    <td class="bg-white rounded-bl-lg pl-6 py-4 whitespace-nowrap">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="bg-white last:rounded-br-lg pl-6 py-4 last:pr-6 text-right">
                            @if ($key == 0)
                                0.0%
                            @else
                                {!! redIfNegative(
                                    round(
                                        ((array_sum($products[$date]) - array_sum($products[array_keys($products)[$key - 1]])) /
                                            array_sum($products[$date])) *
                                            100,
                                        2,
                                    ),
                                    fn($val) => $val . '%',
                                ) !!}
                            @endif
                        </td>
                    @endforeach
                </tr>

            </tbody>

            <tbody>
                <tr>
                    <td class="py-2 bg-transparent"></td>
                </tr>
            </tbody>

            <tbody>
                <tr class="border-b-2 border-b-[#E6E6E6]">
                    <th class="bg-white rounded-tl pl-6 py-3 whitespace-nowrap font-extrabold">
                        EBITDA
                    </th>
                    @foreach (array_keys($products) as $date)
                        <th class="bg-white last:rounded-tr pl-6 py-3 last:pr-6 text-right font-extrabold">
                            {{ isset($ebitda[$date]) ? number_format((float) explode('|', str_replace(',', '', $ebitda[$date][0]))[0], 2) : 'N/A' }}
                        </th>
                    @endforeach
                </tr>
                <tr>
                    <td class="bg-white pl-6 pt-4 pb-2 whitespace-nowrap">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="bg-white pl-6 pt-4 pb-2 last:pr-6 text-right">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $previousKey = array_keys($products)[$key - 1];
                                    $currentEbitDAValue = isset($ebitda[$date][0]) ? str_replace(',', '', explode('|', $ebitda[$date][0])[0]) : 0;
                                    $previousEbitDAValue = isset($ebitda[$previousKey][0]) ? str_replace(',', '', explode('|', $ebitda[$previousKey][0])[0]) : 0;
                                    $currentEbitDA = floatval($currentEbitDAValue);
                                    $previousEbitDA = floatval($previousEbitDAValue);
                                @endphp
                                @if ($previousEbitDA != 0)
                                    {!! redIfNegative(round((($currentEbitDA - $previousEbitDA) / $previousEbitDA) * 100, 2), fn($v) => $v . '%') !!}
                                @else
                                    N/A
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>

                <tr>
                    <td class="rounded-bl-lg bg-white pl-6 pt-2 pb-4 whitespace-nowrap">
                        <span class="pl-4">% Margins</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="rounded-br-lg bg-white pl-6 pt-2 pb-4 last:pr-6 text-right">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $currentEbitdaValue = 0;
                                    $currentRevenueValue = 0;

                                    // Check if the key exists in the $ebitda array and if so, remove commas and convert to float
                                    if (isset($ebitda[$date][0])) {
                                        $currentEbitdaValue = floatval(str_replace(',', '', explode('|', $ebitda[$date][0])[0]));
                                    }

                                    // Check if the key exists in the $revenues array and if so, remove commas and convert to float
                                    if (isset($revenues[$date][0])) {
                                        $currentRevenueValue = floatval(str_replace(',', '', explode('|', $revenues[$date][0])[0]));
                                    }
                                @endphp
                                {{-- Ensure that $currentEbitdaValue is not zero to avoid division by zero --}}
                                @if ($currentEbitdaValue != 0)
                                    {!! redIfNegative(round($currentRevenueValue / $currentEbitdaValue, 2)) !!}
                                @else
                                    N/A
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>
            </tbody>

            <tbody>
                <tr>
                    <td class="py-2 bg-transparent"></td>
                </tr>
            </tbody>

            <tbody>
                <tr class="border-b-2 border-b-[#E6E6E6]">
                    <th class="bg-white rounded-tl pl-6 py-3 whitespace-nowrap font-extrabold">
                        Adj. Net Income
                    </th>
                    @foreach (array_keys($products) as $date)
                        <th class="bg-white last:rounded-tr pl-6 py-3 last:pr-6 text-right font-extrabold">
                            {{ isset($adjNetIncome[$date][0]) ? number_format(floatval(explode('|', str_replace(',', '', $adjNetIncome[$date][0]))[0]), 2) : 'N/A' }}
                        </th>
                    @endforeach
                </tr>
                <tr>
                    <td class="bg-white pl-6 pt-4 pb-2 whitespace-nowrap">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="bg-white pl-6 pt-4 pb-2 last:pr-6 text-right">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $currentKey = array_keys($products)[$key];
                                    $previousKey = array_keys($products)[$key - 1];

                                    $currentAdjNetIncome = isset($adjNetIncome[$currentKey][0]) ? floatval(str_replace(',', '', explode('|', $adjNetIncome[$currentKey][0])[0])) : 0;
                                    $previousAdjNetIncome = isset($adjNetIncome[$previousKey][0]) ? floatval(str_replace(',', '', explode('|', $adjNetIncome[$previousKey][0])[0])) : 0;
                                @endphp

                                @if ($previousAdjNetIncome != 0)
                                    {!! redIfNegative(
                                        round((($currentAdjNetIncome - $previousAdjNetIncome) / $previousAdjNetIncome) * 100, 2),
                                        fn($v) => $v . '%',
                                    ) !!}
                                @else
                                    N/A
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="bg-white pl-6 py-2 whitespace-nowrap">
                        <span class="pl-4">% Margins</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="bg-white pl-6 py-2 last:pr-6 text-right">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $currentNetIncome = isset($adjNetIncome[$date][0]) ? floatval(str_replace(',', '', explode('|', $adjNetIncome[$date][0])[0])) : 0;
                                    $currentRevenue = isset($revenues[$date][0]) ? floatval(str_replace(',', '', explode('|', $revenues[$date][0])[0])) : 0;
                                @endphp

                                @if ($currentNetIncome != 0)
                                    {!! redIfNegative(round(($currentRevenue / $currentNetIncome) * 100, 2), fn($v) => $v . '%') !!}
                                @else
                                    N/A
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="bg-white pl-6 py-2 whitespace-nowrap">
                        <span class="pl-4">Diluted Shares Out</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="bg-white pl-6 pt-2 pb-4 last:pr-6 text-right">
                            {{ isset($dilutedSharesOut[$date][0]) ? str_replace(',', '', explode('|', $dilutedSharesOut[$date][0])[0]) : 'N/A' }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="rounded-bl-lg bg-white pl-6 pt-2 pb-4 whitespace-nowrap">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="rounded-br-lg bg-white pl-6 pt-2 pb-4 last:pr-6 text-right">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $previousDate = array_keys($products)[$key - 1];
                                    $currentDilutedSharesOut = isset($dilutedSharesOut[$date][0]) ? floatval(str_replace(',', '', explode('|', $dilutedSharesOut[$date][0])[0])) : 0;
                                    $previousDilutedSharesOut = isset($dilutedSharesOut[$previousDate][0]) ? floatval(str_replace(',', '', explode('|', $dilutedSharesOut[$previousDate][0])[0])) : 0;

                                    $percentageChange = $previousDilutedSharesOut != 0 ? round((($currentDilutedSharesOut - $previousDilutedSharesOut) / $previousDilutedSharesOut) * 100, 2) : 'N/A';
                                @endphp
                                {!! redIfNegative($percentageChange, fn($v) => $v . '%') !!}
                            @endif
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded p-2 overflow-auto order-6">
        <table class="rounded text-left" style="background: rgba(82, 198, 255, 0.10)">
            <thead>
                <tr>
                    <th class="pl-6 pt-4 font-extrabold whitespace-nowrap text-dark">Adj. Diluted EPS</th>
                    @foreach (array_keys($products) as $key => $date)
                        <th class="pl-6 last:pr-6 pt-4 font-extrabold whitespace-nowrap text-dark text-right">
                            {{ isset($dilutedEPS[$date][0]) ? str_replace(',', '', explode('|', $dilutedEPS[$date][0])[0]) : 'N/A' }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="pl-6 py-4">
                        <span class="pl-4 whitespace-nowrap">% Change YoY</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="pl-6 py-4 last:pr-6 text-right">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $previousDate = array_keys($products)[$key - 1];
                                    $currentDilutedEPS = isset($dilutedEPS[$date][0]) ? floatval(str_replace(',', '', explode('|', $dilutedEPS[$date][0])[0])) : 0;
                                    $previousDilutedEPS = isset($dilutedEPS[$previousDate][0]) ? floatval(str_replace(',', '', explode('|', $dilutedEPS[$previousDate][0])[0])) : 0;
                                @endphp
                                @if ($previousDilutedEPS != 0)
                                    {!! redIfNegative(
                                        round((($currentDilutedEPS - $previousDilutedEPS) / $previousDilutedEPS) * 100, 2),
                                        fn($v) => $v . '%',
                                    ) !!}
                                @else
                                    N/A
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>
