<div>
    <div class="filters-row bg-white py-3 px-4  rounded-lg mb-7 custom__border_gray">
        <div class="select-wrapper flex gap-x-4 items-center custom-text-xs">
            <div class=" flex items-center text-sm" x-data="{period: null, periodTypeSelectorOpen: false}">Period Type
                <div class="relative">
                        <button type="submit" :class="[period != null ? 'active' : '', periodTypeSelectorOpen ? 'down' : '']" @click="periodTypeSelectorOpen = !periodTypeSelectorOpen" class="flex items-center flowbite_btn flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="period" id="">
                            <span
                        x-text="(period == null || period == 0) ? 'None' : period"></span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                            </svg>
                        </button>
                    <!-- Dropdown menu -->
                    <div x-cloak x-show="periodTypeSelectorOpen" id="dropdown-Period" class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                        <div class="p-3 text-base flex items-center justify-between font-medium">
                            <div>Period Type</div>
                            <svg @click="periodTypeSelectorOpen = false" id="periodClose" width="24" height="24" viewBox="0 0 24 24" class="cursor-pointer" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                            </svg>
                        </div>
                        <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll " aria-labelledby="dropdownViewButton">
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click='period = "Fiscal Annual"' :checked="period == 'Fiscal Annual'" id="{{$chartId}}period-radio-1" name="view-radio" type="radio" value="Fiscal Annual" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}period-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>Fiscal Annual</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click='period = "Fiscal Quaterly"' :checked="period == 'Fiscal Quaterly'" id="{{$chartId}}period-radio-2" name="view-radio" type="radio" value="Fiscal Quaterly" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}period-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>Fiscal Quaterly</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click='period = "Fiscal Semi-Annual"' :checked="period == 'Fiscal Semi-Annual'" id="{{$chartId}}period-radio-3" name="view-radio" type="radio" value="Fiscal Semi-Annual" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}period-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>Fiscal Semi-Annual</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click='period = "YTD"' :checked="period == 'YTD'" id="{{$chartId}}period-radio-4" name="view-radio" type="radio" value="YTD" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}period-radio-4" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>YTD</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click='period = "LTM"' :checked="period == 'LTM'" id="{{$chartId}}period-radio-5" name="view-radio" type="radio" value="LTM" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}period-radio-5" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>LTM</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click='period = "Calendar Annual"' :checked="period == 'Calendar Annual'" id="{{$chartId}}period-radio-6" name="view-radio" type="radio" value="Calendar Annual" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}period-radio-6" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>Calendar Annual</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click='period = "Calendar Quaterly"' :checked="period == 'Calendar Quaterly'" id="{{$chartId}}period-radio-7" name="view-radio" type="radio" value="Calendar Quaterly" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}period-radio-7" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>Calendar Quaterly</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                    <div class="flex items-center h-5 cursor-pointer">
                                        <input @click='period = "Calendar SA"' :checked="period == 'Calendar SA'" id="{{$chartId}}period-radio-8" name="view-radio" type="radio" value="Calendar SA" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                    </div>
                                    <div class="ml-4 w-full text-sm cursor-pointer">
                                        <label for="{{$chartId}}period-radio-8" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                            <div>Calendar SA</div>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="mx-3 my-4">
                            <button @click="$wire.emit('{{$chartId}}PeriodChanged', period); periodTypeSelectorOpen = false" class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="periodCloseButton">Show Result</button>
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
                <div x-cloak x-show="reverseOrderSelectorOpen" wire:ignore
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
                                <div class="ml-4 text-sm cursor-pointer">
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
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="{{$chartId}}order-radio-2"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Latest on the Left</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="mx-3 my-4">
                        <button @click="{{$chartId}}setReverseOrder(reverseOrder);reverseOrderSelectorOpen=false"
                            class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="orderCloseButton">Show
                            Result</button>
                    </div>
                </div>
                </div>
            </div>
            <div class="ml-3 flex items-center text-sm" x-data="{freezePans: null, freezePansOpen: false}" @click.away="freezePansOpen = false">Freeze Panes
                <div class="relative">
                    <button type="submit" :class="[freezePans != null ? 'active' : '', freezePansOpen ? 'down' : '']" @click="freezePansOpen = !freezePansOpen"
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
                <div x-cloak x-show="freezePansOpen"
                    class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                    <div class="p-3 text-base flex items-center justify-between font-medium">
                        <div>Freeze Panes</div>
                        <svg id="freezePanesClose" class="cursor-pointer" width="24" height="24" viewBox="0 0 24 24" fill="none" @click="freezePansOpen = false"
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
                                <div class="ml-4 text-sm cursor-pointer">
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
                                <div class="ml-4 text-sm cursor-pointer">
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
                                <div class="ml-4 text-sm cursor-pointer">
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
                            id="freezePanesCloseButton" @click="{{$chartId}}setFreezePans(freezePans);freezePansOpen=false">Show Result</button>
                    </div>
                </div>
                </div>
            </div>
            <div wire:ignore class="ml-3 flex items-center text-sm" x-data="{round: null, roundSelectorOpen: false}" @click.away="roundSelectorOpen = false">Decimal
                <div class="relative">
                    <button :class="[round != null ? 'active' : '', roundSelectorOpen ? 'down' : '']" @click="roundSelectorOpen = !roundSelectorOpen"
                        class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2 flowbite_btn"
                        name="view" id="">
                        <span x-text='(round == null || round == 0) ? "auto" : (round == 2 ? ".00" : (round == 3 ? ".00" : ""))' ></span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                fill="#121A0F" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div x-cloak x-show="roundSelectorOpen"
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
                                @click="{{$chartId}}setRound(round);roundSelectorOpen=false">Show Result</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        let {{$chartId}}element = document.getElementById("{{$chartId}}"+id);
                        if ({{$chartId}}element) {
                            {{$chartId}}element.classList.add("active-dots");
                            {{$chartId}}element.classList.remove("inactive-dots");
                        }
                    })

                    {{$chartId}}intersection.forEach(id => {
                        let {{$chartId}}element = document.getElementById("{{$chartId}}"+id);
                        if ({{$chartId}}element) {
                            {{$chartId}}element.classList.remove("active-dots");
                            {{$chartId}}element.classList.add("inactive-dots");
                        }
                    })
                }
        }'></div>
    </div>
    <div x-data="{ rbeshowgraph: true }" wire:ignore>
        <div class="flex justify-end" x-cloak x-show="!rbeshowgraph" @click="rbeshowgraph = true">
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
        'chartData' => $chartData,
        'period' => $period,
        'chartId' => 'rbe',
        'title' => 'Revenue per Employee'
        ], key(uniqid()))
    </div>
    <div class="w-full">
        <div class="table-wrapper">
            <div class="table">
                <div class="row-group row-head-fonts-sm row-border-custom table-border-bottom">
                    <div class="row row-head">
                        <div class="cell font-bold min-64">Revenue / Employee</div>
                        @foreach ($this->selectedRange as $date)
                        <div class="cell font-bold">{{ $date }}</div>
                        @endforeach
                    </div>
                    <div class="row ">
                        <div class="cell min-64">Revenues</div>
                        @foreach ($this->selectedRange as $date)
                            @if(isset($revenues[$date]))
                                <div class="cell">
                                    @if($this->selectedUnit == 0)
                                        {{ number_format((float)explode('|', $revenues[$date][0])[0], $decimalPoint) }}
                                    @elseif($this->selectedUnit == 'thousands')
                                        {{ number_format((float)explode('|', $revenues[$date][0])[0]/1000, $decimalPoint) }}
                                    @elseif($this->selectedUnit == 'millions')
                                        {{ number_format((float)explode('|', $revenues[$date][0])[0]/1000000, $decimalPoint) }}
                                    @elseif($this->selectedUnit == 'billions')
                                        {{ number_format((float)explode('|', $revenues[$date][0])[0]/1000000000, $decimalPoint) }}
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="cell min-64">% Change YoY</div>
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
                                {{ number_format(((float)explode('|', $revenues[$date][0])[0] - (float)explode('|', $revenues[$years[$key - 1]][0])[0]) /
                                    ((float)explode('|', $revenues[$years[$key - 1]][0])[0] != 0 ? (float)explode('|', $revenues[$years[$key - 1]][0])[0] : 1) * 100, $decimalPoint) }}
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="row ">
                        <div class="cell min-64">Employees</div>
                        @foreach ($this->selectedRange as $date)
                            @if(isset($employeeCount[$date]))
                                <div class="cell">
                                    {{ number_format($employeeCount[$date]) }}
                                </div>
                            @else
                                <div class="cell">
                                    N/A
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="cell min-64">% Change YoY</div>
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
                                {{ isset($employeeCount[$date], $employeeCount[$years[$key - 1]]) ?
                                number_format(($employeeCount[$date] - $employeeCount[$years[$key - 1]]) /
                                ($employeeCount[$date] != 0 ? $employeeCount[$date] : 1) * 100, $decimalPoint) :
                                'N/A' }}
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="row ">
                        <div class="cell min-64 font-bold">Revenue / Employee (‘000s)</div>
                        @foreach ($this->selectedRange as $date)
                            @if(isset($revenues[$date]))
                                <div class="cell font-bold">
                                    @if(isset($revenues[$date][0], $employeeCount[$date]))
                                        @if($this->selectedUnit == 0)
                                            {{ number_format(explode('|', $revenues[$date][0])[0] / $employeeCount[$date], $decimalPoint) }}
                                        @elseif($this->selectedUnit == 'thousands')
                                            {{ number_format(explode('|', $revenues[$date][0])[0] / $employeeCount[$date] / 1000, $decimalPoint) }}
                                        @elseif($this->selectedUnit == 'millions')
                                            {{ number_format(explode('|', $revenues[$date][0])[0] / $employeeCount[$date] / 1000000, $decimalPoint) }}
                                        @elseif($this->selectedUnit == 'billions')
                                            {{ number_format(explode('|', $revenues[$date][0])[0] / $employeeCount[$date] / 1000000000, $decimalPoint) }}
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="cell min-64 font-bold">% Change YoY</div>
                        @foreach ($this->selectedRange as $key => $date)
                        <div class="cell font-bold">
                            @php
                            if($reverseOrder){
                                $key = (count($this->selectedRange) -1) - $key;
                            }
                            @endphp
                            @if ($key == 0)
                                0.0%
                            @else
                                @php
                                    $current = isset($revenues[$date][0], $employeeCount[$date]) ?
                                        explode('|', $revenues[$date][0])[0] / $employeeCount[$date] :
                                        null;

                                    $previous = isset($revenues[$years[$key - 1]][0], $employeeCount[$years[$key - 1]]) ?
                                        explode('|', $revenues[$years[$key - 1]][0])[0] / $employeeCount[$years[$key - 1]] :
                                        null;
                                @endphp

                                @if ($current !== null && $previous !== null && $current !== 0)
                                    {{ number_format((($current - $previous) / $current) * 100, $decimalPoint) }}%
                                @else
                                    N/A
                                @endif
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
    let {{$chartId}}unitType = 0
    let {{$chartId}}reversOrder = false
    let {{$chartId}}FreezePans = null
    function {{$chartId}}setFreezePans(v){
        {{$chartId}}FreezePans = v
        @this.set('freezePanes', v)
    }
    function {{$chartId}}setRound(v){
        {{$chartId}}DecimalPoints = v
        Livewire.emit('{{$chartId}}DecimalChanged', v)
        @this.set('decimalPoint', v)
    }
    function {{$chartId}}setReverseOrder(v){
        {{$chartId}}reversOrder = v
        Livewire.emit('{{$chartId}}OrderChanged', v)
        @this.set('reverseOrder', v)
    }
    function {{$chartId}}setUnitType(v){
        {{$chartId}}unitType = v
        Livewire.emit('{{$chartId}}UnitChanged', {{$chartId}}unitType)
        @this.set('unit', {{$chartId}}unitType)
    }

    // const {{$chartId}}annualCheckbox = document.getElementById("{{$chartId}}date-annual");
    // const {{$chartId}}fiscalAnnualCheckbox = document.getElementById("{{$chartId}}date-fiscal-annual");

    // {{$chartId}}annualCheckbox.addEventListener("click", function() {
    //     Livewire.emit('{{$chartId}}PeriodChanged', 'arps')
    // });
    // {{$chartId}}fiscalAnnualCheckbox.addEventListener("click", function() {
    //     Livewire.emit('{{$chartId}}PeriodChanged', 'arps')
    // });
    // // date-fiscal-quarterly
    // const {{$chartId}}quarterlyCheckbox = document.getElementById("{{$chartId}}date-quarterly");
    // const {{$chartId}}fiscalQuarterlyCheckbox = document.getElementById("{{$chartId}}date-fiscal-quaterly");

    // {{$chartId}}quarterlyCheckbox.addEventListener("click", function() {
    //     Livewire.emit('{{$chartId}}PeriodChanged', 'qrps')
    // });
    // {{$chartId}}fiscalQuarterlyCheckbox.addEventListener("click", function() {
    //     Livewire.emit('{{$chartId}}PeriodChanged', 'qrps')
    // });

    // const {{$chartId}}unitTypeDropdownCloseIcon = document.getElementById("{{$chartId}}unitTypeClose");

    // {{$chartId}}unitTypeDropdownCloseIcon.addEventListener("click", function() {
    //     document.getElementById('{{$chartId}}{{$chartId}}dropdown-UnitType').classList.toggle("hidden");
    // });
</script>
@endpush
