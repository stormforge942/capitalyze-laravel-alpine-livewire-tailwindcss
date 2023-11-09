<div class="w-full">
    @if($noData)
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

    <div class="py-0 bg-gray-100">
        <div class="mx-auto">
            <div class="px-4 sm:pr-6 lg:pr-8 py-0 pl-0">
                <div class="mt-0 flow-root company-profile-loading overflow-x-hidden">
                    <div class="align-middle">
                        <div class="block min-w-full sm:rounded-lg">
                            <div class="py-0">
                                <div class="flex w-full justify-between items-center" >
                                    <div class="page-titles mt-2">
                                        <b class="company-name">{{ @$companyName }}  @if(@$ticker) ({{ @$ticker }}) @endif </b> <br>
                                        <span class="brr"></span>
                                        <b>${{ number_format($cost) }}</b>
                                        <small class="text-color-green">({{ $dynamic > 0 ? '+' : '-' }}{{ abs($dynamic) }}%)</small>
                                    </div>
                                    <div class="download-buttons-wrapper flex">
                                        <a class="download-button" href="#">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z" fill="#121A0F"/>
                                            </svg>
                                            Download PDF
                                        </a>
                                        <a class="download-button" href="#">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z" fill="#121A0F"/>
                                            </svg>
                                            Download Excel
                                        </a>
                                        <a class="download-button" href="#">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z" fill="#121A0F"/>
                                            </svg>
                                            Download CSV
                                        </a>
                                    </div>
                                </div>


                                <div class="flex w-full overflow-x-hidden">
                                    <div class="tabs-container w-full" style="overflow-x: auto; white-space: nowrap;">
                                        <ul class="tabs-wrapper flex">
                                            <li data-tab-index="0" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:text-[#828C85] px-6 tab active" wire:click="$emit('tabSubClicked', 'revenue')">Revenue</li>
                                            <li data-tab-index="0" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:text-[#828C85] px-6 tab" wire:click="$emit('tabSubClicked', 'efficiency')">Efficiency</li>
                                            <li data-tab-index="0" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:text-[#828C85] px-6 tab" wire:click="$emit('tabSubClicked', 'capital-allocation')">Capital Allocation</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="flex w-full overflow-x-hidden">
                                    <ul class="revenue-tab">
                                        <li class="active">Revenue by Product</li>
                                        <li>Revenue by Geography</li>
                                        <li>Revenue per Employee</li>
                                    </ul>
                                </div>

                                <div class="filters-row mb-3">
                                    <div class="select-wrapper flex items-center custom-text-xs">
                                        <div class="flex items-center text-sm">Unit Type
                                            <button type="submit" id="dropdownUnitTypeButton" data-dropdown-toggle="dropdown-UnitType" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="view" id="">
                                                {{$unitType}}
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                </svg>
                                            </button>
                                            <!-- Dropdown menu -->
                                            <div id="dropdown-UnitType" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                                                <div class="p-3 text-sm flex items-center justify-between">
                                                    <div>Unit Type</div>
                                                    <svg id="unitTypeClose" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                    </svg>
                                                </div>
                                                <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll" aria-labelledby="dropdownViewButton">
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="unitType" @if($view === 'None') checked @endif id="unitType-radio-1" name="unitType-radio" type="radio" value="None" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="unitType-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>None</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="unitType" @if($view === 'Thousands') checked @endif id="unitType-radio-1" name="unitType-radio" type="radio" value="Thousands" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="unitType-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Thousands</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="unitType" @if($view === 'Millions') checked @endif id="unitType-radio-2" name="unitType-radio" type="radio" value="Millions" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="unitType-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Millions</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="unitType" @if($view === 'Billions') checked @endif id="unitType-radio-3" name="unitType-radio" type="radio" value="Billions" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="unitType-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Billions</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="mx-3 my-4">
                                                    <button class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center" id="unitTypeCloseButton">Show Result</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex items-center text-sm">Order
                                            <button type="submit" id="dropdownOrderButton" data-dropdown-toggle="dropdown-Order" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="view" id="">
                                                {{($reverse ?? '') ? 'Latest on the Left' : 'Latest on the Right'}}
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                </svg>
                                            </button>
                                            <!-- Dropdown menu -->
                                            <div id="dropdown-Order" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                                                <div class="p-3 text-sm flex items-center justify-between">
                                                    <div>Order</div>
                                                    <svg id="orderClose" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                    </svg>
                                                </div>
                                                <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll" aria-labelledby="dropdownViewButton">
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:click="toggleReverse" @if($reverse === false) checked @endif id="order-radio-1" name="order-radio" type="radio" value="false" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="order-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Latest on the Right</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="reverse" @if($reverse) checked @endif id="order-radio-1" name="order-radio" type="radio" value="true" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="order-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Latest on the Left</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="mx-3 my-4">
                                                    <button class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center" id="orderCloseButton">Show Result</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex items-center text-sm">Freeze Panes
                                            <button type="submit" id="dropdownFreezePanesButton" data-dropdown-toggle="dropdown-FreezePanes" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="view" id="">
                                                {{$freezePanes}}
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                </svg>
                                            </button>
                                            <!-- Dropdown menu -->
                                            <div id="dropdown-FreezePanes" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                                                <div class="p-3 text-sm flex items-center justify-between">
                                                    <div>Freeze Panes</div>
                                                    <svg id="freezePanesClose" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                    </svg>
                                                </div>
                                                <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll" aria-labelledby="dropdownViewButton">
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="freezePanes" @if($view === 'Top Row') checked @endif id="freezePanes-radio-1" name="freezePanes-radio" type="radio" value="Top Row" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="freezePanes-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Top Row</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="freezePanes" @if($view === 'First Column') checked @endif id="freezePanes-radio-2" name="freezePanes-radio" type="radio" value="First Column" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="freezePanes-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>First Column</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="freezePanes" @if($view === 'Top Row & First Column') checked @endif id="freezePanes-radio-3" name="freezePanes-radio" type="radio" value="Top Row & First Column" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="freezePanes-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Top Row & First Column</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="mx-3 my-4">
                                                    <button class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center" id="freezePanesCloseButton">Show Result</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex items-center text-sm">Decimal
                                            <button type="submit" id="dropdownDecimalButton" data-dropdown-toggle="dropdown-Decimal" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="view" id="">
                                                {{$decimalDisplay == 2 ? '.00' : ($decimalDisplay == 3 ? '.000' : 'auto')}}
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                </svg>
                                            </button>
                                            <!-- Dropdown menu -->
                                            <div id="dropdown-Decimal" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                                                <div class="p-3 text-sm flex items-center justify-between">
                                                    <div>Decimal</div>
                                                    <svg id="decimalClose" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                    </svg>
                                                </div>
                                                <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll" aria-labelledby="dropdownViewButton">
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="decimalDisplay" @if($decimalDisplay === '0') checked @endif id="decimal-radio-1" name="decimal-radio" type="radio" value="0" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="decimal-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>auto</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="decimalDisplay" @if($decimalDisplay === '2') checked @endif id="decimal-radio-2" name="decimal-radio" type="radio" value="2" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="decimal-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>.00</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="decimalDisplay" @if($decimalDisplay === '3') checked @endif id="decimal-radio-3" name="decimal-radio" type="radio" value="3" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="decimal-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>.000</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="mx-3 my-4">
                                                    <button class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center" id="decimalCloseButton">Show Result</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filters-row flex items-center mt-2 text-sm">
                                    <b class="mr-3">Period Type:</b>
                                    <ul class="flex soft-radio-wrapper big-checked items-center">
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3 cursor-pointer">
                                                <input wire:model="period" value="arf5drs" id="date-fiscal-annual" type="radio" name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-2 ml-2 text-sm">Fiscal Annual</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3 cursor-pointer">
                                                <input wire:model="period" value="qrf5drs" id="date-fiscal-quaterly" type="radio"  name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-2 ml-2 text-sm">Fiscal Quaterly</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3 cursor-pointer">
                                                <input wire:model="period" value="fiscal-semi-annual" id="date-fiscal-semi-annual" type="radio"  name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-2 ml-2 text-sm">Fiscal Semi-Annual</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3 cursor-pointer">
                                                <input wire:model="period" value="YTD" id="date-YTD" type="radio"  name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-2 ml-2 text-sm">YTD</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3 cursor-pointer">
                                                <input wire:model="period" value="LTM" id="date-LTM" type="radio"  name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-2 ml-2 text-sm">LTM</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3 cursor-pointer">
                                                <input wire:model="period" value="annual" id="date-annual" id="date-annual" type="radio" name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-2 ml-2 text-sm">Calendar Annual</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3 cursor-pointer">
                                                <input wire:model="period" value="quarterly" id="date-quarterly" type="radio" name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-2 ml-2 text-sm">Calendar Quaterly</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3 cursor-pointer">
                                                <input wire:model="period" value="SA" id="date-SA" type="radio"  name="date-sa" class="w-5 h-5 ">
                                                <span class="w-full py-2 ml-2 text-sm">Calendar SA</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>

                                <div class="years-range-wrapper mt-4 mb-8" wire:ignore>
                                    <div class="dots-wrapper">
                                        @foreach($rangeDates as $key => $date)
                                            <span id="{{date('Y', strtotime($date))}}" class="inactive-dots"></span>
                                        @endforeach
                                    </div>
                                    <div id="range-slider-company-analysis" class="range-slider"></div>
                                </div>
                                <div>
                                    @livewire('company-analysis-graph', [
                                        'years' => $years,
                                        'minDate' => $minDate,
                                        'maxDate' => $maxDate,
                                        'ticker' => $ticker,
                                        'name' => $company->name,
                                        'products' => $products,
                                        'segments' => $segments
                                        ])
                                </div>
                                <div class="flex justify-end items-baseline">
                                    <span class="currency-font">Currency: &nbsp;</span>
                                    <select wire:model="currency" id="currency-select" class="inline-flex font-bold !pr-8 bg-transparent">
                                        <option value="USD">USD</option>
                                        <option value="CAD">CAD</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>
                                <div class="w-full">
                                    <div class="table-wrapper">
                                        <div class="table">
                                            <div class="row-group row-head-fonts-sm row-border-custom table-border-bottom">
                                                <div class="row row-head ">
                                                    <div class="cell font-bold">{{$companyName}} ({{$ticker}})</div>
                                                    @foreach ($this->selectedRange as $date)
                                                        <div class="cell font-bold">{{ $date }}</div>
                                                    @endforeach
                                                </div>
                                                @foreach ($segments as $index => $segment)
                                                    <div class="row ">
                                                        <div class="font-bold cell">
                                                            {{ $segment }}
                                                        </div>
                                                        @foreach ($this->selectedRange as $key => $date)
                                                            @if (array_key_exists($segment, $products[$date]))
                                                                <div class="font-bold cell">
                                                                    {{ number_format($products[$date][$segment]) }}
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="row row-sub">
                                                        <div class="cell">% Change YoY</div>
                                                        @foreach ($this->selectedRange as $key => $date)
                                                            @if (array_key_exists($segment, $products[$date]))
                                                                <div class="cell">
                                                                    @if ($key == 0)
                                                                        0.0%
                                                                    @else
                                                                        {{ round((($products[$date][$segment] - $products[$years[$key - 1]][$segment]) / $products[$date][$segment]) * 100, 2) . '%' }}
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="row row-sub">
                                                        <div class="cell">% of Total</div>
                                                        @foreach ($this->selectedRange as $key => $date)
                                                            @if (array_key_exists($segment, $products[$date]))
                                                                <div class="cell">
                                                                    {{ round((($products[$date][$segment] / array_sum($products[$date])) * 100), 2) }}%
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                    <div class="row row-spacer "></div>
                                                @endforeach
                                                <div class="row ">
                                                    <div class="font-bold cell">Total Revenues</div>
                                                    @foreach ($this->selectedRange as $date)
                                                        @if (array_key_exists($segment, $products[$date]))
                                                            <div class="font-bold cell">
                                                                {{ number_format(array_sum($products[$date])) }}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="row row-sub">
                                                    <div class="cell">% Change YoY</div>
                                                    @foreach ($this->selectedRange as $key => $date)
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
                                        </div>
                                    </div>
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
@push('scripts')
<script>
    let slideOpen = false;
    function generateRangeArray(inputArray) {
        if (inputArray.length !== 2) {
            return [];
        }

        let start = inputArray[0];
        let end = inputArray[1];
        let rangeArray = [];

        if (start <= end) {
            for (let i = start; i <= end; i++) {
                rangeArray.push(i);
            }
        } else {
            for (let i = start; i >= end; i--) {
                rangeArray.push(i);
            }
        }

        return rangeArray;
    }

    function recognizeDotsStatus(value, baseArray) {
        let base = generateRangeArray(baseArray)
        let activeYears = generateRangeArray(value)
        let intersection = base.filter(x => !activeYears.includes(x));

        activeYears.forEach(id => {
            let element = document.getElementById(id);
            if (element) {
                element.classList.add('active-dots');
                element.classList.remove('inactive-dots');
            }
        })

        intersection.forEach(id => {
            let element = document.getElementById(id);
            if (element) {
                element.classList.remove('active-dots');
                element.classList.add('inactive-dots');
            }
        })
    }

    document.addEventListener('DOMContentLoaded', function() {
        initChart()
        document.body.addEventListener('click', function(event) {
            var element = event.target;
            if (element.classList.contains('open-slide') && !slideOpen) {
                var value = element.dataset.value;
                value = JSON.parse(value);
                window.livewire.emit('slide-over.open', 'company-analysis-slide', value, {force: true});
                slideOpen = true;
            }
        });


        const el = document.querySelector('#range-slider-company-analysis');

        if(!el) {
            return;
        }

        const rangeDates = {!!json_encode($rangeDates)!!}
        let selectedValue = [];

        if (rangeDates.length > 0) {
            if(rangeDates[0] > rangeDates[rangeDates.length - 1]){
                rangeDates.reverse();
            }

            selectedValue = [rangeDates[0], rangeDates[rangeDates.length - 1]]
        }

        let rangeMin = new Date(selectedValue[0]).getFullYear();
        let rangeMax = selectedValue[1] ? new Date(selectedValue[1]).getFullYear() : new Date().getFullYear();
        selectedValue[0] = rangeMax - 6;
        selectedValue[1] = rangeMax;

        recognizeDotsStatus(selectedValue, [rangeMin, rangeMax]);

        rangeSlider(el, {
            step: 1,
            min: rangeMin,
            max: rangeMax,
            value: selectedValue,
            rangeSlideDisabled: true,
            onInput: (value) => {
                if (value.length === 2 && value !== selectedValue) {
                    recognizeDotsStatus(value, [rangeMin, rangeMax]);
                    Livewire.emit("dateChanged", value)
                }
            }
        });
    });

    Livewire.on('slide-over.close', () => {
        slideOpen = false;
    });

    const annualCheckbox = document.getElementById("date-annual");

    annualCheckbox.addEventListener("click", function() {
        const currentUrl = window.location.href;

        const separator = currentUrl.includes('?') ? '&' : '?';

        const newUrl = currentUrl + separator + 'period=annual';

        window.location.href = newUrl;
    });

    const quarterlyCheckbox = document.getElementById("date-quarterly");

    quarterlyCheckbox.addEventListener("click", function() {
        const currentUrl = window.location.href;

        const separator = currentUrl.includes('?') ? '&' : '?';

        const newUrl = currentUrl + separator + 'period=quarterly';

        window.location.href = newUrl;
    });

    const unitTypeDropdownCloseIcon = document.getElementById("unitTypeClose");

    unitTypeDropdownCloseIcon.addEventListener("click", function() {
        document.getElementById('dropdown-UnitType').classList.toggle("hidden");
    });
</script>
@endpush


