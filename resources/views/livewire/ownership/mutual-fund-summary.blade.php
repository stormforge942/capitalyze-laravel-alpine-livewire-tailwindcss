<?php
$ranges = ['3m' => '3m', '6m' => '6m', 'ytd' => 'YTD', '1yr' => '1yr', '5yr' => '5yr', 'max' => 'MAX'];
?>

{{-- Check resources/views/livewire/ownership/mutual-fund.blade.php for js code --}}
<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="order-1 col-span-12 xl:col-span-6">
            <div class="bg-white rounded h-full flex flex-col">
                <div class="px-6 py-3 border-b">
                    <h3 class="font-medium text-md">Market Value Overtime</h3>
                </div>
                <div class="p-6 flex-1">
                    <x-defer-data-loading on-init="getOverTimeMarketValue" class="h-80">
                        <div class="h-full xl:max-h-[350px]">
                            <canvas id="overTimeMarketValue"></canvas>
                        </div>
                    </x-defer-data-loading>
                </div>
            </div>
        </div>

        <div class="order-2 col-span-12 xl:col-span-6 p-6 bg-white rounded">
            <x-tabs :tabs="['NPORT-P Sector Allocation Overtime', 'NPORT-P Sector Allocation last Quarter']">
                <x-defer-data-loading use-alpine="true" on-init="getSectorAllocationData" class="h-80"
                    @ready="$nextTick(() => {
                        renderLastQuarterSectorAllocation(result.lastQuarterSectorAllocation);
                    })">
                    <div :class="active == 0 ? 'block' : 'hidden'" x-data="{
                        showLabel: false,
                        period: '5yr',
                        init() {
                            this.renderChart();
                    
                            this.$watch('period', () => {
                                this.renderChart();
                            });
                        },
                        renderChart() {
                        console.log(result.overTimeSectorAllocation);
                        
                            const data = result.overTimeSectorAllocation.map(item => ({
                                ...item,
                                data: item.data.filter(item => item.periods.includes(this.period))
                            }))
                    
                            renderOverTimeSectorAllocation(data);
                        }
                    }">
                        <div class="flex items-center justify-between gap-x-6 my-6">
                            <div class="flex items-center flex-wrap gap-x-4 gap-y-2 text-gray-medium2">
                                @foreach ($ranges as $value => $label)
                                    <label class="cursor-pointer flex items-center gap-x-1">
                                        <input type="radio" name="otsa-period" value="{{ $value }}"
                                            class="custom-radio custom-radio-xs focus:ring-0 border-gray-medium2"
                                            x-model="period">
                                        <span
                                            :class="period === '{{ $value }}' ? 'text-dark' : ''">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="flex items-center gap-x-5 justify-between" x-cloak>
                                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                    <input type="checkbox" value="yes" class="sr-only peer" :checked="showLabel"
                                        @change="showLabel = $event.target.checked">
                                    <div
                                        class="w-6 h-2.5 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:-start-[4px] after:bg-white after:rounded-full after:h-4 after:w-4 after:shadow-md after:transition-all peer-checked:bg-dark-light2 peer-checked:after:bg-dark">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900">Show Labels</span>
                                </label>
                            </div>
                        </div>
                        <div class="h-[280px]">
                            <canvas id="overTimeSectorAllocation"></canvas>
                        </div>
                        <div x-show="showLabel" x-cloak>
                            <div class="mt-4 px-5" id="otsa-legend"></div>
                        </div>
                    </div>

                    <div :class="active == 1 ? 'block' : 'hidden'" x-data="{ showLabel: false }" x-cloak>
                        <div class="flex flex-row-reverse my-6">
                            <div class="flex items-center gap-x-5 justify-between" x-cloak>
                                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                    <input type="checkbox" value="yes" class="sr-only peer" :checked="showLabel"
                                        @change="showLabel = $event.target.checked">
                                    <div
                                        class="w-6 h-2.5 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:-start-[4px] after:bg-white after:rounded-full after:h-4 after:w-4 after:shadow-md after:transition-all peer-checked:bg-dark-light2 peer-checked:after:bg-dark">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900">Show Labels</span>
                                </label>
                            </div>
                        </div>
                        <div class="h-[280px]">
                            <canvas id="lastQuarterSectorAllocation"></canvas>
                        </div>
                        <div x-show="showLabel" x-cloak>
                            <div class="mt-4 px-5" id="lqsa-legend"></div>
                        </div>
                    </div>
                </x-defer-data-loading>
            </x-tabs>
        </div>

        <div class="order-3 col-span-12 xl:col-span-9 2xl:col-span-8 p-6 bg-white rounded">
            <x-tabs :tabs="['Top Buys', 'Top Sells']">
                <x-defer-data-loading use-alpine="true" on-init="getTopBuySells" class="h-80">
                    <div class="space-y-4" :class="active == 0 ? 'block' : 'hidden'" :data-active="active">
                        <template x-for="item in result.topBuys" :key="item.key">
                            <div class="grid items-center grid-cols-12 gap-4">
                                <div class="cursor-pointer col-span-8 xl:col-span-9 px-2 py-1.5 bg-[#F0F6FF] rounded-[40px]"
                                    :title="item.change_in_balance">
                                    <div class="h-2 rounded-[40px] bg-blue" :style="`width: ${item.width}%`">
                                    </div>
                                </div>
                                <span
                                    class="col-span-4 xl:col-span-3 text-dark-light2 overflow-hidden text-ellipsis whitespace-nowrap"
                                    x-text="item.name" :title="item.name">
                                </span>
                            </div>
                        </template>
                    </div>

                    <div class="space-y-4" :class="active == 1 ? 'block' : 'hidden'">
                        <template x-for="item in result.topSells" :key="item.key">
                            <div class="grid items-center grid-cols-12 gap-4 ">
                                <div class="cursor-pointer col-span-8 xl:col-span-9 px-2 py-1.5 bg-[#F0F6FF] rounded-[40px]"
                                    :title="item.change_in_balance">
                                    <div class="h-2 rounded-[40px] bg-blue" :style="`width: ${item.width}%`">
                                    </div>
                                </div>
                                <span
                                    class="col-span-4 xl:col-span-3 text-dark-light2 overflow-hidden text-ellipsis whitespace-nowrap"
                                    x-text="item.name" :title="item.name">
                                </span>
                            </div>
                        </template>
                    </div>
                </x-defer-data-loading>
            </x-tabs>
        </div>

        <div class="order-4 col-span-12 xl:col-span-3 2xl:col-span-4 p-6 bg-white rounded">
            <h3 class="mb-4 text-sm font-semibold text-blue">NPORT-P Holding Summary</h3>

            <x-defer-data-loading use-alpine="true" on-init="getHoldingSummary" class="h-32">
                <div class="space-y-4" :data-result="JSON.stringify(result)">
                    <template x-for="(item, idx) in result" :key="idx">
                        <div class="flex items-center justify-between gap-5">
                            <span class="text-sm" x-text="item.name"></span>
                            <span class="font-semibold" x-text="`${item.weight}%`"></span>
                        </div>
                    </template>
                </div>

                <template x-if="result?.length == 7">
                    <div class="flex justify-center mt-6">
                        <a href="#" class="text-xs+ font-semibold bg-green-light4 px-4 py-1 rounded"
                            @click.prevent="changeTab('holdings')">
                            View All Holdings
                        </a>
                    </div>
                </template>
            </x-defer-data-loading>
        </div>

        <div class="order-5 col-span-12">
            <div class="p-6 bg-white rounded xl:inline-block">
                <h3 class="mb-4 text-sm font-semibold text-blue">NPORT-P Activity</h3>

                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                    @foreach ($summary as $item)
                        <div>
                            <p class="text-sm text-dark-light2 whitespace-nowrap">{{ $item['title'] }}</p>

                            <p class="font-semibold">
                                @if ($item['type'] === 'link')
                                    <a href="{{ $item['value'] }}" class="underline text-blue"
                                        target="_blank">{{ $item['value'] }}</a>
                                @else
                                    <span>{{ $item['value'] }}</span>
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
