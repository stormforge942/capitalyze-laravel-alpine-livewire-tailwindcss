<div>
    <div class="filters-row mb-3">
        <div class="select-wrapper flex items-center custom-text-xs" x-data="{unitType: 0}">
            <div class="flex items-center text-sm">Unit Type
                <button id="dropdownUnitTypeButton" data-dropdown-toggle="dropdown-UnitType"
                    class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2"
                    name="view" id="">
                    <span
                        x-text="unitType == 0 ? 'None' : (unitType == 'thousands' ? 'Thousands' : (unitType == 'millions' ? 'Millions' : (unitType == 'billions' ? 'Billions' : '')))"></span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown-UnitType" wire:ignore
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="p-3 text-sm flex items-center justify-between">
                        <div>Unit Type</div>
                        <svg id="unitTypeClose" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                fill="#686868" />
                        </svg>
                    </div>
                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll"
                        aria-labelledby="dropdownViewButton">
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="unitType = 0" id="unitType-radio-1" name="unitType-radio"
                                        type="radio" value="None"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="unitType-radio-1"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>None</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="unitType = 'thousands'" id="unitType-radio-1" name="unitType-radio"
                                        type="radio" value="Thousands"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="unitType-radio-1"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Thousands</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="unitType = 'millions'" id="unitType-radio-2" name="unitType-radio"
                                        type="radio" value="Millions"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="unitType-radio-2"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Millions</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="unitType = 'billions'" id="unitType-radio-3" name="unitType-radio"
                                        type="radio" value="Billions"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="unitType-radio-3"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Billions</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="mx-3 my-4">
                        <button class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center" id="unitTypeCloseButton"
                            @click="setUnitType(unitType)">Show Result</button>
                    </div>
                </div>
            </div>
            <div class="ml-3 flex items-center text-sm" x-data="{reverseOrder:false}">Order
                <button id="dropdownOrderButton" data-dropdown-toggle="dropdown-Order"
                    class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2"
                    name="view" id="">
                    <span x-text="reverseOrder == false ? 'Latest on Right' : 'Latest on Left'"></span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown-Order" wire:ignore
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="p-3 text-sm flex items-center justify-between">
                        <div>Order</div>
                        <svg id="orderClose" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                fill="#686868" />
                        </svg>
                    </div>
                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll"
                        aria-labelledby="dropdownViewButton">
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="reverseOrder = false" checked id="order-radio-1" name="order-radio"
                                        type="radio"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="order-radio-1"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Latest on the Right</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="reverseOrder = true" id="order-radio-1" name="order-radio"
                                        type="radio"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="order-radio-1"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Latest on the Left</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="mx-3 my-4">
                        <button @click="setReverseOrder(reverseOrder)"
                            class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center" id="orderCloseButton">Show
                            Result</button>
                    </div>
                </div>
            </div>
            <div class="ml-3 flex items-center text-sm">Freeze Panes
                <button type="submit" id="dropdownFreezePanesButton" data-dropdown-toggle="dropdown-FreezePanes"
                    class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2"
                    name="view" id="">
                    {{$freezePanes}}
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown-FreezePanes"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="p-3 text-sm flex items-center justify-between">
                        <div>Freeze Panes</div>
                        <svg id="freezePanesClose" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                fill="#686868" />
                        </svg>
                    </div>
                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll"
                        aria-labelledby="dropdownViewButton">
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input wire:model="freezePanes" @if($view==='Top Row' ) checked @endif
                                        id="freezePanes-radio-1" name="freezePanes-radio" type="radio" value="Top Row"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="freezePanes-radio-1"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Top Row</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input wire:model="freezePanes" @if($view==='First Column' ) checked @endif
                                        id="freezePanes-radio-2" name="freezePanes-radio" type="radio"
                                        value="First Column"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="freezePanes-radio-2"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>First Column</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input wire:model="freezePanes" @if($view==='Top Row & First Column' ) checked
                                        @endif id="freezePanes-radio-3" name="freezePanes-radio" type="radio"
                                        value="Top Row & First Column"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label for="freezePanes-radio-3"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>Top Row & First Column</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="mx-3 my-4">
                        <button class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center"
                            id="freezePanesCloseButton">Show Result</button>
                    </div>
                </div>
            </div>
            <div wire:ignore class="ml-3 flex items-center text-sm" x-data="{round: 0}">Decimal
                <button id="dropdownDecimalButton" data-dropdown-toggle="dropdown-Decimal"
                    class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2"
                    name="view" id="">
                    <span x-text='round == 0 ? "auto" : (round == 2 ? ".00" : (round == 3 ? ".00" : ""))'></span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                            fill="#121A0F" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown-Decimal"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="p-3 text-sm flex items-center justify-between">
                        <div>Decimal</div>
                        <svg id="decimalClose" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                fill="#686868" />
                        </svg>
                    </div>
                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll"
                        aria-labelledby="dropdownViewButton">
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="round=0" :checked="round==0" id="decimal-radio-1"
                                        name="decimal-radio" type="radio" value="0"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label @click="round=0" for="decimal-radio-1"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>auto</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="round=2" :checked="round==2" id="decimal-radio-2"
                                        name="decimal-radio" type="radio" value="2"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label @click="round=2" for="decimal-radio-2"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>.00</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                <div class="flex items-center h-5 cursor-pointer">
                                    <input @click="round=3" :checked="round==3" id="decimal-radio-3"
                                        name="decimal-radio" type="radio" value="3"
                                        class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                </div>
                                <div class="ml-4 text-sm cursor-pointer">
                                    <label @click="round=3" for="decimal-radio-3"
                                        class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                        <div>.000</div>
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="mx-3 my-4">
                        <button class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center" id="decimalCloseButton"
                            @click="setRound(round)">Show Result</button>
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
                    <input wire:model="period" value="fiscal-annual" id="date-fiscal-annual" type="radio"
                        name="date-range" class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Fiscal Annual</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input wire:model="period" value="fiscal-quarterly" id="date-fiscal-quaterly" type="radio"
                        name="date-range" class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Fiscal Quaterly</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input wire:model="period" value="fiscal-semi-annual" id="date-fiscal-semi-annual" type="radio"
                        name="date-range" class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Fiscal Semi-Annual</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input wire:model="period" value="YTD" id="date-YTD" type="radio" name="date-range"
                        class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">YTD</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input wire:model="period" value="LTM" id="date-LTM" type="radio" name="date-range"
                        class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">LTM</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input wire:model="period" value="annual" id="date-annual" id="date-annual" type="radio"
                        name="date-range" class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Calendar Annual</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input wire:model="period" value="quarterly" id="date-quarterly" type="radio" name="date-range"
                        class="w-5 h-5 ">
                    <span class="w-full py-2 ml-2 text-sm">Calendar Quaterly</span>
                </label>
            </li>
            <li class="mr-2">
                <label class="flex items-center pl-3 cursor-pointer">
                    <input wire:model="period" value="SA" id="date-SA" type="radio" name="date-sa" class="w-5 h-5 ">
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
        <div id="range-slider-company-analysis" class="range-slider" x-init='() => {
            const el = document.querySelector("#range-slider-company-analysis");
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
            selectedValue[0] = rangeMin
            selectedValue[1] = rangeMax;
            recognizeDotsStatus(selectedValue, [rangeMin, rangeMax]);
            rangeSlider(el, {
                step: 1,
                min: rangeMin,
                max: rangeMax,
                value: selectedValue,
                rangeSlideDisabled: true,
                onInput: (value, e) => {
                    if (value.length === 2 && value !== selectedValue) {
                        recognizeDotsStatus(selectedValue, [rangeMin, rangeMax]);
                        Livewire.emit("analysisDatesChanged", value)
                    }
                },
            });
            function recognizeDotsStatus(value, baseArray) {
                    let base = generateRangeArray(baseArray)
                    let activeYears = generateRangeArray(value)
                    let intersection = base.filter(x => !activeYears.includes(x));

                    activeYears.forEach(id => {
                        let element = document.getElementById(id);
                        if (element) {
                            element.classList.add("active-dots");
                            element.classList.remove("inactive-dots");
                        }
                    })

                    intersection.forEach(id => {
                        let element = document.getElementById(id);
                        if (element) {
                            element.classList.remove("active-dots");
                            element.classList.add("inactive-dots");
                        }
                    })
                }
        }'></div>
    </div>
    <div x-data="{ showgraph: false }">
        <div class="flex justify-end" x-show="!showgraph" @click="showgraph = true">
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
        ])
    </div>
    <div class="w-full">
        <div class="table-wrapper">
            <div class="table">
                <div class="row-group row-head-fonts-sm row-border-custom table-border-bottom">
                    <div class="row row-head">
                        <div class="cell font-bold">{{$companyName}} ({{$ticker}})</div>
                        @foreach ($this->selectedRange as $date)
                        <div class="cell font-bold">{{ $date }}</div>
                        @endforeach
                    </div>
                    @foreach ($segments as $index => $segment)
                    <div class="row ">
                        <div class="font-bold cell">
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
                        <div class="font-bold cell">Total Revenues</div>
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
