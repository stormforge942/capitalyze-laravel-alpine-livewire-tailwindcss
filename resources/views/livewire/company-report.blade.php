<div class="w-full">
    <livewire:slides.right-slide>
    <livewire:slides.left-slide>
    <div id="main-report-div" class="py-0 bg-gray-100">
        <div> <h4 class="text-lg text-[#121A0F] font-[700]"> {{ @$companyName }}  @if(@$ticker) ({{ @$ticker }}) @endif</h4></div>
        <div class="flex justify-between items-center content-center pr-8">
            <div class="flex justify-start content-center items-center mt-3">
                <div>
                    <h4 class="text-lg font-[700] mr-2">${{ number_format($latestPrice, 2) }}</h4>
                </div>
                <div>
                    <span class="text-base font-medium mr-2">
                        <small id="dynamicValue" class="{{ $percentageChange > 0 ? 'text-color-green' : 'text-color-red' }}">
                                            ({{ $percentageChange > 0 ? '+' : '-' }}{{ abs($percentageChange) }}%)
                        </small>
                    </span>
                </div>
                <div>
                    <img src="{{ $percentageChange > 0 ? asset('/svg/increase-icon.svg') : asset('/svg/decrease-icon.svg') }}" alt="icon"/>
                </div>
            </div>
            <div class="hidden lg:flex justify-around items-center">
                <div class="flex justify-start items-center mr-3">
                    <div class="mr-1">
                        <img src="{{asset('/svg/download.svg')}}"/>
                    </div>
                    <p><a href="#" class="text-sm text-[#121A0F] font-[500]">Download PDF </a></p>
                </div>
                <div class="flex justify-start items-center mr-3">
                    <div class="mr-1">
                        <img src="{{asset('/svg/download.svg')}}"/>
                    </div>
                    <p><a href="#" class="text-sm text-[#121A0F] font-[500]">Download Excel</a></p>
                </div>
                <div class="flex justify-start items-center">
                    <div class="mr-1">
                        <img src="{{asset('/svg/download.svg')}}"/>
                    </div>
                    <p><a href="#" class="text-sm text-[#121A0F] font-[500]">Download CSV</a></p>
                </div>
            </div>
        </div>
        <div class="mx-auto">
            <div class="px-4 sm:pr-6 lg:pr-8 py-0 pl-0">
                <div class="mt-0 flow-root company-profile-loading overflow-x-hidden">
                    <div class="align-middle">
                        <div class="block min-w-full sm:rounded-lg">
                            <div class="py-0">
{{--                                <div class="flex w-full justify-between items-center" >--}}
{{--                                    <div class="page-titles">--}}
{{--                                        <b class="company-name">{{ @$companyName }}  @if(@$ticker) ({{ @$ticker }}) @endif </b> <br>--}}
{{--                                        <span class="brr mt-3"></span>--}}
{{--                                        <span class="company-price">${{ number_format($cost, 2) }}</span>--}}
{{--                                        <small id="dynamicValue" class="{{ $dynamic > 0 ? 'text-color-green' : 'text-color-red' }}">--}}
{{--                                            ({{ $dynamic > 0 ? '+' : '-' }}{{ abs($dynamic) }}%)--}}
{{--                                        </small>--}}
{{--                                    </div>--}}
{{--                                    <div class="download-buttons-wrapper flex">--}}
{{--                                        <a class="download-button" href="#">--}}
{{--                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                <path d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z" fill="#121A0F"/>--}}
{{--                                            </svg>--}}
{{--                                            Download PDF--}}
{{--                                        </a>--}}
{{--                                        <a class="download-button" href="#">--}}
{{--                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                <path d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z" fill="#121A0F"/>--}}
{{--                                            </svg>--}}
{{--                                            Download Excel--}}
{{--                                        </a>--}}
{{--                                        <a class="download-button" href="#">--}}
{{--                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                <path d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z" fill="#121A0F"/>--}}
{{--                                            </svg>--}}
{{--                                            Download CSV--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <!-- <div class="flex w-full overflow-x-hidden">
                                    <div class="tabs-wrapper flex">
                                        <a href="{{route('company.report', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.report'])>Income Statement</a>
                                        <a href="{{route('company.report', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3' => $currentRoute === 'company.report'])>Balance Sheet</a>
                                        <a href="{{route('company.report', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3' => $currentRoute === 'company.report'])>Cash Flow</a>
                                        <a href="{{route('company.geographic', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.geographic'])>Segments</a>
                                        <a href="{{route('company.shareholders', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.shareholders'])>Ratios</a>
                                        <a href="{{route('company.executive.compensation', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.executive.compensation'])>Consolidated Statements</a>
                                    </div>
                                </div> -->

                                <div class="flex w-full overflow-x-hidden mt-3">
                                    <div class="tabs-container w-full" style="overflow-x: auto; white-space: nowrap;">
                                        <ul class="tabs-wrapper flex gap-2">
                                            <li data-tab-index="0" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:bg-gray-light px-6 tab @if($activeTabName == 'Income Statement') active hover:bg-green-dark @endif" wire:click="$emit('tabSubClicked', 'Income Statement')">Income Statement</li>
                                            <li data-tab-index="1" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:bg-gray-light px-6 tab @if($activeTabName == 'Balance Sheet Statement') active hover:bg-green-dark @endif" wire:click="$emit('tabSubClicked', 'Balance Sheet Statement')">Balance Sheet</li>
                                            <li data-tab-index="2" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:bg-gray-light px-6 tab @if($activeTabName == 'Cash Flow Statement') active hover:bg-green-dark @endif" wire:click="$emit('tabSubClicked', 'Cash Flow Statement')">Cash Flow</li>
                                            <li data-tab-index="3" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:bg-gray-light px-6 tab @if($activeTabName == 'Ratios') active hover:bg-green-dark @endif" wire:click="$emit('tabSubClicked', 'Ratios')">Ratios</li>
                                            <li data-tab-index="4" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:bg-gray-light px-6 tab @if($activeTabName == 'Disclosure') active hover:bg-green-dark @endif" wire:click="$emit('tabSubClicked', 'Disclosure')">Disclosure</li>
                                        </ul>
                                    </div>
                                </div>



                                <div class="filters-row bg-white py-3 px-4  rounded-lg mb-7 custom__border_gray">
                                    <div class="select-wrapper flex gap-x-4 items-center custom-text-xs">
                                        <div class=" flex items-center text-sm" x-data="{view: null, viewTypeSelectorOpen: false}" @click.away="viewTypeSelectorOpen = false">View
                                            <div class="relative">
                                                <button type="submit" @click="viewTypeSelectorOpen = !viewTypeSelectorOpen" id="dropdownViewButton" data-dropdown-toggle="dropdown-View" class="flex items-center flowbite-select flowbite_btn bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="view" id="" :class="[view != null ? 'active' : '', viewTypeSelectorOpen? 'down' : '']">
                                                    {{(str_replace('(Harmonized)', '', $view))}}
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div x-cloak id="dropdown-View" x-show="viewTypeSelectorOpen" class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                                                    <div class="p-3 text-base flex items-center justify-between font-medium">
                                                        <div>View</div>
                                                        <svg id="viewClose" @click="viewTypeSelectorOpen = false" width="24" height="24" viewBox="0 0 24 24" class="cursor-pointer" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                        </svg>
                                                    </div>
                                                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll " aria-labelledby="dropdownViewButton">
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='view = "As reported (Harmonized)"' :checked="view == 'As reported (Harmonized)'" id="view-radio-1" name="view-radio" type="radio" value="As reported (Harmonized)" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="view-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>As reported</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='view = "Adjusted"' :checked="view == 'Adjusted'" id="view-radio-2" name="view-radio" type="radio" value="Adjusted" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="view-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Adjusted</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='view ="Standardised Template"' :checked="view == 'Standardised Template'" id="view-radio-3" name="view-radio" type="radio" value="Standardised Template" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="view-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Standardised Template</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='view ="Per Share"' :checked="view == 'Per Share'" id="view-radio-4" name="view-radio" type="radio" value="Per Share" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="view-radio-4" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Per Share</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='view ="Common size"' :checked="view == 'Common size'" id="view-radio-5" name="view-radio" type="radio" value="Common size" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="view-radio-5" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Common size</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="mx-3 my-4">
                                                        <button @click="$wire.set('view', view); viewTypeSelectorOpen = false" class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="viewCloseButton">Show Result</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" flex items-center text-sm" x-data="{period: null, periodTypeSelectorOpen: false}" @click.away="periodTypeSelectorOpen = false">Period Type
                                            <div class="relative">
                                                    <button type="submit" :class="[period != null ? 'active' : '', periodTypeSelectorOpen ? 'down' : '']" @click="periodTypeSelectorOpen = !periodTypeSelectorOpen" class="flex items-center flowbite_btn flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="period" id="">
                                                        <span x-text="(period == null || period == 0) ? 'None' : period"></span>
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
                                                                    <input @click='period = "Fiscal Annual"' :checked="period == 'Fiscal Annual'" id="period-radio-1" name="view-radio" type="radio" value="Fiscal Annual" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="period-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Fiscal Annual</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='period = "Fiscal Quaterly"' :checked="period == 'Fiscal Quaterly'" id="period-radio-2" name="view-radio" type="radio" value="Fiscal Quaterly" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="period-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Fiscal Quaterly</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='period = "Fiscal Semi-Annual"' :checked="period == 'Fiscal Semi-Annual'" id="period-radio-3" name="view-radio" type="radio" value="Fiscal Semi-Annual" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="period-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Fiscal Semi-Annual</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='period = "YTD"' :checked="period == 'YTD'" id="period-radio-4" name="view-radio" type="radio" value="YTD" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="period-radio-4" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>YTD</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='period = "LTM"' :checked="period == 'LTM'" id="period-radio-5" name="view-radio" type="radio" value="LTM" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="period-radio-5" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>LTM</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='period = "Calendar Annual"' :checked="period == 'Calendar Annual'" id="period-radio-6" name="view-radio" type="radio" value="Calendar Annual" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="period-radio-6" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Calendar Annual</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='period = "Calendar Quaterly"' :checked="period == 'Calendar Quaterly'" id="period-radio-7" name="view-radio" type="radio" value="Calendar Quaterly" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="period-radio-7" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Calendar Quaterly</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='period = "Calendar SA"' :checked="period == 'Calendar SA'" id="period-radio-8" name="view-radio" type="radio" value="Calendar SA" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="period-radio-8" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Calendar SA</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="mx-3 my-4">
                                                        <button @click="$wire.set('period', period); periodTypeSelectorOpen = false" class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="periodCloseButton">Show Result</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" flex items-center text-sm" x-data="{unitType: null, unitTypeSelectorOpen: false}" @click.away="unitTypeSelectorOpen = false">Unit Type
                                            <div class="relative">
                                                <button type="submit" :class="[unitType != null ? 'active' : '', unitTypeSelectorOpen ? 'down' : '']" @click="unitTypeSelectorOpen = !unitTypeSelectorOpen" class="flex items-center flowbite_btn flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="view" id="">
                                                    {{$unitType}}
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div x-cloak x-show="unitTypeSelectorOpen" class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                                                    <div class="p-3 text-base flex items-center justify-between font-medium">
                                                        <div>Unit Type</div>
                                                        <svg @click="unitTypeSelectorOpen = false" id="unitTypeClose" width="24" height="24" viewBox="0 0 24 24" class="cursor-pointer" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                        </svg>
                                                    </div>
                                                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll " aria-labelledby="dropdownViewButton">
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='unitType = "None"' :checked="unitType == 'None'" id="unitType-radio" name="unitType-radio" type="radio" value="None" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="unitType-radio" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>None</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='unitType = "Thousands"' :checked="unitType == 'Thousands'" id="unitType-radio-1" name="unitType-radio" type="radio" value="Thousands" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="unitType-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Thousands</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='unitType = "Millions"' :checked="unitType == 'Millions'" id="unitType-radio-2" name="unitType-radio" type="radio" value="Millions" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="unitType-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Millions</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='unitType = "Billions"' :checked="unitType == 'Billions'" id="unitType-radio-3" name="unitType-radio" type="radio" value="Billions" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="unitType-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Billions</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="mx-3 my-4">
                                                        <button @click="$wire.set('unitType', unitType); unitTypeSelectorOpen = false" class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="unitTypeCloseButton">Show Result</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" flex items-center text-sm" x-data="{decimalDisplay: null, decimalDisplaySelectorOpen: false}" @click.away="decimalDisplaySelectorOpen = false">Decimal
                                            <div class="relative">
                                                <button type="submit" @click="decimalDisplaySelectorOpen = !decimalDisplaySelectorOpen" :class="[decimalDisplay != null ? 'active' : '', decimalDisplaySelectorOpen ? 'down' : '']" class="flex items-center flowbite_btn flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="view" id="">
                                                    {{$decimalDisplay == 2 ? '.00' : ($decimalDisplay == 3 ? '.000' : 'auto')}}
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div x-cloak x-show="decimalDisplaySelectorOpen" class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                                                    <div class="p-3 text-base flex items-center justify-between font-medium">
                                                        <div>Decimal</div>
                                                        <svg id="decimalClose" @click="decimalDisplaySelectorOpen = false" width="24" height="24" viewBox="0 0 24 24" class="cursor-pointer" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                        </svg>
                                                    </div>
                                                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll " aria-labelledby="dropdownViewButton">
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='decimalDisplay = "0"' :checked="'decimalDisplay' == '0'" id="decimal-radio-1" name="decimal-radio" type="radio" value="0" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="decimal-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>auto</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='decimalDisplay = "2"' :checked="'decimalDisplay' == '2'" id="decimal-radio-2" name="decimal-radio" type="radio" value="2" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="decimal-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>.00</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='decimalDisplay = "3"' :checked="'decimalDisplay' == '3'" id="decimal-radio-3" name="decimal-radio" type="radio" value="3" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="decimal-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>.000</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="mx-3 my-4">
                                                        <button @click="$wire.set('decimalDisplay', decimalDisplay); decimalDisplaySelectorOpen=false;" class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="decimalCloseButton">Show Result</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" flex items-center text-sm" x-data="{reverse: null, reverseSelectorOpen: false}" @click.away="reverseSelectorOpen = false">Order
                                            <div class="relative">
                                                <button type="submit" @click="reverseSelectorOpen = !reverseSelectorOpen" :class="[reverse != null ? 'active' : '', reverseSelectorOpen ? 'down' : '']" class="flex items-center flowbite_btn flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="view" id="">
                                                    {{$reverse ? 'Latest on the Left' : 'Latest on the Right'}}
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div x-cloak x-show="reverseSelectorOpen" class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                                                    <div class="p-3 text-base flex items-center justify-between font-medium">
                                                        <div>Order</div>
                                                        <svg id="orderClose" width="24" height="24" class="cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                        </svg>
                                                    </div>
                                                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll " aria-labelledby="dropdownViewButton">
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click="reverse = false" :checked="!reverse" id="order-radio-0" name="order-radio" type="radio" value="false" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="order-radio-0" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Latest on the Right</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input  @click="reverse = true" :checked="reverse" id="order-radio-1" name="order-radio" type="radio" value="true" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="order-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Latest on the Left</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="mx-3 my-4">
                                                        <button @click="$wire.set('reverse', reverse); reverseSelectorOpen = false;" class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" id="orderCloseButton">Show Result</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" flex items-center text-sm" x-data="{freezePanes: null, freezePanesSelectorOpen: false}" @click.away="freezePanesSelectorOpen = false">Freeze Panes
                                            <div class="relative">
                                                <button @click="freezePanesSelectorOpen = !freezePanesSelectorOpen" :class="[freezePanes != null ? 'active' : '', freezePanesSelectorOpen ? 'down' : '']" type="submit" class="flex items-center flowbite_btn flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2" name="view" id="">
                                                    {{$freezePanes}}
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div x-cloak x-show="freezePanesSelectorOpen" class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-gray-700 dark:divide-gray-600 dropdown-scroll-wrapper">
                                                    <div class="p-3 text-base flex items-center justify-between font-medium">
                                                        <div>Freeze Panes</div>
                                                        <svg @click="freezePanesSelectorOpen = false" id="freezePanesClose" width="24" height="24" class="cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                        </svg>
                                                    </div>
                                                    <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 h_23 overflow-y-scroll dropdown-scroll " aria-labelledby="dropdownViewButton">
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='freezePanes = "Top Row"' :checked="freezePanes == 'Top Row'" id="freezePanes-radio-1" name="freezePanes-radio" type="radio" value="Top Row" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="freezePanes-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Top Row</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='freezePanes = "First Column"' :checked="freezePanes == 'First Column'" id="freezePanes-radio-2" name="freezePanes-radio" type="radio" value="First Column" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="freezePanes-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>First Column</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                                <div class="flex items-center h-5 cursor-pointer">
                                                                    <input @click='freezePanes = "Top Row & First Column"' :checked="freezePanes == 'Top Row & First Column'" id="freezePanes-radio-3" name="freezePanes-radio" type="radio" value="Top Row & First Column" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                                </div>
                                                                <div class="ml-4 w-full text-sm cursor-pointer">
                                                                    <label for="freezePanes-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                        <div>Top Row & First Column</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="mx-3 my-4">
                                                        <button class="w-full p-1 text-base font-medium bg-[#52D3A2] rounded text-center" @click="freezePanesSelectorOpen = false" id="freezePanesCloseButton">Show Result</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                <div class="years-range-wrapper my-2">
                                    <div class="dots-wrapper">
                                        @php
                                            $existingYears = [];
                                        @endphp
                                        @foreach($rangeDates as $key => $date)
                                            @if(!in_array(date('Y', strtotime($date)), $existingYears))
                                            <span id="{{date('Y', strtotime($date))}}" class="inactive-dots"></span>
                                            @endif
                                            @php
                                                $existingYears[] = date('Y', strtotime($date))
                                            @endphp
                                        @endforeach
                                    </div>
                                    <div wire:ignore id="range-slider-company-report" class="range-slider"></div>
                                </div>

                                @if(count($chartData))
                                <div x-data="{showGraph: true, menuOpen: false}">
                                    <div class="flex justify-end mt-4">
                                        <button class="show-hide-chart-btn" @click="showGraph = true" x-show="!showGraph">
                                            Show Chart
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div>
                                        <div class="mb-4 mt-7 pb-5 w-full px-5 bg-white flex flex-col" x-show="showGraph">
                                            <div class="flex justify-between w-full my-12 pl-6 pr-3">
                                                <div class="text-lg text-indigo-600 font-bold">
                                                    Apple Inc. (AAPL)
                                                </div>
                                                <div class="flex items-start relative">

                                                    <button type="button" class="custom-drop-down-button hide-mobile"  aria-expanded="true" aria-haspopup="true">

                                                        <svg  xmlns="http://www.w3.org/2000/svg" @click="menuOpen = true" x-show="!menuOpen" fill="#121A0F" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"></path>
                                                        </svg>

                                                        <svg  xmlns="http://www.w3.org/2000/svg" @click="menuOpen = false" x-show="menuOpen" fill="#121A0F" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6" style="display: none;">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                                                        </svg>

                                                    </button>

                                                    <div  class="absolute custom-drop-down right-0 z-10 bg-white focus:outline-none" x-show="menuOpen" role="menu" x-show="showGraph=true" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" style="">
                                                        <div class="py-1" role="none">
                                                            <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                                            <div class="links-wrapper mb-3">
                                                                <a href="#" @click="menuOpen = false; showGraph = false;" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-0">Hide Chart</a>
                                                                <a href="#"  chartMenuOpen = false" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-0" style="display: none;">Show Chart</a>
                                                                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-1">View In Full
                                                                    Screen</a>
                                                                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-2">Print
                                                                    Chart</a>
                                                            </div>
                                                            <hr class="mb-3">
                                                            <div class="links-wrapper">
                                                                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-3"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                                                                    </svg>
                                                                    Download As PNG</a>
                                                                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-4"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                                                                    </svg>
                                                                    Download As PNG</a>
                                                                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-5"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                                                                    </svg>
                                                                    Download As PNG</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-6 w-full" wire:ignore>
                                                <canvas id="chart-company-report" class="chart-company-report"></canvas>
                                            </div>
                                            <div class="flex justify-end">
                                                <div class="mr-5 mt-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="65" height="16" viewBox="0 0 80 16" fill="none">
                                                        <path
                                                            d="M29.8334 5.61422C30.1938 6.30619 30.374 7.11691 30.374 8.04719C30.374 8.95371 30.1938 9.75297 29.8334 10.4449C29.473 11.1369 28.9726 11.6717 28.3329 12.0492C27.6932 12.4267 26.9666 12.6159 26.1524 12.6159C25.4898 12.6159 24.914 12.4938 24.4258 12.2498C23.9376 12.0058 23.5477 11.6741 23.257 11.2557V15.9996H21.373V3.58252L23.0129 3.58252L23.2398 4.90832C23.9606 3.95512 24.932 3.47852 26.1533 3.47852C26.9674 3.47852 27.694 3.66113 28.3337 4.028C28.9734 4.39487 29.473 4.92225 29.8334 5.61422ZM28.4549 8.04719C28.4549 7.16359 28.2133 6.44868 27.7308 5.90247C27.2484 5.35626 26.6177 5.08275 25.8379 5.08275C25.059 5.08275 24.4307 5.35299 23.954 5.89347C23.4773 6.43394 23.2389 7.14066 23.2389 8.01279C23.2389 8.90786 23.4773 9.63422 23.954 10.1927C24.4307 10.7504 25.059 11.0296 25.8379 11.0296C26.6169 11.0296 27.2476 10.7504 27.7308 10.1927C28.2141 9.63504 28.4549 8.91932 28.4549 8.04719Z"
                                                            fill="#121A0F" />
                                                        <path
                                                            d="M34.397 5.23794V3.5813H35.9492V1.08691L37.8503 1.08691V3.58048L39.9963 3.58048V5.23712H37.8503V9.89342C37.8503 10.2423 37.9199 10.4896 38.06 10.6345C38.1992 10.7795 38.4376 10.8524 38.775 10.8524H40.2052V12.509H38.3909C37.5423 12.509 36.9231 12.3116 36.5332 11.9161C36.1433 11.5206 35.9492 10.9105 35.9492 10.085V5.23794H34.397Z"
                                                            fill="#121A0F" />
                                                        <path d="M52.1954 0.302246V12.5105H50.3115V0.302246L52.1954 0.302246Z" fill="#121A0F" />
                                                        <path
                                                            d="M70.3949 3.58057V4.92357L65.4058 10.8533H70.621V12.5099L62.8765 12.5099V11.1669L67.8647 5.23721L63.0853 5.23721V3.58057L70.3949 3.58057Z"
                                                            fill="#121A0F" />
                                                        <path
                                                            d="M73.332 4.04178C73.9889 3.66345 74.7416 3.4751 75.591 3.4751C76.4519 3.4751 77.2104 3.64952 77.8673 3.99838C78.5242 4.34723 79.0419 4.84103 79.4195 5.4806C79.7979 6.12016 79.992 6.87028 80.0035 7.73013C80.0035 7.9627 79.9863 8.201 79.9511 8.44503H73.2181V8.54985C73.2648 9.32863 73.5089 9.94527 73.9504 10.3981C74.3919 10.8518 74.9792 11.0786 75.7123 11.0786C76.2938 11.0786 76.782 10.9419 77.1776 10.6684C77.5732 10.3948 77.8345 10.0083 77.9623 9.50879H79.8462C79.6832 10.4161 79.245 11.1597 78.5291 11.7411C77.8132 12.3225 76.9212 12.6133 75.8515 12.6133C74.921 12.6133 74.1101 12.4249 73.418 12.0466C72.7259 11.6682 72.191 11.1368 71.8134 10.4505C71.435 9.76429 71.2466 8.96831 71.2466 8.06178C71.2466 7.14297 71.4301 6.33799 71.7962 5.64601C72.164 4.95486 72.6751 4.42011 73.332 4.04178ZM77.3095 5.54201C76.8737 5.17596 76.3241 4.99253 75.6607 4.99253C75.0439 4.99253 74.5123 5.1817 74.0643 5.55921C73.617 5.93673 73.3574 6.43953 73.2878 7.06763L78.0852 7.06763C78.0041 6.4166 77.7453 5.90806 77.3095 5.54201Z"
                                                            fill="#121A0F" />
                                                        <path
                                                            d="M19.9722 10.2471V8.45286V6.72415C19.9722 5.67759 19.6462 4.87588 18.995 4.31739C18.3438 3.75972 17.419 3.48047 16.2215 3.48047C15.0936 3.48047 14.1804 3.72778 13.4825 4.22158C12.7846 4.7162 12.389 5.41063 12.2964 6.30569H14.146C14.2156 5.91016 14.4277 5.59406 14.7824 5.35494C15.1371 5.11664 15.5876 4.99708 16.1347 4.99708C16.7507 4.99708 17.2339 5.13957 17.582 5.42455C17.931 5.70953 18.1054 6.10178 18.1054 6.60132V7.14179L15.8554 7.14179C14.6112 7.14179 13.6635 7.3891 13.0123 7.8829C12.3612 8.37752 12.0352 9.08342 12.0352 10.0014C12.0352 10.8154 12.3374 11.455 12.9419 11.9201C13.5464 12.3852 14.3491 12.6178 15.3492 12.6178C16.6401 12.6178 17.623 12.106 18.2971 11.0832C18.2971 11.5483 18.4249 11.9029 18.6813 12.1469C18.9368 12.391 19.3554 12.513 19.9369 12.513H19.9722V10.2471ZM18.1054 8.85167C18.094 9.54937 17.8695 10.107 17.4338 10.5255C16.998 10.944 16.3903 11.1536 15.6113 11.1536C15.0994 11.1536 14.6956 11.0373 14.3991 10.8048C14.1025 10.5722 13.9543 10.2643 13.9543 9.88021C13.9543 9.43882 14.1116 9.10389 14.4253 8.87787C14.739 8.65103 15.187 8.53803 15.7686 8.53803L18.1063 8.53803V8.85167H18.1054Z"
                                                            fill="#121A0F" />
                                                        <path d="M19.9716 8.53857H18.0918V12.5299H19.9716V8.53857Z" fill="#121A0F" />
                                                        <path
                                                            d="M48.9736 10.2402V8.44602V6.71732C48.9736 5.67075 48.6476 4.86905 47.9964 4.31055C47.3453 3.75288 46.4205 3.47363 45.223 3.47363C44.0951 3.47363 43.1818 3.72094 42.484 4.21474C41.7861 4.70936 41.3905 5.40379 41.2979 6.29885H43.1474C43.217 5.90332 43.4292 5.58723 43.7839 5.34811C44.1385 5.1098 44.589 4.99025 45.1362 4.99025C45.7521 4.99025 46.2354 5.13273 46.5835 5.41771C46.9324 5.70269 47.1069 6.09495 47.1069 6.59448V7.13496L44.8569 7.13496C43.6127 7.13496 42.665 7.38227 42.0138 7.87607C41.3626 8.37068 41.0366 9.07658 41.0366 9.99457C41.0366 10.8086 41.3389 11.4481 41.9434 11.9133C42.5478 12.3784 43.3506 12.611 44.3507 12.611C45.6416 12.611 46.6245 12.0992 47.2986 11.0763C47.2986 11.5415 47.4264 11.8961 47.6827 12.1401C47.9383 12.3841 48.3568 12.5062 48.9384 12.5062H48.9736V10.2402ZM47.1069 8.84483C47.0954 9.54254 46.871 10.1002 46.4353 10.5187C45.9995 10.9371 45.3917 11.1468 44.6128 11.1468C44.1008 11.1468 43.697 11.0305 43.4005 10.7979C43.104 10.5653 42.9558 10.2574 42.9558 9.87337C42.9558 9.43198 43.113 9.09705 43.4267 8.87104C43.7404 8.64502 44.1885 8.53119 44.77 8.53119L47.1077 8.53119V8.84483H47.1069Z"
                                                            fill="#121A0F" />
                                                        <path d="M48.9731 8.53174H47.0933V12.5231H48.9731V8.53174Z" fill="#121A0F" />
                                                        <path d="M58.4346 12.5844L54.9461 3.58545L53.0605 3.58545L56.5491 12.5844L58.4346 12.5844Z"
                                                            fill="#121A0F" />
                                                        <path
                                                            d="M60.4387 3.58627L56.9822 12.5344L57.0018 12.5852L56.6357 13.4393C56.625 13.4655 56.6152 13.4868 56.6046 13.5114L56.5906 13.5466L56.5898 13.5458C56.4555 13.8652 56.3244 14.0814 56.1991 14.1804C56.0599 14.291 55.8092 14.3459 55.4488 14.3459H54.1235V16.0025H56.1467C56.5767 16.0025 56.9199 15.9296 57.1755 15.7847C57.431 15.6397 57.6464 15.4244 57.8209 15.1394C57.9954 14.8544 58.187 14.4449 58.3967 13.9102L62.4439 3.58545L60.4387 3.58545V3.58627Z"
                                                            fill="#121A0F" />
                                                        <path d="M23.2398 3.58057L21.373 3.58057V11.7467H23.2398V3.58057Z" fill="#121A0F" />
                                                        <path
                                                            d="M33.565 1.13418C33.565 1.46011 33.4544 1.73035 33.2333 1.94572C33.0121 2.16109 32.7385 2.26837 32.4134 2.26837C32.0874 2.26837 31.8138 2.16109 31.5934 1.94572C31.3723 1.73035 31.2617 1.46011 31.2617 1.13418C31.2617 0.808259 31.3723 0.538021 31.5934 0.322649C31.8146 0.107277 32.0882 0 32.4134 0C32.7394 0 33.0129 0.107277 33.2333 0.322649C33.4552 0.538021 33.565 0.808259 33.565 1.13418ZM33.3561 3.57698V12.5104H31.4714V3.57698L33.3561 3.57698Z"
                                                            fill="#121A0F" />
                                                        <path d="M7.67676 0.19873L11.0612 0.19873V3.58245L7.67676 0.19873Z" fill="#52D3A2" />
                                                        <path
                                                            d="M9.05424 8.35994C8.85602 9.13872 8.47596 9.74962 7.91161 10.191C7.34726 10.6332 6.64693 10.8543 5.80982 10.8543C5.0538 10.8543 4.39115 10.6652 3.82106 10.2876C3.25098 9.91013 2.81522 9.38357 2.51297 8.70961C2.21073 8.03565 2.0592 7.26834 2.0592 6.40767C2.0592 5.53553 2.21073 4.76576 2.51297 4.09672C2.81522 3.42849 3.2518 2.90521 3.82106 2.52688C4.37068 2.16246 5.00793 1.97575 5.73037 1.96265V1.96101H5.78688C5.79426 1.96101 5.80163 1.9602 5.80982 1.9602C5.81719 1.9602 5.82374 1.96101 5.83112 1.96101H6.11206V0.203644C6.0408 0.201187 5.96954 0.19873 5.89746 0.19873C4.71142 0.19873 3.67363 0.457505 2.78327 0.975053C1.89374 1.49178 1.20734 2.21815 0.724077 3.15416C0.241632 4.09017 0 5.1744 0 6.40685C0 7.65077 0.241632 8.74155 0.724077 9.67674C1.20652 10.6127 1.89292 11.3367 2.78246 11.8485C3.67199 12.3603 4.70978 12.6158 5.89664 12.6158C6.82713 12.6158 7.65851 12.4414 8.39078 12.0925C9.12305 11.7437 9.71935 11.2499 10.1789 10.6103C10.6384 9.97073 10.9316 9.22061 11.0594 8.36076H9.05424V8.35994Z"
                                                            fill="#121A0F" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="w-full flex flex-wrap justify-start items-end space-x-3 px-2 mt-8 space-y-3">
                                                @foreach($selectedRows as $title => $row)
                                                    <div class="rounded-full relative whitespace-nowrap border flex space-x-2.5 justify-between items-center h-[40px] px-2">

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <circle cx="8" cy="8" r="6" fill="{{$row['color'] ?? '#7C8286'}}"/>
                                                            </svg>
                                                        <span class="flex items-center justify-center hover:cursor-pointer">
                                                            {{$title}}


                                                        </span>
                                                        @if($row['type'] == 'line')
                                                        <svg class="hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M3.33333 2V12.6667H14V14H2V2H3.33333ZM13.2929 3.95956L14.7071 5.37377L10.6667 9.4142L8.66667 7.414L6.04044 10.0405L4.62623 8.6262L8.66667 4.58579L10.6667 6.586L13.2929 3.95956Z" fill="#3561E7"/>
                                                            </svg>

                                                            @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
                                                                <path d="M0.333008 6.66667H4.33301V12H0.333008V6.66667ZM4.99967 0H8.99967V12H4.99967V0ZM9.66634 3.33333H13.6663V12H9.66634V3.33333Z" fill="#3561E7"/>
                                                            </svg>
                                                            @endif
                                                            <svg class="hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" wire:click="toggleChartType('{{$title}}')" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#464E49"/>
                                                            </svg>
                                                        @if($isOpen === $title)
                                                            <div class="absolute z-20 bg-white top-[45px] right-[-30px] border-[#D4DDD7] shadow-md rounded-lg">
                                                                <ul class="px-4 py-2">
                                                                    <li onclick="changeChartType('{{$title}}', 'line')" class="flex p-2 items-center hover:cursor-pointer">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                                                                            <path d="M1.33333 0V10.6667H12V12H0V0H1.33333ZM11.2929 1.95956L12.7071 3.37377L8.66667 7.4142L6.66667 5.414L4.04044 8.04047L2.62623 6.6262L6.66667 2.58579L8.66667 4.586L11.2929 1.95956Z" fill="#3561E7"/>
                                                                        </svg>
                                                                        <p class="ml-2 mr-3">Line Chart</p>
                                                                        @if($chartType === 'line')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                                                <path d="M7.99967 14.6668C4.31777 14.6668 1.33301 11.682 1.33301 8.00016C1.33301 4.31826 4.31777 1.3335 7.99967 1.3335C11.6815 1.3335 14.6663 4.31826 14.6663 8.00016C14.6663 11.682 11.6815 14.6668 7.99967 14.6668ZM7.99967 13.3335C10.9452 13.3335 13.333 10.9457 13.333 8.00016C13.333 5.05464 10.9452 2.66683 7.99967 2.66683C5.05415 2.66683 2.66634 5.05464 2.66634 8.00016C2.66634 10.9457 5.05415 13.3335 7.99967 13.3335ZM7.33474 10.6668L4.50633 7.83843L5.44915 6.89556L7.33474 8.78123L11.106 5.00998L12.0488 5.95278L7.33474 10.6668Z" fill="#13B05B"/>
                                                                            </svg>
                                                                        @endif
                                                                    </li>
                                                                    <li onclick="changeChartType('{{$title}}', 'bar')" class="flex p-2 items-center hover:cursor-pointer">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
                                                                            <path d="M0.333008 6.66667H4.33301V12H0.333008V6.66667ZM4.99967 0H8.99967V12H4.99967V0ZM9.66634 3.33333H13.6663V12H9.66634V3.33333Z" fill="#3561E7"/>
                                                                        </svg>
                                                                        <p class="ml-2 mr-3">Bar Chart</p>
                                                                        @if($chartType === 'bar')
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                                                <path d="M7.99967 14.6668C4.31777 14.6668 1.33301 11.682 1.33301 8.00016C1.33301 4.31826 4.31777 1.3335 7.99967 1.3335C11.6815 1.3335 14.6663 4.31826 14.6663 8.00016C14.6663 11.682 11.6815 14.6668 7.99967 14.6668ZM7.99967 13.3335C10.9452 13.3335 13.333 10.9457 13.333 8.00016C13.333 5.05464 10.9452 2.66683 7.99967 2.66683C5.05415 2.66683 2.66634 5.05464 2.66634 8.00016C2.66634 10.9457 5.05415 13.3335 7.99967 13.3335ZM7.33474 10.6668L4.50633 7.83843L5.44915 6.89556L7.33474 8.78123L11.106 5.00998L12.0488 5.95278L7.33474 10.6668Z" fill="#13B05B"/>
                                                                            </svg>
                                                                        @endif
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        @endif

                                                        <span wire:click="unselectRow('{{ $title }}')" class="rounded-full bg-white border-2 border-red-500 text-red-500 w-5 h-5 flex items-center ml_4 justify-center cursor-pointer">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-3 h-3">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                               </div>
                                @endif
                                <div class="flex justify-between mt-7">
                                    <div class="warning-wrapper ">
                                        <div class="warning-text">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.99967 14.6663C4.31777 14.6663 1.33301 11.6815 1.33301 7.99967C1.33301 4.31777 4.31777 1.33301 7.99967 1.33301C11.6815 1.33301 14.6663 4.31777 14.6663 7.99967C14.6663 11.6815 11.6815 14.6663 7.99967 14.6663ZM7.99967 13.333C10.9452 13.333 13.333 10.9452 13.333 7.99967C13.333 5.05415 10.9452 2.66634 7.99967 2.66634C5.05415 2.66634 2.66634 5.05415 2.66634 7.99967C2.66634 10.9452 5.05415 13.333 7.99967 13.333ZM7.33301 9.99967H8.66634V11.333H7.33301V9.99967ZM7.33301 4.66634H8.66634V8.66634H7.33301V4.66634Z" fill="#DA680B"/>
                                            </svg>
                                            Click on any of the row(s) to chart the data
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end items-baseline" wire:ignore.self>
                                    <span class="currency-font">Currency: &nbsp;</span>
                                    <select wire:model="currency" id="currency-select" class="inline-flex font-bold !pr-8 bg-transparent">
                                        <option value="USD">USD</option>
                                        <option value="CAD">CAD</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>
                                </div>
                                <div class="w-full">
                                    <div class="table-wrapper w-full" style="font-size: 12px;">
                                        <div class="table" wire:key="{{now()}}">
                                            <div class="row-group">
                                                <div class="flex flex-row bg-gray-custom-light">
                                                    <div class="w-[250px] font-bold flex py-2 items-center justify-start text-base">
                                                        <span class="ml-6">
                                                            {{$companyName}} ({{$ticker}})
                                                        </span>
                                                    </div>
                                                    <div class="w-full flex flex-row bg-gray-custom-light justify-between">
                                                        @foreach ($reverse ? array_reverse($tableDates) : $tableDates as $date)
                                                            <div class="w-[150px] flex items-center justify-center text-base font-bold">
                                                                <span class="py-2">
                                                                    {{ date('M Y', strtotime($date)) }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="divide-y text-base">
                                                    @if(!$tableLoading)
                                                        @foreach($rows as $key=> $row)
                                                            <livewire:company-report-table-row :data="$row" wire:key="{{Str::random()}}" :selectedRows="$selectedRows" :reverse="$reverse" :itemKey="$row['title']" :startDate="$startDate" :endDate="$endDate"/>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>

    let mainDiv = document.getElementById('main-report-div')
    mainDiv.addEventListener('click', function(){
        let leftSlideOpen = document.getElementById('leftSlideOpen').value
        let rightSlideOpen = document.getElementById('rightSlideOpen').value

        if(leftSlideOpen || rightSlideOpen){
            Livewire.emit('closeSlide')
        }
    })

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
        updateRangeSlider();


        Livewire.hook('message.processed', (message, component) => {
            if (message.updateQueue.some(update => update.payload.value === 'Standardised Template' || 'As reported (Harmonized)')) {
                updateRangeSlider();
            }
        });


        // Livewire.hook('element.updated', () => {
        //     if(!chart) {
        //         initChart()
        //     } else {
        //         updateChart()
        //     }
        // })

        function updateRangeSlider() {

            let el = document.querySelector('#range-slider-company-report');

            if(!el) {
                return;
            }
            let rangeDates = @this.rangeDates

            let selectedValue = [];

            if (rangeDates.length > 0) {
                if(rangeDates[0] > rangeDates[rangeDates.length - 1]){
                    rangeDates.reverse();
                }

                selectedValue = [rangeDates[0], rangeDates[rangeDates.length - 1]]
            }

            let startDate;
            let endDate;

            if (@this.startDate && Number.isInteger(@this.startDate)) {
                startDate = @this.startDate
            } else {
                startDate = new Date(@this.startDate).getFullYear()
            }

            if (@this.endDate && Number.isInteger(@this.endDate)) {
                endDate = @this.endDate
            } else {
                endDate = new Date(@this.endDate).getFullYear()
            }


            let rangeMin = new Date(selectedValue[0]).getFullYear();
            let rangeMax = selectedValue[1] ? new Date(selectedValue[1]).getFullYear() : new Date().getFullYear();


            selectedValue[0] = startDate ?? rangeMax - 6;
            selectedValue[1] = endDate ?? rangeMax;


            let valueAfter = null;



            rangeSlider(el, {
                step: 1,
                min: rangeMin,
                max: rangeMax,
                value: selectedValue,
                rangeSlideDisabled: true,
                onThumbDragEnd: (data) => {

                    recognizeDotsStatus(valueAfter, [rangeMin, rangeMax]);
                    console.log(valueAfter);
                    @this.changeDates(valueAfter)

                    // if (chart) {
                    //     chart.destroy();
                    // }
                },
                onInput: (value, userInteraction) => {
                    if (value.length === 2 && value !== selectedValue) {
                        valueAfter = value;
                        recognizeDotsStatus(valueAfter, [rangeMin, rangeMax]);
                    }
                }
            });

            recognizeDotsStatus(selectedValue, [rangeMin, rangeMax]);
        }
    });


    Livewire.on('slide-over.close', () => {
        slideOpen = false;
    });


    Livewire.on('initCompanyReportChart', () => {
        initChart();
    });

    Livewire.on('updateCompanyReportChart', () => {
        updateChart();
    });

    Livewire.on('hideCompanyReportChart', () => {
        if (chart) {
            chart.destroy();
        }
    });

    // const annualCheckbox = document.getElementById("date-annual");

    // annualCheckbox.addEventListener("click", function() {
    //     const currentUrl = window.location.href;

    //     const separator = currentUrl.includes('?') ? '&' : '?';

    //     const newUrl = currentUrl + separator + 'period=annual';

    //     window.location.href = newUrl;
    // });

    // const quarterlyCheckbox = document.getElementById("date-quarterly");

    // quarterlyCheckbox.addEventListener("click", function() {
    //     const currentUrl = window.location.href;

    //     const separator = currentUrl.includes('?') ? '&' : '?';

    //     const newUrl = currentUrl + separator + 'period=quarterly';

    //     window.location.href = newUrl;
    // });

    // const viewDropdownCloseIcon = document.getElementById("viewClose");

    // viewDropdownCloseIcon.addEventListener("click", function() {
    //     document.getElementById('dropdown-View').classList.toggle("hidden");
    // });
    // const periodDropdownCloseIcon = document.getElementById("periodClose");

    // periodDropdownCloseIcon.addEventListener("click", function() {
    //     document.getElementById('dropdown-Period').classList.toggle("hidden");
    // });

    // const unitTypeDropdownCloseIcon = document.getElementById("unitTypeClose");

    // unitTypeDropdownCloseIcon.addEventListener("click", function() {
    //     document.getElementById('dropdown-UnitType').classList.toggle("hidden");
    // });

    // const templateDropdownCloseIcon = document.getElementById("templateClose");

    // templateDropdownCloseIcon.addEventListener("click", function() {
    //     document.getElementById('dropdown-Template').classList.toggle("hidden");
    // });

    // const orderDropdownCloseIcon = document.getElementById("orderClose");

    // orderDropdownCloseIcon.addEventListener("click", function() {
    //     document.getElementById('dropdown-Order').classList.toggle("hidden");
    // });

    // const freezePanesDropdownCloseIcon = document.getElementById("freezePanesClose");

    // freezePanesDropdownCloseIcon.addEventListener("click", function() {
    //     document.getElementById('dropdown-FreezePanes').classList.toggle("hidden");
    // });

    const decimalDropdownCloseIcon = document.getElementById("decimalClose");

    decimalDropdownCloseIcon.addEventListener("click", function() {
        document.getElementById('dropdown-Decimal').classList.toggle("hidden");
    });

    const currencyDropdownCloseIcon = document.getElementById("currencyClose");

    decimalDropdownCloseIcon.addEventListener("click", function() {
        document.getElementById('dropdown-Currency').classList.toggle("hidden");
    });

    let chart = null;

    const getOrCreateTooltip = (chart) => {
        let tooltipEl = chart.canvas.parentNode.querySelector('div');

        if (!tooltipEl) {
            tooltipEl = document.createElement('div');
            tooltipEl.style.background = '#fff';
            tooltipEl.style.borderRadius = '25px';
            tooltipEl.style.color = 'black';
            tooltipEl.style.opacity = 1;
            tooltipEl.style.pointerEvents = 'none';
            tooltipEl.style.position = 'absolute';
            tooltipEl.style.transform = 'translate(-50%, 0)';
            tooltipEl.style.transition = 'all .1s ease';
            tooltipEl.style.minWidth = '230px';
            tooltipEl.style.filter = 'drop-shadow(0px 10.732307434082031px 21.464614868164062px rgba(50, 50, 71, 0.06)) drop-shadow(0px 10.732307434082031px 10.732307434082031px rgba(50, 50, 71, 0.08))';
            tooltipEl.classList.add('tooltip-caret')

            const table = document.createElement('table');
            table.style.margin = '0px';

            tooltipEl.appendChild(table);
            chart.canvas.parentNode.appendChild(tooltipEl);
        }

        return tooltipEl;
    };

    const externalTooltipHandler = (context) => {
        // Tooltip Element
        const {chart, tooltip} = context;
        const tooltipEl = getOrCreateTooltip(chart);

        // Hide if no tooltip
        if (tooltip.opacity === 0) {
            tooltipEl.style.opacity = 0;
            return;
        }

        // Set Text
        if (tooltip.body) {
            const titleLines = tooltip.title || [];
            const bodyLines = tooltip.body.map(b => b.lines);

            const tableHead = document.createElement('thead');

            tableHead.style.color = '#3561E7';
            tableHead.style.textAlign = 'left';
            tableHead.style.marginBottom = '8px';

            titleLines.forEach(title => {
                const tr = document.createElement('tr');
                tr.style.borderWidth = 0;

                const th = document.createElement('th');
                th.style.borderWidth = 0;
                const text = document.createTextNode(title);

                th.appendChild(text);
                tr.appendChild(th);
                tableHead.appendChild(tr);
            });

            const tableBody = document.createElement('tbody');
            bodyLines.reverse().forEach((body, i) => {
                const [label, value] = body[0].split(': ');

                //label
                const trLabel = document.createElement('tr');
                trLabel.style.backgroundColor = 'inherit';
                trLabel.style.borderWidth = '0';
                trLabel.style.fontSize = '12px';
                trLabel.style.fontWeight = '400';
                trLabel.style.color = '#464E49';
                trLabel.style.paddingBottom = '0px';
                trLabel.style.marginBottom = '0px';

                const tdLabel = document.createElement('td');
                tdLabel.style.borderWidth = 0;

                const textLabel = document.createTextNode(label);

                trLabel.appendChild(textLabel);
                trLabel.appendChild(tdLabel);

                tableBody.appendChild(trLabel);

                //value
                const tr = document.createElement('tr');
                tr.style.backgroundColor = 'inherit';
                tr.style.borderWidth = '0';
                tr.style.fontSize = '16px';
                tr.style.fontWeight = '700';
                tr.style.color = '#464E49';

                const td = document.createElement('td');
                td.style.borderWidth = 0;

                const text = document.createTextNode(value);

                td.appendChild(text);
                tr.appendChild(td);

                tableBody.appendChild(tr);
            });

            const tableRoot = tooltipEl.querySelector('table');

            // Remove old children
            while (tableRoot.firstChild) {
                tableRoot.firstChild.remove();
            }

            // Add new children
            tableRoot.appendChild(tableHead);
            tableRoot.appendChild(tableBody);
        }

        const {offsetLeft: positionX, offsetTop: positionY} = chart.canvas;

        // Display, position, and set styles for font
        tooltipEl.style.opacity = 1;
        tooltipEl.style.left = positionX + tooltip.caretX + 'px';
        tooltipEl.style.top = positionY + tooltip.caretY - 125 + 'px';
        tooltipEl.style.font = tooltip.options.bodyFont.string;
        tooltipEl.style.padding = 8 + 'px ' + 19 + 'px';
    };

   async function changeChartType(title, type) {
        await @this.changeChartType(title, type)

        updateChart()
    }

    function updateChart() {
       if (chart) {
           chart.data.datasets = @this.chartData;
           chart.update();
       } else {
           initChart();
       }
    }

    // chart init
    function initChart() {
        if (chart) chart.destroy();
        let data = @this.chartData;
        let limitedData = data.slice(0, 5);
        let canvas = document.getElementById("chart-company-report");
        if (!canvas) return;
        let ctx = document.getElementById('chart-company-report').getContext("2d");
        chart = new Chart(ctx, {
            plugins: [{
                afterDraw: chart => {
                    if (chart.tooltip?._active?.length) {
                        let x = chart.tooltip._active[0].element.x;
                        let y = chart.tooltip._active[0].element.y;
                        let yAxis = chart.scales.y;
                        let ctx = chart.ctx;
                        ctx.save();
                        ctx.beginPath();
                        ctx.moveTo(x, yAxis.bottom);
                        ctx.lineTo(x, y);
                        ctx.lineWidth = 1;
                        ctx.strokeStyle = '#000';
                        ctx.setLineDash([5, 5])
                        ctx.stroke();
                        ctx.restore();
                    }
                }
            }],
            maintainAspectRatio: false,
            aspectRatio: 3,
            type: 'line',
            data: {
                datasets: limitedData
            },
            options: {
                interaction: {
                    intersect: false,
                    mode: 'nearest',
                    axis: 'xy'
                },
                animation: {
                    duration: 0,
                },
                title: {
                    display: false,
                },
                elements: {
                    line: {
                        tension: 0
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        bodyFont: {
                            size: 15
                        },
                        external: externalTooltipHandler,
                        enabled: false,
                        // position: 'nearest',
                        callbacks: {
                            title: function (context) {
                                const inputDate = new Date(context[0].label);
                                return inputDate.getFullYear();
                            },
                            label: function (context) {
                                return context.dataset.raw
                            }
                        },
                    }
                },
                scales: {
                    x: {
                        offset: false,
                        grid: {
                            display: false
                        },
                        type: 'timeseries',
                        time: {
                            unit: 'year',
                        },
                        ticks:{
                            source:'data',
                            // maxTicksLimit: data.quantity,
                            // labelOffset: data.quantity > 20 ? 5 : data.quantity < 5 ? 150 : 30
                        },
                        align: 'center',
                    },
                }
            }
        });
    }

</script>
@endpush
