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
        <table class="w-full rounded-lg overflow-hidden text-right whitespace-nowrap" id="main-table">
            <thead class="font-sm font-semibold capitalize bg-[#EDEDED] text-dark">
                <tr class="font-bold text-base">
                    <th class="pl-8 py-2 text-left">{{ $profile['registrant_name'] }}
                        ({{ $profile['symbol'] }})</th>
                    @foreach (array_keys($products) as $date)
                        <th class="pl-6 py-2 last:pr-8">
                            {{ explode('-', $date)[0] }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="bg-white">
                @foreach ($segments as $index => $segment)
                    <tr class="font-bold">
                        <td class="pl-8 pt-4 pb-2 text-left">
                            {{ str_replace('[Member]', '', $segment) }}
                        </td>
                        @foreach (array_keys($products) as $date)
                            @if (array_key_exists($segment, $products[$date]))
                                <?php
                                $value = $products[$date][$segment];
                                ?>
                                <td class="pl-6 last:pr-8">
                                    {!! redIfNegative($value, fn($val) => custom_number_format($val)) !!}

                                    <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                    <tr class="border-b border-[#D4DDD7]">
                        <td class="pl-8 pt-2 pb-4 text-left">
                            <span class="pl-4">% Change YoY</span>
                        </td>
                        @foreach (array_keys($products) as $key => $date)
                            @if (array_key_exists($segment, $products[$date]))
                                <td class="pl-6 last:pr-8">
                                    <?php
                                    $value = $key == 0 ? 0 : round((($products[$date][$segment] - $products[array_keys($products)[$key - 1]][$segment]) / $products[$date][$segment]) * 100, 2);
                                    ?>

                                    {!! redIfNegative($value, fn($val) => $val . '%') !!}

                                    <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                <tr class="font-bold">
                    <td class="pl-8 pt-4 pb-2 text-left">
                        Total Revenues
                    </td>
                    @foreach (array_keys($products) as $date)
                        <?php $value = array_sum($products[$date]); ?>
                        <td class="pl-6 last:pr-8">
                            {!! redIfNegative($value, fn($val) => custom_number_format($val)) !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="rounded-bl-lg pl-8 pt-2 pb-4 text-left">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="last:rounded-br-lg pl-6 last:pr-8">
                            <?php
                            $value = $key == 0 ? 0 : round(((array_sum($products[$date]) - array_sum($products[array_keys($products)[$key - 1]])) / array_sum($products[$date])) * 100, 2);
                            ?>

                            {!! redIfNegative($value, fn($val) => $val . '%') !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
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

            <tbody class="bg-white">
                <tr class="font-bold">
                    <td class="bg-white rounded-tl-lg pl-8 pt-4 pb-2 text-left">
                        EBITDA
                    </td>
                    @foreach (array_keys($products) as $date)
                        <td class="last:rounded-tr-lg pl-6 last:pr-8">
                            <?php
                            if (isset($ebitda[$date][0])) {
                                $value = str_replace(',', '', explode('|', $ebitda[$date][0])[0]);
                            
                                if (!is_numeric($value)) {
                                    $value = 'N/A';
                                }
                            
                                $value = floatval($value);
                            } else {
                                $value = 'N/A';
                            }
                            ?>

                            {!! redIfNegative($value, fn($val) => custom_number_format($val)) !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="pl-8 py-2 text-left">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="pl-6 last:pr-8">
                            <?php
                            if ($key == 0) {
                                $value = 0;
                            } else {
                                $previousKey = array_keys($products)[$key - 1];
                                $currentEbitDA = floatval(isset($ebitda[$date][0]) ? str_replace(',', '', explode('|', $ebitda[$date][0])[0]) : 0);
                                $previousEbitDA = floatval(isset($ebitda[$previousKey][0]) ? str_replace(',', '', explode('|', $ebitda[$previousKey][0])[0]) : 0);
                            
                                $value = $previousEbitDA != 0 ? round((($currentEbitDA - $previousEbitDA) / $previousEbitDA) * 100, 2) : 'N/A';
                            }
                            ?>

                            {!! redIfNegative($value, fn($val) => $val . '%') !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="rounded-bl-lg pl-8 pt-2 pb-4 text-left">
                        <span class="pl-4">% Margins</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="last:rounded-br-lg  pl-6 last:pr-8">
                            <?php
                            if ($key == 0) {
                                $value = 0;
                            } else {
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
                            
                                $value = $currentRevenueValue != 0 ? round(($currentEbitdaValue / $currentRevenueValue) * 100, 2) : 'N/A';
                            }
                            ?>

                            {!! redIfNegative($value, fn($val) => $val . '%') !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
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

            <tbody class="bg-white">
                <tr class="font-bold">
                    <td class="bg-white rounded-tl-lg pl-8 pt-4 pb-2 text-left">
                        Adj. Net Income
                    </td>
                    @foreach (array_keys($products) as $date)
                        <td class="last:rounded-tr-lg pl-6 last:pr-8">
                            <?php
                            if (isset($adjNetIncome[$date][0])) {
                                $value = str_replace(',', '', explode('|', $adjNetIncome[$date][0])[0]);
                            
                                if (!is_numeric($value)) {
                                    $value = 'N/A';
                                }
                            
                                $value = floatval($value);
                            } else {
                                $value = 'N/A';
                            }
                            ?>

                            {!! redIfNegative($value, fn($val) => custom_number_format($val)) !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="pl-8 py-2 text-left">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="pl-6 last:pr-8">
                            <?php
                            if ($key == 0) {
                                $value = 0;
                            } else {
                                $previousKey = array_keys($products)[$key - 1];
                                $currentAdjNetIncome = floatval(isset($adjNetIncome[$date][0]) ? str_replace(',', '', explode('|', $adjNetIncome[$date][0])[0]) : 0);
                                $previousAdjNetIncome = floatval(isset($adjNetIncome[$previousKey][0]) ? str_replace(',', '', explode('|', $adjNetIncome[$previousKey][0])[0]) : 0);
                            
                                $value = $previousAdjNetIncome != 0 ? round((($currentAdjNetIncome - $previousAdjNetIncome) / $previousAdjNetIncome) * 100, 2) : 'N/A';
                            }
                            ?>

                            {!! redIfNegative($value, fn($val) => $val . '%') !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="pl-8 py-2 text-left">
                        <span class="pl-4">% Margins</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="pl-6 last:pr-8">
                            <?php
                            if ($key == 0) {
                                $value = 0;
                            } else {
                                $currentNetIncome = isset($adjNetIncome[$date][0]) ? floatval(str_replace(',', '', explode('|', $adjNetIncome[$date][0])[0])) : 0;
                                $currentRevenue = isset($revenues[$date][0]) ? floatval(str_replace(',', '', explode('|', $revenues[$date][0])[0])) : 0;
                            
                                $value = $currentNetIncome != 0 ? round(($currentRevenue / $currentNetIncome) * 100, 2) : 'N/A';
                            }
                            ?>

                            {!! redIfNegative($value, fn($val) => $val . '%') !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="pl-8 py-2 text-left">
                        <span class="pl-4">Diluted Shares Out</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="pl-6 last:pr-8">
                            <?php
                            $value = isset($dilutedSharesOut[$date][0]) && is_numeric($dilutedSharesOut[$date][0]) ? floatval(str_replace(',', '', explode('|', $dilutedSharesOut[$date][0])[0])) : 'N/A';
                            ?>

                            {!! redIfNegative($value, fn($val) => custom_number_format($val)) !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="rounded-bl-lg pl-8 pt-2 pb-4 text-left">
                        <span class="pl-4">% Change YoY</span>
                    </td>
                    @foreach (array_keys($products) as $key => $date)
                        <td class="last:rounded-br-lg  pl-6 last:pr-8">
                            <?php
                            if ($key == 0) {
                                $value = 0;
                            } else {
                                $previousDate = array_keys($products)[$key - 1];
                                $currentDilutedSharesOut = isset($dilutedSharesOut[$date][0]) ? floatval(str_replace(',', '', explode('|', $dilutedSharesOut[$date][0])[0])) : 0;
                                $previousDilutedSharesOut = isset($dilutedSharesOut[$previousDate][0]) ? floatval(str_replace(',', '', explode('|', $dilutedSharesOut[$previousDate][0])[0])) : 0;
                            
                                $value = $previousDilutedSharesOut != 0 ? round((($currentDilutedSharesOut - $previousDilutedSharesOut) / $previousDilutedSharesOut) * 100, 2) : 'N/A';
                            }
                            ?>
                            {!! redIfNegative($value, fn($v) => $v . '%') !!}

                            <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
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
        
                    console.log('done')
        
                    setInterval(() => {
                        this.copyMainTableWidth(mainCells, targetCells);
                    }, 2000);
                },
        
                copyMainTableWidth(mainCells, targetCells) {
                    mainCells.forEach((cell, index) => {
                        {{-- subtract the padding size from each cell --}}
                        targetCells[index].style.minWidth = (cell.offsetWidth - {{ 16 / count($products) }}) + 'px';
                    });
                }
        }" style="min-width: max-content">
            <table class="w-full rounded-lg overflow-hidden text-left whitespace-nowrap"
                style="background: rgba(82, 198, 255, 0.10)">
                <thead>
                    <tr>
                        <th class="pl-6 pt-4 font-bold whitespace-nowrap text-dark">Adj. Diluted EPS</th>
                        @foreach (array_keys($products) as $key => $date)
                            <th class="pl-6 last:pr-8 pt-4 font-bold whitespace-nowrap text-dark text-right">
                                <?php $value = isset($dilutedEPS[$date][0]) ? str_replace(',', '', explode('|', $dilutedEPS[$date][0])[0]) : 'N/A'; ?>

                                {!! redIfNegative($value, fn($val) => custom_number_format($val)) !!}

                                <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
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
                            <td class="pl-6 py-4 last:pr-8 text-right">
                                <?php
                                if ($key == 0) {
                                    $value = 0;
                                } else {
                                    $previousDate = array_keys($products)[$key - 1];
                                    $currentDilutedEPS = isset($dilutedEPS[$date][0]) ? floatval(str_replace(',', '', explode('|', $dilutedEPS[$date][0])[0])) : 0;
                                    $previousDilutedEPS = isset($dilutedEPS[$previousDate][0]) ? floatval(str_replace(',', '', explode('|', $dilutedEPS[$previousDate][0])[0])) : 0;
                                
                                    $value = $previousDilutedEPS != 0 ? round((($currentDilutedEPS - $previousDilutedEPS) / $previousDilutedEPS) * 100, 2) : 'N/A';
                                }
                                ?>

                                {!! redIfNegative($value, fn($v) => $v . '%') !!}

                                <x-review-number-button x-data="{ amount: '{{ $value }}', date: '{{ $date }}' }"></x-review-number-button>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
