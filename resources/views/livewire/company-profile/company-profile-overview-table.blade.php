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
            <div class="row ">
                <div class="font-bold cell">EBIT</div>
                <div class="font-bold cell">15.4</div>
                <div class="font-bold cell">15.4</div>
                <div class="font-bold cell">15.4</div>
                <div class="font-bold cell">15.4</div>
                <div class="font-bold cell">15.4</div>
                <div class="font-bold cell">15.4</div>
            </div>

            <div class="row row-sub">
                <div class="cell">% Change YoY</div>
                <div class="cell">14.9%</div>
                <div class="cell">5.3%</div>
                <div class="cell">3.2%</div>
                <div class="cell">34.7%</div>
                <div class="cell">6.3%</div>
                <div class="cell">6.3%</div>
            </div>

            <div class="row row-sub">
                <div class="cell">% Margins</div>
                <div class="cell">14.9%</div>
                <div class="cell">5.3%</div>
                <div class="cell">3.2%</div>
                <div class="cell">34.7%</div>
                <div class="cell">6.3%</div>
                <div class="cell">6.3%</div>
            </div>

            <div class="row row-sub">
                <div class="cell">% Incremental Margins</div>
                <div class="cell">14.9%</div>
                <div class="cell">5.3%</div>
                <div class="cell">3.2%</div>
                <div class="cell">34.7%</div>
                <div class="cell">6.3%</div>
                <div class="cell">6.3%</div>
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
                    <div class="font-bold cell">0.09</div>
                    <div class="font-bold cell">0.09</div>
                    <div class="font-bold cell">0.09</div>
                    <div class="font-bold cell">0.09</div>
                    <div class="font-bold cell">0.09</div>
                    <div class="font-bold cell">6.3%</div>
                </div>

                <div class="row row-sub">
                    <div class="font-bold cell">% Change YoY</div>
                    <div class="cell">14.9%</div>
                    <div class="cell">5.3%</div>
                    <div class="cell">3.2%</div>
                    <div class="cell">34.7%</div>
                    <div class="cell">6.3%</div>
                    <div class="cell"></div>
                </div>
            </div>
        </div>
    </div>
</div>
