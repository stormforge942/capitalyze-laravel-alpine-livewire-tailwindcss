<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-8 2xl:col-span-9">
            <div class="bg-white rounded">
                <div class="flex items-center justify-between py-3 px-6 border-b">
                    <h3 class="text-md font-medium">Market Value Overtime</h3>

                    <select class="bg-gray-light rounded px-2.5 py-1.5">
                        <option value="" selected>This month</option>
                    </select>
                </div>
                <div class="p-6">
                    <div class="chart-here bg-gray-200 w-full h-80">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-4 2xl:col-span-3">
            <div class="bg-white p-6 rounded">
                <h3 class="text-blue text-sm mb-4 font-semibold">13F Holding Summary</h3>

                <div class="space-y-4">
                    @foreach ($activity as $key => $value)
                    <div class="flex gap-5 items-center justify-between">
                        <span class="text-sm">{{ Str::title($value->name_of_issuer) }} @if ($value->symbol)
                            ({{ $value->symbol }})
                            @endif
                        </span>
                        <span class="font-semibold">{{ number_format($value->weight, 2) }}%</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-center">
                    <a href="#" class="text-sm font-semibold hover:underline">
                        View All Holdings
                    </a>
                </div>
            </div>
        </div>

        <div class="col-span-6">
            <x-tabs :tabs="['Top Buys', 'Top Sells']" class="bg-white p-6 rounded">
                <div class="space-y-4" :class="active == 0 ? 'block' : 'hidden'">
                    <?php 
                        $topBuys = collect($topBuys);
                        $max = $topBuys->max('change_in_shares');
                        $min = $topBuys->min('change_in_shares');

                        $topBuys = $topBuys->map(function ($item, $key) use ($max, $min) {
                            $item->width = (($item->change_in_shares - $min) / ($max - $min)) * 80;
                            $item->width += 10;
                            return $item;
                        });
                    ?>

                    @foreach ($topBuys as $item)
                    <div class="grid grid-cols-12 items-center gap-4 ">
                        <div class="col-span-8 xl:col-span-9 px-2 py-1.5 bg-[#F0F6FF] rounded-[40px]">
                            <div class="h-2 rounded-[40px] bg-blue" style="width: {{ $item->width }}%">
                            </div>

                        </div>
                        <span class="col-span-4 xl:col-span-3 text-dark-light2">
                            {{ \Str::title($item->name_of_issuer) }}
                        </span>
                    </div>
                    @endforeach
                </div>

                <div class="space-y-4" :class="active == 1 ? 'block' : 'hidden'">
                    <?php 
                        $topSells = collect($topSells);
                        $max = $topSells->max('change_in_shares');
                        $min = $topSells->min('change_in_shares');
                        
                        $topSells = $topSells->map(function ($item, $key) use ($max, $min) {
                            $item->width = 90 - ((($item->change_in_shares - $min) / ($max - $min)) * 80);
                            return $item;
                        });
                    ?>

                    @foreach ($topSells as $item)
                    <div class="grid grid-cols-12 items-center gap-4 ">
                        <div class="col-span-8 xl:col-span-9 px-2 py-1.5 bg-[#F0F6FF] rounded-[40px]">
                            <div class="h-2 rounded-[40px] bg-blue" style="width: {{ $item->width }}%">
                            </div>

                        </div>
                        <span class="col-span-4 xl:col-span-3 text-dark-light2">
                            {{ \Str::title($item->name_of_issuer) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </x-tabs>
        </div>

        <div class="col-span-6">
            <div class="bg-white p-6 rounded">
                <x-tabs :tabs="['13F Sector Allocation Overtime', '13F Sector Allocation last Quarter']">
                    <div class="px-[15%] grid grid-cols-2" style="font-family: sans-serif">
                        <div>
                            <p class="text-dark-light2 text-md">Conversion Rate</p>
                            <p class="text-4xl font-semibold mt-3">9.74%</p>
                        </div>
                        <div class="flex items-center text-green font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 37 37"
                                fill="none">
                                <path
                                    d="M13.4388 16.4468C13.0024 16.8831 12.2949 16.8831 11.8585 16.4468C11.4222 16.0104 11.4222 15.3029 11.8585 14.8665L17.8181 8.90688C18.2545 8.47049 18.962 8.47049 19.3984 8.90688L25.358 14.8665C25.7944 15.3029 25.7944 16.0104 25.358 16.4468C24.9216 16.8831 24.2141 16.8831 23.7777 16.4468L19.7257 12.3947L19.7257 26.8309C19.7257 27.448 19.2254 27.9483 18.6083 27.9483C17.9911 27.9483 17.4908 27.448 17.4908 26.8309L17.4908 12.3947L13.4388 16.4468Z"
                                    fill="#0FAF62" />
                            </svg>

                            <span>3.5% Increase</span>
                        </div>
                    </div>
                </x-tabs>
            </div>
        </div>

        <div class="col-span-6">
            <div class="bg-white p-6 rounded">
                <h3 class="text-blue text-sm mb-4 font-semibold">13F Activity</h3>

                <div class="grid grid-cols-2 2xl:grid-cols-4 gap-4">
                    @foreach($summary as $key => $value)
                    <div>
                        <p class="text-dark-light2 text-sm">{{ str_replace('_', ' ', Str::title($key)) }}</p>

                        <p class="font-semibold">
                            @if(Str::startsWith($value, 'https'))
                            <a href="{{ $value }}" class="underline text-blue" target="_blank">{{
                                getSiteNameFromUrl($value) }}</a>
                            @else
                            {{ $value }}
                            @endif
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>