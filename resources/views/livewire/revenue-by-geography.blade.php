<div>
    <div class="filters-row bg-white py-3 px-4  rounded-lg mb-7 custom__border_gray">
        <div class="select-wrapper flex gap-x-4 items-center custom-text-xs">
            <div class="flex items-center text-sm" x-data="{unitType: null, unitTypeSelectorOpen: false}" @click.away="unitTypeSelectorOpen = false">Unit Type
                <div class="relative">
                    <button :class="[unitType != null ? 'active' : '', unitTypeSelectorOpen ? 'down' : '']" @click="unitTypeSelectorOpen = !unitTypeSelectorOpen"
                        class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2 flowbite_btn"
                        name="view" id="">
                        <span
                            x-text="(unitType == 0 || unitType == null) ? 'None' : (unitType == 'thousands' ? 'Thousands' : (unitType == 'millions' ? 'Millions' : (unitType == 'billions' ? 'Billions' : '')))"></span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                fill="#121A0F" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div x-show="unitTypeSelectorOpen" wire:ignore
                        class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                        <div class="p-3 text-base flex items-center justify-between font-medium">
                            <div>Unit Type</div>
                            <svg id="unitTypeClose" class="cursor-pointer" width="24" height="24" viewBox="0 0 24 24" fill="none" @click="unitTypeSelectorOpen = false"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                    fill="#686868" />
                            </svg>
                        </div>
                        <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll"
                            aria-labelledby="dropdownViewButton">
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click="unitType = 0" id="{{$chartId}}UnitType-radio-1" name="unitType-radio"
                                            type="radio" value="None"
                                            class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}UnitType-radio-1"
                                            class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>None</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click="unitType = 'thousands'" id="{{$chartId}}UnitType-radio-2" name="unitType-radio"
                                            type="radio" value="Thousands"
                                            class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}UnitType-radio-2"
                                            class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>Thousands</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click="unitType = 'millions'" id="{{$chartId}}UnitType-radio-3" name="unitType-radio"
                                            type="radio" value="Millions"
                                            class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}UnitType-radio-3"
                                            class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>Millions</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click="unitType = 'billions'" id="{{$chartId}}UnitType-radio-4" name="unitType-radio"
                                            type="radio" value="Billions"
                                            class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}UnitType-radio-4"
                                            class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>Billions</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="mx-3 my-4">
                            <button class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="unitTypeCloseButton"
                                @click="{{$chartId}}SetUnitType(unitType); unitTypeSelectorOpen=false;">Show Result</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ml-3 flex items-center text-sm" x-data="{reverseOrder:null, reverseOrderSelectorOpen: false}" @click.away="reverseOrderSelectorOpen = false">Order
                <div class="relative">
                    <button @click="reverseOrderSelectorOpen = !reverseOrderSelectorOpen" :class="[reverseOrder != null ? 'active' : '', reverseOrderSelectorOpen ? 'down' : '']"
                    class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2 flowbite_btn"
                    name="view" id="">
                    <span x-text="reverseOrder == null ? 'Latest on Right' : 'Latest on Left'"></span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div x-show="reverseOrderSelectorOpen" wire:ignore
                    class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                    <div class="p-3 text-base flex items-center justify-between font-medium">
                        <div>Order</div>
                        <svg id="orderClose" class="cursor-pointer" width="24" height="24" viewBox="0 0 24 24" fill="none" @click="reverseOrderSelectorOpen = false"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                fill="#686868" />
                        </svg>
                    </div>
                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll"
                        aria-labelledby="dropdownViewButton">
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="reverseOrder = false" checked id="{{$chartId}}order-radio-1" name="order-radio"
                                        type="radio"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 w-full text-sm cursor-pointer">
                                    <label for="{{$chartId}}order-radio-1"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Latest on the Right</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="reverseOrder = true" id="{{$chartId}}order-radio-2" name="order-radio"
                                        type="radio"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 w-full text-sm cursor-pointer">
                                    <label for="{{$chartId}}order-radio-2"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Latest on the Left</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="mx-3 my-4">
                        <button @click="{{$chartId}}SetReverseOrder(reverseOrder);reverseOrderSelectorOpen=false"
                            class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="orderCloseButton">Show
                            Result</button>
                    </div>
                </div>
                </div>
            </div>
            <div class="ml-3 flex items-center text-sm" x-data="{freezePans: null, freezePanSelectorOpen: false}" @click.away="freezePanSelectorOpen = false">Freeze Panes
                <div class="relative">
                    <button type="submit" :class="[freezePans != null ? 'active' : '', freezePanSelectorOpen ? 'down' : '']" @click="freezePanSelectorOpen = !freezePanSelectorOpen"
                    class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2 flowbite_btn"
                    name="view" id="">
                    Top Row
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div x-show="freezePanSelectorOpen"
                    class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                    <div class="p-3 text-base flex items-center justify-between font-medium">
                        <div>Freeze Panes</div>
                        <svg id="freezePanesClose" class="cursor-pointer" width="24" height="24" viewBox="0 0 24 24" fill="none" @click="freezePanSelectorOpen = false"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                fill="#686868" />
                        </svg>
                    </div>
                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll"
                        aria-labelledby="dropdownViewButton">
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click='freezePans = "Top Row"'
                                        id="{{$chartId}}freezePanes-radio-1" name="freezePanes-radio" type="radio" value="Top Row"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 w-full text-sm cursor-pointer">
                                    <label for="{{$chartId}}freezePanes-radio-1"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Top Row</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click='freezePans = "First Column"'
                                        id="{{$chartId}}freezePanes-radio-2" name="freezePanes-radio" type="radio"
                                        value="First Column"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 w-full text-sm cursor-pointer">
                                    <label for="{{$chartId}}freezePanes-radio-2"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>First Column</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input id="{{$chartId}}freezePanes-radio-3" name="freezePanes-radio" type="radio" @click='freezePans = "Top Row & First Column"'
                                        value="Top Row & First Column"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 w-full text-sm cursor-pointer">
                                    <label for="{{$chartId}}freezePanes-radio-3"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Top Row & First Column</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="mx-3 my-4">
                        <button class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center"
                            id="freezePanesCloseButton" @click="{{$chartId}}SetFreezePans(freezePans);freezePanSelectorOpen=false">Show Result</button>
                    </div>
                </div>
                </div>
            </div>
            <div wire:ignore class="ml-3 flex items-center text-sm" x-data="{round: null, roundSelectorOpen: false}" @click.away="roundSelectorOpen = false">Decimal
                <div class="relative">
                    <button :class="[round != null ? 'active' : '', roundSelectorOpen ? 'down' : '']" @click="roundSelectorOpen = !roundSelectorOpen"
                        class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2 flowbite_btn"
                        name="view" id="">
                        <span x-text='(round == null || round == 0)? "auto" : (round == 2 ? ".00" : (round == 3 ? ".000" : ""))' ></span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                fill="#121A0F" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div x-show="roundSelectorOpen"
                        class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                        <div class="p-3 text-base flex items-center justify-between font-medium">
                            <div>Decimal</div>
                            <svg id="decimalClose" class="cursor-pointer" width="24" height="24" viewBox="0 0 24 24" fill="none" @click="roundSelectorOpen = false"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                    fill="#686868" />
                            </svg>
                        </div>
                        <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll"
                            aria-labelledby="dropdownViewButton">
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click="round=0" :checked="round==0" id="{{$chartId}}decimal-radio-1"
                                            name="decimal-radio" type="radio" value="0"
                                            class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label @click="round=0" for="{{$chartId}}decimal-radio-1"
                                            class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>auto</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click="round=2" :checked="round==2" id="{{$chartId}}decimal-radio-2"
                                            name="decimal-radio" type="radio" value="2"
                                            class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label @click="round=2" for="{{$chartId}}decimal-radio-2"
                                            class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>.00</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click="round=3" :checked="round==3" id="{{$chartId}}decimal-radio-3"
                                            name="decimal-radio" type="radio" value="3"
                                            class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label @click="round=3" for="{{$chartId}}decimal-radio-3"
                                            class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>.000</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="mx-3 my-4">
                            <button class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="decimalCloseButton"
                                @click="{{$chartId}}SetRound(round);roundSelectorOpen=false">Show Result</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore class="filters-row flex items-center mt-2 text-sm">
        <b class="mr-3">Period Type:</b>
        <ul class="flex soft-radio-wrapper big-checked items-center">
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input  value="fiscal-annual" id="{{$chartId}}date-fiscal-annual" type="radio"
                        name="date-range" class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Fiscal Annual</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input  value="fiscal-quarterly" id="{{$chartId}}date-fiscal-quaterly" type="radio"
                        name="date-range" class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Fiscal Quaterly</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input  value="fiscal-semi-annual" id="{{$chartId}}date-fiscal-semi-annual" type="radio"
                        name="date-range" class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Fiscal Semi-Annual</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input  value="YTD" id="{{$chartId}}date-YTD" type="radio" name="date-range"
                        class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">YTD</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input  value="LTM" id="{{$chartId}}date-LTM" type="radio" name="date-range"
                        class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">LTM</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input  value="annual" id="{{$chartId}}date-annual"type="radio"
                        name="date-range" class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Calendar Annual</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input  value="quarterly" id="{{$chartId}}date-quarterly" type="radio" name="date-range"
                        class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Calendar Quaterly</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input  value="SA" id="{{$chartId}}date-SA" type="radio" name="date-sa" class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Calendar SA</span>
                </label>
            </li>
        </ul>
    </div>

    <div class="years-range-wrapper mt-4 mb-8" wire:ignore>
        <div class="dots-wrapper">
            @foreach(array_reverse($rangeDates) as $key => $date)
            <span id="{{$chartId}}{{date('Y', strtotime($date))}}" class="inactive-dots"></span>
            @endforeach
        </div>
        <div id="{{$chartId}}range-slider-company-analysis" class="range-slider" x-init='() => {
            const {{$chartId}}el = document.querySelector("#{{$chartId}}range-slider-company-analysis");
            if(!{{$chartId}}el) {
                return;
            }
            const {{$chartId}}rangeDates = {!!json_encode($rangeDates)!!}
            let {{$chartId}}selectedValue = [];

            if ({{$chartId}}rangeDates.length > 0) {
                if({{$chartId}}rangeDates[0] > {{$chartId}}rangeDates[{{$chartId}}rangeDates.length - 1]){
                    {{$chartId}}rangeDates.reverse();
                }
                {{$chartId}}selectedValue = [{{$chartId}}rangeDates[0], {{$chartId}}rangeDates[{{$chartId}}rangeDates.length - 1]]
            }
            let {{$chartId}}rangeMin = new Date({{$chartId}}selectedValue[0]).getFullYear();
            let {{$chartId}}rangeMax = {{$chartId}}selectedValue[1] ? new Date({{$chartId}}selectedValue[1]).getFullYear() : new Date().getFullYear();
            {{$chartId}}selectedValue[0] = {{$chartId}}rangeMin
            {{$chartId}}selectedValue[1] = {{$chartId}}rangeMax;
            {{$chartId}}recognizeDotsStatus({{$chartId}}selectedValue, [{{$chartId}}rangeMin, {{$chartId}}rangeMax]);
            rangeSlider({{$chartId}}el, {
                step: 1,
                min: {{$chartId}}rangeMin,
                max: {{$chartId}}rangeMax,
                value: {{$chartId}}selectedValue,
                rangeSlideDisabled: true,
                onInput: (value, e) => {
                    if (value.length === 2 && value !== {{$chartId}}selectedValue) {
                        {{$chartId}}recognizeDotsStatus(value, [{{$chartId}}rangeMin, {{$chartId}}rangeMax]);
                        Livewire.emit("{{$chartId}}AnalysisDatesChanged", value)
                    }
                },
            });
            function {{$chartId}}generateRangeArray(inputArray) {
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
            function {{$chartId}}recognizeDotsStatus(value, baseArray) {
                    let {{$chartId}}base = {{$chartId}}generateRangeArray(baseArray)
                    let {{$chartId}}activeYears = {{$chartId}}generateRangeArray(value)
                    let {{$chartId}}intersection = {{$chartId}}base.filter(x => !{{$chartId}}activeYears.includes(x));

                    {{$chartId}}activeYears.forEach(id => {
                        let {{$chartId}}element = document.getElementById("{{$chartId}}" +id);
                        if ({{$chartId}}element) {
                            {{$chartId}}element.classList.add("active-dots");
                            {{$chartId}}element.classList.remove("inactive-dots");
                        }
                    })

                    {{$chartId}}intersection.forEach(id => {
                        let {{$chartId}}element = document.getElementById("{{$chartId}}" + id);
                        if ({{$chartId}}element) {
                            {{$chartId}}element.classList.remove("active-dots");
                            {{$chartId}}element.classList.add("inactive-dots");
                        }
                    })
                }
        }'></div>
    </div>
    <div x-data="{ rbgshowgraph: true }" wire:ignore>
        <div class="flex justify-end" x-show="!rbgshowgraph" @click="rbgshowgraph = true">
            <button class="show-hide-chart-btn">
                Show Chart
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                        fill="#121A0F" />
                </svg>
            </button>
        </div>
        @livewire('company-analysis-graph', [
        'years' => $years,
        'minDate' => $minDate,
        'maxDate' => $maxDate,
        'ticker' => $ticker,
        'name' => $company->name,
        'products' => $products,
        'segments' => $segments,
        'period' => $period,
        'chartData' => $chartData,
        'chartId' => 'rbg',
        'title' => 'Revenue by Geographys'
        ], key(uniqid()))
    </div>
    <div class="w-full">
        <div class="table-wrapper">
            <div class="table">
                <div class="row-group row-head-fonts-sm row-border-custom table-border-bottom">
                    <div class="row row-head">
                        <div class="cell font-bold min-64">{{$companyName}} ({{$ticker}})</div>
                        @foreach ($this->selectedRange as $date)
                        <div class="cell font-bold">{{ $date }}</div>
                        @endforeach
                    </div>
                    @foreach ($segments as $index => $segment)
                    <div class="row ">
                        <div class="font-bold cell min-64">
                            {{ str_replace('[Member]', '', $segment) }}
                        </div>
                        @foreach ($this->selectedRange as $key => $date)
                        @if (array_key_exists($segment, $products[$date]))
                        <div class="font-bold cell">
                            @if($this->selectedUnit == 0)
                            {{ number_format($products[$date][$segment]) }}
                            @elseif($this->selectedUnit == 'thousands')
                            {{ number_format($products[$date][$segment]/1000) }}
                            @elseif($this->selectedUnit == 'millions')
                            {{ number_format($products[$date][$segment]/1000000) }}
                            @elseif($this->selectedUnit == 'billions')
                            {{ number_format($products[$date][$segment]/1000000000) }}
                            @endif
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="row row-sub">
                        <div class="cell">% Change YoY</div>
                        @foreach ($this->selectedRange as $key => $date)
                        @if (array_key_exists($segment, $products[$date]))
                        <div class="cell">
                            @php
                            if($reverseOrder){
                            $key = (count($this->selectedRange) -1) - $key;
                            }
                            @endphp
                            @if ($key == 0)
                            0.0%
                            @else
                            {{ round((($products[$date][$segment] - $products[$years[$key - 1]][$segment]) /
                            $products[$date][$segment]) * 100, 2) . '%' }}
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
                        <div class="font-bold cell min-64">Total Revenues</div>
                        @foreach ($this->selectedRange as $date)
                        @if (array_key_exists($segment, $products[$date]))
                        <div class="font-bold cell">
                            @if($this->selectedUnit == 0)
                            {{ number_format(array_sum($products[$date])) }}
                            @elseif($this->selectedUnit == 'thousands')
                            {{ number_format(array_sum($products[$date])/1000) }}
                            @elseif($this->selectedUnit == 'millions')
                            {{ number_format(array_sum($products[$date])/1000000) }}
                            @elseif($this->selectedUnit == 'billions')
                            {{ number_format(array_sum($products[$date])/1000000000) }}
                            @endif
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="row row-sub">
                        <div class="cell">% Change YoY</div>
                        @foreach ($this->selectedRange as $key => $date)
                        <div class="cell">
                            @php
                            if($reverseOrder){
                            $key = (count($this->selectedRange) -1) - $key;
                            }
                            @endphp
                            @if ($key == 0)
                            0.0%
                            @else
                            {{ round(((array_sum($products[$date]) - array_sum($products[array_keys($products)[$key -
                            1]])) / array_sum($products[$date])) * 100, 2) . '%' }}
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    let {{$chartId}}DecimalPoints = 0;
    let {{$chartId}}UnitType = 0
    let {{$chartId}}ReversOrder = false
    let {{$chartId}}FreezePans = null
    function {{$chartId}}SetFreezePans(v){
        {{$chartId}}FreezePans = v
        @this.set('freezePanes', v)
    }
    function {{$chartId}}SetRound(v){
        {{$chartId}}DecimalPoints = v
        Livewire.emit('{{$chartId}}DecimalChanged', v)
        @this.set('decimalPoint', v)
    }
    function {{$chartId}}SetReverseOrder(v){
        {{$chartId}}ReversOrder = v
        Livewire.emit('{{$chartId}}OrderChanged', v)
        @this.set('reverseOrder', v)
    }
    function {{$chartId}}SetUnitType(v){
        {{$chartId}}UnitType = v
        Livewire.emit('{{$chartId}}unitChanged', {{$chartId}}UnitType)
        @this.set('unit', {{$chartId}}UnitType)
    }

    const {{$chartId}}annualCheckbox = document.getElementById("{{$chartId}}date-annual");
    const {{$chartId}}fiscalAnnualCheckbox = document.getElementById("{{$chartId}}date-fiscal-annual");

    {{$chartId}}annualCheckbox.addEventListener("click", function() {
        Livewire.emit('{{$chartId}}PeriodChanged', 'args')
    });
    {{$chartId}}fiscalAnnualCheckbox.addEventListener("click", function() {
        Livewire.emit('{{$chartId}}PeriodChanged', 'args')
    });
    // date-fiscal-quarterly
    const {{$chartId}}quarterlyCheckbox = document.getElementById("{{$chartId}}date-quarterly");
    const {{$chartId}}fiscalQuarterlyCheckbox = document.getElementById("{{$chartId}}date-fiscal-quaterly");

    {{$chartId}}quarterlyCheckbox.addEventListener("click", function() {
        Livewire.emit('{{$chartId}}PeriodChanged', 'qrgs')
    });
    {{$chartId}}fiscalQuarterlyCheckbox.addEventListener("click", function() {
        Livewire.emit('{{$chartId}}PeriodChanged', 'qrgs')
    });

    // const {{$chartId}}UnitTypeDropdownCloseIcon = document.getElementById("{{$chartId}}UnitTypeClose");

    // {{$chartId}}UnitTypeDropdownCloseIcon.addEventListener("click", function() {
    //     document.getElementById('{{$chartId}}{{$chartId}}dropdown-UnitType').classList.toggle("hidden");
    // });
</script>
@endpush
