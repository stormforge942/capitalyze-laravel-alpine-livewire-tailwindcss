{{-- Check resources/views/livewire/ownership/company-fund.blade.php for js code --}}
<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xl:col-span-8 2xl:col-span-9 order-1">
            <div class="bg-white rounded">
                <div class="py-3 px-6 border-b">
                    <h3 class="text-md font-medium">Market Value Overtime</h3>
                </div>
                <div class="p-6">
                    <x-defer-data-loading on-init="getOverTimeMarketValue" class="h-80">
                        <canvas id="overTimeMarketValue"></canvas>
                    </x-defer-data-loading>
                </div>
            </div>
        </div>

        <div class="col-span-6 xl:col-span-4 2xl:col-span-3 order-3 xl:order-2">
            <div class="bg-white p-6 rounded">
                <h3 class="text-blue text-sm mb-4 font-semibold">13F Holding Summary</h3>

                <x-defer-data-loading use-alpine="true" on-init="getHoldingSummary" class="h-32">
                    <div class="space-y-4">
                        <template x-for="item in result">
                            <div class="flex gap-5 items-center justify-between">
                                <span class="text-sm" x-text="item.name"></span>
                                <span class="font-semibold" x-text="`${item.weight}%`"></span>
                            </div>
                        </template>
                    </div>

                    <template x-if="result?.length == 5">
                        <div class="mt-6 flex justify-center">
                            <a href="#" class="text-sm font-semibold hover:underline">
                                View All Holdings
                            </a>
                        </div>
                    </template>
                </x-defer-data-loading>
            </div>
        </div>

        <div class="col-span-6 order-2 xl:order-3">
            <x-tabs :tabs="['Top Buys', 'Top Sells']" class="bg-white p-6 rounded">
                <x-defer-data-loading use-alpine="true" on-init="getTopBuySells" class="h-80">
                    <div class="space-y-4" :class="active == 0 ? 'block' : 'hidden'" :data-active="active">
                        <template x-for="item in result.topBuys">
                            <div class="grid grid-cols-12 items-center gap-4 ">
                                <div class="col-span-8 xl:col-span-9 px-2 py-1.5 bg-[#F0F6FF] rounded-[40px]">
                                    <div class="h-2 rounded-[40px] bg-blue" :style="`width: ${item.width}%`">
                                    </div>
                                </div>
                                <span class="col-span-4 xl:col-span-3 text-dark-light2" x-text="item.name_of_issuer">
                                </span>
                            </div>
                        </template>
                    </div>

                    <div class="space-y-4" :class="active == 1 ? 'block' : 'hidden'">
                        <template x-for="item in result.topSells">
                            <div class="grid grid-cols-12 items-center gap-4 ">
                                <div class="col-span-8 xl:col-span-9 px-2 py-1.5 bg-[#F0F6FF] rounded-[40px]">
                                    <div class="h-2 rounded-[40px] bg-blue" :style="`width: ${item.width}%`">
                                    </div>
                                </div>
                                <span class="col-span-4 xl:col-span-3 text-dark-light2" x-text="item.name_of_issuer">
                                </span>
                            </div>
                        </template>
                    </div>
                </x-defer-data-loading>
            </x-tabs>
        </div>

        <div class="col-span-12 xl:col-span-6 order-4">
            <div class="bg-white p-6 rounded">
                <x-tabs :tabs="['13F Sector Allocation Overtime', '13F Sector Allocation last Quarter']">
                    <x-defer-data-loading use-alpine="true" on-init="getSectiorAllocationData" class="h-80"
                        @ready="$nextTick(() => {
                            renderOverTimeSectorAllocation(result.overTimeSectorAllocation);
                            renderLastQuarterSectorAllocation(result.lastQuarterSectorAllocation);
                        })">
                        <div :class="active == 0 ? 'block' : 'hidden'">
                            <div class="mt-14 mb-16 grid grid-cols-2 items-start" style="font-family: 'Public Sans', sans-serif">
                                <div>
                                    <p class="text-dark-light2 text-md uppercase">Conversion Rate</p>
                                    <p class="text-4xl font-semibold mt-3">
                                        <span x-text="result.conversionRate"></span>%
                                    </p>
                                </div>
                                <div class="flex items-center"
                                    :class="result.sectorAllocationChangePercentage < 0 ? 'text-danger' : 'text-green'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37"
                                        viewBox="0 0 37 37" fill="none"
                                        :class="result.sectorAllocationChangePercentage < 0 ? 'rotate-180' : ''">
                                        <path
                                            d="M13.4388 16.4468C13.0024 16.8831 12.2949 16.8831 11.8585 16.4468C11.4222 16.0104 11.4222 15.3029 11.8585 14.8665L17.8181 8.90688C18.2545 8.47049 18.962 8.47049 19.3984 8.90688L25.358 14.8665C25.7944 15.3029 25.7944 16.0104 25.358 16.4468C24.9216 16.8831 24.2141 16.8831 23.7777 16.4468L19.7257 12.3947L19.7257 26.8309C19.7257 27.448 19.2254 27.9483 18.6083 27.9483C17.9911 27.9483 17.4908 27.448 17.4908 26.8309L17.4908 12.3947L13.4388 16.4468Z"
                                            fill="#0FAF62" />
                                    </svg>

                                    <p class="font-medium"><span x-text="result.sectorAllocationChangePercentage"></span>% Increase</p>
                                </div>
                            </div>

                            <canvas id="overTimeSectorAllocation"></canvas>
                        </div>

                        <div :class="active == 1 ? 'block' : 'hidden'">
                            <canvas id="lastQuarterSectorAllocation" class="mx-auto"></canvas>
                        </div>
                    </x-defer-data-loading>
                </x-tabs>
            </div>
        </div>

        <div class="col-span-12 xl:col-span-6 order-5">
            <div class="bg-white p-6 rounded">
                <h3 class="text-blue text-sm mb-4 font-semibold">13F Activity</h3>

                <x-defer-data-loading use-alpine="true" on-init="getSummary" class="h-48">
                    <div class="grid grid-cols-5 xl:grid-cols-2 2xl:grid-cols-4 gap-4">
                        <template x-for="item in result">
                            <div>
                                <p class="text-dark-light2 text-sm" x-text="item.title"></p>

                                <p class="font-semibold">
                                    <template x-if="item.type === 'link'">
                                        <a :href="item.value" class="underline text-blue" target="_blank"
                                            x-text="item.value"></a>
                                    </template>
                                    <template x-if="item.type === 'text'">
                                        <span x-text="item.value"></span>
                                    </template>
                                </p>
                            </div>
                        </template>
                    </div>
                </x-defer-data-loading>
            </div>
        </div>
    </div>
</div>
