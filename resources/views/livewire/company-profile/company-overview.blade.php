<div>
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
    <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-6 text-base leading-normal">
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

    <livewire:company-profile.company-overview-graph :ticker="$profile['symbol']" />

    <x-card title="Business Information" class="mt-4">
        <div class="leading-6 text-base">
            {{ $profile['description'] ?? 'Description not found' }}
        </div>
    </x-card>

    <x-card title="Company Profile" x-data="{ expanded: false }" class="mt-4 text-base">
        <x-slot name="topRight">
            <button class="text-sm font-extrabold hover:text-black"
                x-text="expanded ? 'Hide full profile': 'View full profile'" @click="expanded = !expanded">
                Hide full profile
            </button>
        </x-slot>

        <div class="grid gap-x-4 gap-y-6 grid-cols-2 md:grid-cols-3 2xl:grid-cols-6">
            @foreach ($profile['profile'] as $item)
                <div class="flex gap-2" @if (!($item['is_main'] ?? false)) x-show="expanded" x-cloak @endif>
                    <div class="{{ !isset($item['icon']) ? 'hidden invisible' : 'grid' }} bg-[#52D3A233] bg-opacity-20 md:grid place-items-center h-8 w-8 rounded">
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

    <div class="table-wrapper">
        <div class="table">
            <div class="row-group row-head-fonts-sm table-border-bottom">
                <div class="row row-head ">
                    <div class="cell font-bold">{{ $profile['registrant_name'] }} ({{ $profile['symbol'] }})</div>
                    @foreach (array_keys($products) as $date)
                        <div class="cell font-bold">{{ $date }}</div>
                    @endforeach
                </div>
                @foreach ($segments as $index => $segment)
                    <div class="row ">
                        <div class="font-bold cell">
                            {{ $segment }}
                        </div>
                        @foreach (array_keys($products) as $date)
                            @if (array_key_exists($segment, $products[$date]))
                                <div class="font-bold cell">
                                    {{ number_format($products[$date][$segment]) }}
                                </div>
                            @endif
                        @endforeach
                        {{-- <div class="font-bold cell">100.0</div>
                        <div class="font-bold cell">100.0</div>
                        <div class="font-bold cell">100.0</div>
                        <div class="font-bold cell">100.0</div>
                        <div class="font-bold cell">100.0</div>
                        <div class="font-bold cell">100.0</div> --}}
                    </div>
                    <div class="row row-sub">
                        <div class="cell">% Change YoY</div>
                        @foreach (array_keys($products) as $key => $date)
                            @if (array_key_exists($segment, $products[$date]))
                                <div class="cell">
                                    @if ($key == 0)
                                        0.0%
                                    @else
                                        {{ round((($products[$date][$segment] - $products[array_keys($products)[$key - 1]][$segment]) / $products[$date][$segment]) * 100, 2) . '%' }}
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
                <div class="row ">
                    <div class="font-bold cell">Total Revenues</div>
                    @foreach (array_keys($products) as $date)
                        <div class="font-bold cell">
                            {{ number_format(array_sum($products[$date])) }}
                        </div>
                    @endforeach
                </div>
                <div class="row row-sub">
                    <div class="cell">% Change YoY</div>
                    @foreach (array_keys($products) as $key => $date)
                        <div class="cell">
                            @if ($key == 0)
                                0.0%
                            @else
                                {{ round(((array_sum($products[$date]) - array_sum($products[array_keys($products)[$key - 1]])) / array_sum($products[$date])) * 100, 2) . '%' }}
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row row-spacer "></div>
            <div class="row-group row-head-fonts-sm table-header-border">
                <div class="row">
                    <div class="font-bold cell">EBITDA</div>
                    @foreach (array_keys($products) as $key => $date)
                        <div class="font-bold cell">
                            {{ number_format(explode('|', str_replace(',', '', $ebitda[$date][0]))[0]) }}
                        </div>
                    @endforeach
                </div>

                <div class="row row-sub">
                    <div class="cell">% Change YoY</div>
                    @foreach (array_keys($products) as $key => $date)
                        <div class="cell">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $currentEbitDA = str_replace(',', '', explode('|', $ebitda[$date][0])[0]);
                                    $previousEbitDA = str_replace(',', '', explode('|', $ebitda[array_keys($products)[$key - 1]][0])[0]);
                                @endphp
                                {{ round((($currentEbitDA - $previousEbitDA) / $previousEbitDA) * 100, 2) }}%
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="row row-sub">
                    <div class="cell">% Margins</div>
                    @foreach (array_keys($products) as $key => $date)
                        <div class="cell">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $currentEbitda = str_replace(',', '', explode('|', $ebitda[$date][0])[0]);
                                    $currentRevenue = str_replace(',', '', explode('|', $revenues[$date][0])[0]);
                                @endphp
                                {{ round($currentRevenue / $currentEbitda, 2) }}
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row row-spacer"></div>

            <div class="row-group row-head-fonts-sm table-header-border">
                <div class="row">
                    <div class="font-bold cell">Adj. Net Income</div>
                    @foreach (array_keys($products) as $key => $date)
                        <div class="font-bold cell">
                            {{ number_format(explode('|', str_replace(',', '', $adjNetIncome[$date][0]))[0]) }}
                        </div>
                    @endforeach
                </div>

                <div class="row row-sub">
                    <div class="cell">% Change YoY</div>
                    @foreach (array_keys($products) as $key => $date)
                        <div class="cell">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $currentAdjNetIncome = str_replace(',', '', explode('|', $adjNetIncome[$date][0])[0]);
                                    $previousAdjNetIncome = str_replace(',', '', explode('|', $adjNetIncome[array_keys($products)[$key - 1]][0])[0]);
                                @endphp
                                {{ round((($currentAdjNetIncome - $previousAdjNetIncome) / $previousAdjNetIncome) * 100, 2) }}%
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="row row-sub">
                    <div class="cell">% Margins</div>
                    @foreach (array_keys($products) as $key => $date)
                        <div class="cell">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $currentNetIncome = str_replace(',', '', explode('|', $adjNetIncome[$date][0])[0]);
                                    $currentRevenue = str_replace(',', '', explode('|', $revenues[$date][0])[0]);
                                @endphp
                                {{ round($currentRevenue / $currentNetIncome, 2) }}%
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="row row-sub">
                    <div class="cell">Diluted Shares Out</div>
                    @foreach (array_keys($products) as $key => $date)
                        <div class="cell">
                            {{ str_replace(',', '', explode('|', $dilutedSharesOut[$date][0])[0]) }}
                        </div>
                    @endforeach
                </div>
                <div class="row row-sub">
                    <div class="cell">% Change YoY</div>
                    @foreach (array_keys($products) as $key => $date)
                        <div class="cell">
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $currentDilutedSharesOut = str_replace(',', '', explode('|', $dilutedSharesOut[$date][0])[0]);
                                    $previousDilutedSharesOut = str_replace(',', '', explode('|', $dilutedSharesOut[array_keys($products)[$key - 1]][0])[0]);
                                @endphp
                                {{ round((($currentDilutedSharesOut - $previousDilutedSharesOut) / $previousDilutedSharesOut) * 100, 2) }}%
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row row-spacer"></div>
        </div>
    </div>

    <div class="table-bottom-sec">
        <div class="table-wrapper ">
            <div class="table">
                <div class="row-group row-group-blue row-head-fonts-sm">
                    <div class="row row-head">
                        <div class="font-bold cell">Adj. Diluted EPS</div>
                        @foreach (array_keys($products) as $key => $date)
                            <div class="font-bold cell">
                                {{ str_replace(',', '', explode('|', $dilutedEPS[$date][0])[0]) }}
                            </div>
                        @endforeach
                    </div>

                    <div class="row row-sub">
                        <div class="font-bold cell">% Change YoY</div>
                        @foreach (array_keys($products) as $key => $date)
                            <div class="cell">
                                @if ($key == 0)
                                    0.0%
                                @else
                                    @php
                                        $currentDilutedEPS = str_replace(',', '', explode('|', $dilutedEPS[$date][0])[0]);
                                        $previousDilutedEPS = str_replace(',', '', explode('|', $dilutedEPS[array_keys($products)[$key - 1]][0])[0]);
                                    @endphp
                                    {{ round((($currentDilutedEPS - $previousDilutedEPS) / $previousDilutedEPS) * 100, 2) }}%
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
