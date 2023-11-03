<div class="table-wrapper ">
    <div class="table">
        <div class="row-group row-head-fonts-sm table-border-bottom">
            @php
                $reversedProducts = array_reverse($products);
            @endphp
            <div class="row row-head ">
                <div class="cell font-bold">{{$company->name}} ({{$company->ticker}})</div>
                @foreach(array_keys($reversedProducts) as $date)
                <div class="cell font-bold">{{ $date }}</div>
                @endforeach
            </div>
                @foreach($segments as $index => $segment)
                <div class="row ">
                    <div class="font-bold cell">
                        {{ $segment }}
                    </div>
                    @foreach(array_keys($reversedProducts) as $date)
                        @if(array_key_exists($segment, $reversedProducts[$date]))
                        <div class="font-bold cell">
                            {{ number_format($reversedProducts[$date][$segment]) }}
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
                    @foreach(array_keys($reversedProducts) as $key => $date)
                        @if(array_key_exists($segment, $reversedProducts[$date]))
                        <div class="cell">
                            @if($key == 0)
                            0.0%
                            @else
                            {{ round(((($reversedProducts[$date][$segment] - $reversedProducts[array_keys($reversedProducts)[$key - 1]][$segment]) / $reversedProducts[$date][$segment]) * 100), 2).'%'}}
                            @endif
                        </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
            <div class="row ">
                <div class="font-bold cell">Total Revenues</div>
                @foreach(array_keys($reversedProducts) as $date)
                        <div class="font-bold cell">
                            {{ number_format(array_sum($reversedProducts[$date])) }}
                        </div>
                @endforeach
            </div>
            <div class="row row-sub">
                <div class="cell">% Change YoY</div>
                @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="cell">
                            @if($key == 0)
                            0.0%
                            @else
                            {{ round((((array_sum($reversedProducts[$date]) -  array_sum($reversedProducts[array_keys($reversedProducts)[$key-1]])) / array_sum($reversedProducts[$date])) * 100), 2).'%'}}
                            @endif
                        </div>
                @endforeach
            </div>
        </div>
        <div class="row row-spacer "></div>
        <div class="row-group row-head-fonts-sm table-header-border">
            <div class="row">
                <div class="font-bold cell">EBITDA</div>
                @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="font-bold cell">
                            {{number_format(explode('|', str_replace(',', '', $ebitda[$date][0]))[0])}}
                        </div>
                @endforeach
            </div>

            <div class="row row-sub">
                <div class="cell">% Change YoY</div>
                @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="cell">
                            @if($key == 0)
                            0.0%
                            @else
                            @php
                                $currentEbitDA = str_replace(',', '', explode('|', $ebitda[$date][0])[0]);
                                $previousEbitDA = str_replace(',', '', explode('|', $ebitda[array_keys($reversedProducts)[$key-1]][0])[0]);
                            @endphp
                            {{round(((($currentEbitDA - $previousEbitDA) / $previousEbitDA) * 100), 2)}}%
                            @endif
                        </div>
                @endforeach
            </div>

            <div class="row row-sub">
                <div class="cell">% Margins</div>
                @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="cell">
                            @if($key == 0)
                            0.0%
                            @else
                            @php
                                $currentEbitda = str_replace(',', '', explode('|', $ebitda[$date][0])[0]);
                                $currentRevenue = str_replace(',', '', explode('|', $revenues[$date][0])[0]);
                            @endphp
                            {{round(($currentRevenue/$currentEbitda), 2)}}
                            @endif
                        </div>
                @endforeach
            </div>
        </div>

        <div class="row row-spacer"></div>

        <div class="row-group row-head-fonts-sm table-header-border">
            <div class="row">
                <div class="font-bold cell">Adj. Net Income</div>
                @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="font-bold cell">
                            {{number_format(explode('|', str_replace(',', '', $adjNetIncome[$date][0]))[0])}}
                        </div>
                @endforeach
            </div>

            <div class="row row-sub">
                <div class="cell">% Change YoY</div>
                @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="cell">
                            @if($key == 0)
                            0.0%
                            @else
                            @php
                                $currentAdjNetIncome = str_replace(',', '', explode('|', $adjNetIncome[$date][0])[0]);
                                $previousAdjNetIncome = str_replace(',', '', explode('|', $adjNetIncome[array_keys($reversedProducts)[$key-1]][0])[0]);
                            @endphp
                            {{round(((($currentAdjNetIncome - $previousAdjNetIncome) / $previousAdjNetIncome) * 100), 2)}}%
                            @endif
                        </div>
                @endforeach
            </div>

            <div class="row row-sub">
                <div class="cell">% Margins</div>
                @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="cell">
                            @if($key == 0)
                            0.0%
                            @else
                            @php
                                $currentNetIncome = str_replace(',', '', explode('|', $adjNetIncome[$date][0])[0]);
                                $currentRevenue = str_replace(',', '', explode('|', $revenues[$date][0])[0]);
                            @endphp
                            {{round(($currentRevenue/$currentNetIncome), 2)}}%
                            @endif
                        </div>
                @endforeach
            </div>

            <div class="row row-sub">
                <div class="cell">Diluted Shares Out</div>
                @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="cell">
                           {{str_replace(',', '', explode('|', $dilutedSharesOut[$date][0])[0]);}}
                        </div>
                @endforeach
            </div>
            <div class="row row-sub">
                <div class="cell">% Change YoY</div>
                @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="cell">
                            @if($key == 0)
                            0.0%
                            @else
                            @php
                                $currentDilutedSharesOut = str_replace(',', '', explode('|', $dilutedSharesOut[$date][0])[0]);
                                $previousDilutedSharesOut = str_replace(',', '', explode('|', $dilutedSharesOut[array_keys($reversedProducts)[$key-1]][0])[0]);
                            @endphp
                            {{round(((($currentDilutedSharesOut - $previousDilutedSharesOut) / $previousDilutedSharesOut) * 100), 2)}}%
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
                    @foreach(array_keys($reversedProducts) as $key => $date)
                        <div class="font-bold cell">
                           {{str_replace(',', '', explode('|', $dilutedEPS[$date][0])[0]);}}
                        </div>
                    @endforeach
                </div>

                <div class="row row-sub">
                    <div class="font-bold cell">% Change YoY</div>
                    @foreach(array_keys($reversedProducts) as $key => $date)
                    <div class="cell">
                        @if($key == 0)
                        0.0%
                        @else
                        @php
                            $currentDilutedEPS = str_replace(',', '', explode('|', $dilutedEPS[$date][0])[0]);
                            $previousDilutedEPS = str_replace(',', '', explode('|', $dilutedEPS[array_keys($reversedProducts)[$key-1]][0])[0]);
                        @endphp
                        {{round(((($currentDilutedEPS - $previousDilutedEPS) / $previousDilutedEPS) * 100), 2)}}%
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
