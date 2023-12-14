<div class="w-full">
    @if ($noData)
        <div class="py-12">
            <div class="mx-auto flex">
                <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-1/2 md:mx-auto">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">No data available</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="py-0 bg-gray-100" x-data="{ currentTab: 'revenue-by-product' }">
            <div class="mx-auto">
                <div class="px-4 sm:pr-6 lg:pr-8 py-0 pl-0">
                    <div class="mt-0 flow-root company-profile-loading overflow-x-hidden">
                        <div class="align-middle">
                            <div class="block min-w-full sm:rounded-lg">
                                <div class="py-0">
                                    <x-company-info-header :company="['name' => $company->name, 'ticker' => $company->ticker]">
                                        <x-download-data-buttons />
                                    </x-company-info-header>


                                    <div class="flex w-full overflow-x-hidden">
                                        <div class="tabs-container w-full"
                                            style="overflow-x: auto; white-space: nowrap;">
                                            <ul class="tabs-wrapper flex">
                                                <li data-tab-index="0"
                                                    class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:text-[#828C85] px-6 tab active">
                                                    Revenue</li>
                                                <li data-tab-index="0"
                                                    class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:text-[#828C85] px-6 tab">
                                                    Efficiency</li>
                                                <li data-tab-index="0"
                                                    class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:text-[#828C85] px-6 tab">
                                                    Capital Allocation</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="flex w-full overflow-x-hidden">
                                        <ul class="revenue-tab">
                                            <li @click="currentTab = 'revenue-by-product'"
                                                :class="currentTab == 'revenue-by-product' ? 'active' : ''">Revenue by
                                                Product</li>
                                            <li @click="currentTab = 'revenue-by-geography'"
                                                :class="currentTab == 'revenue-by-geography' ? 'active' : ''">Revenue by
                                                Geography</li>
                                            <li @click="currentTab = 'revenue-by-employee'"
                                                :class="currentTab == 'revenue-by-employee' ? 'active' : ''">Revenue per
                                                Employee</li>
                                        </ul>
                                    </div>
                                    <div x-show="currentTab == 'revenue-by-product'">
                                        @livewire('revenue-by-product', [
                                            'company' => $company,
                                            'companyName' => $companyName,
                                            'ticker' => $ticker,
                                            'cost' => $cost,
                                            'period' => $period,
                                        ])
                                    </div>
                                    <div x-show="currentTab == 'revenue-by-geography'">
                                        @livewire('revenue-by-geography', [
                                            'company' => $company,
                                            'companyName' => $companyName,
                                            'ticker' => $ticker,
                                            'cost' => $cost,
                                            'period' => $period,
                                        ])
                                    </div>
                                    <div x-show="currentTab == 'revenue-by-employee'">
                                        @livewire('revenue-by-employee', [
                                            'company' => $company,
                                            'companyName' => $companyName,
                                            'ticker' => $ticker,
                                            'cost' => $cost,
                                            'period' => $period,
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
