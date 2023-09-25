<div class="py-2">
            <div class="px-5 w-full bg-gray-100">
                <div class="mt-8 flow-root overflow-x-auto">
                    <div class="align-middle">
                        <div class="inline-block min-w-full sm:rounded-lg">
                            <div wire:loading.flex class="justify-center items-center">
                                <div class="grid place-content-center h-full" role="status">
                                    <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div class="py-2" wire:loading.remove>
                                <div class="flex w-full justify-between">
                                    <div class="page-titles">
                                        <b>{{ @$companyName }}  @if(@$ticker) ({{ @$ticker }}) @endif </b> <br>
                                        <b>$345</b> <small class="text-color-green">(+0.40%)</small>
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

                                <div class="tabs-wrapper flex">
                                    <a href="{{route('company.report', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.report'])>Income Statement</a>
                                    <a href="{{route('company.metrics', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.metrics'])>Balance Sheet</a>
                                    <a href="{{route('company.filings', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.filings'])>Cash Flow</a>
                                    <a href="{{route('company.geographic', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.geographic'])>Segments</a>
                                    <a href="{{route('company.shareholders', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.shareholders'])>Ratios</a>
                                    <a href="{{route('company.executive.compensation', ['ticker' => $company->ticker, 'period' => $period])}}" @class(['tab','px-3', 'active' => $currentRoute === 'company.executive.compensation'])>Consolidated Statements</a>
                                </div>

                                <div class="filters-row">
                                    <div class="select-wrapper flex items-center">
                                        <div class="ml-3 flex items-center">View
                                            <button type="submit" id="dropdownViewButton" data-dropdown-toggle="dropdown-View" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2.5" name="view" id="">
                                                {{$view}}
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                </svg>
                                            </button>
                                            <!-- Dropdown menu -->
                                            <div id="dropdown-View" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                                                <div class="p-3 text-sm flex items-center justify-between">
                                                    <div>View</div>
                                                    <svg id="viewClose" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                    </svg>
                                                </div>
                                                <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll" aria-labelledby="dropdownViewButton">
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="view" @if($view === 'As reported (Harmonized)') checked @endif id="view-radio-1" name="view-radio" type="radio" value="As reported (Harmonized)" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="view-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>As reported (Harmonized)</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="view" @if($view === 'Adjusted') checked @endif id="view-radio-2" name="view-radio" type="radio" value="Adjusted" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="view-radio-2" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Adjusted</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="view" @if($view === 'Standardised Template') checked @endif id="view-radio-3" name="view-radio" type="radio" value="Standardised Template" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="view-radio-3" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Standardised Template</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="view" @if($view === 'Per Share') checked @endif id="view-radio-4" name="view-radio" type="radio" value="Per Share" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="view-radio-4" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Per Share</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="view" @if($view === 'Common size') checked @endif id="view-radio-5" name="view-radio" type="radio" value="Common size" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="view-radio-5" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Common size</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="mx-3 my-4">
                                                    <button class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center" id="viewCloseButton">Show Result</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex items-center">Unit Type
                                            <button type="submit" id="dropdownUnitTypeButton" data-dropdown-toggle="dropdown-UnitType" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2.5" name="view" id="">
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
                                        <div class="ml-3 flex items-center">Template
                                            <button type="submit" id="dropdownTemplateButton" data-dropdown-toggle="dropdown-Template" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2.5" name="view" id="">
                                                {{$template}}
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"/>
                                                </svg>
                                            </button>
                                            <!-- Dropdown menu -->
                                            <div id="dropdown-Template" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                                                <div class="p-3 text-sm flex items-center justify-between">
                                                    <div>Template</div>
                                                    <svg id="templateClose" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="#686868"/>
                                                    </svg>
                                                </div>
                                                <ul class="p-4 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-y-scroll" aria-labelledby="dropdownViewButton">
                                                    <li>
                                                        <div class="flex p-2 rounded hover:bg-[#52D3A233] cursor-pointer">
                                                            <div class="flex items-center h-5 cursor-pointer">
                                                                <input wire:model="template" @if($view === 'Standart') checked @endif id="template-radio-1" name="template-radio" type="radio" value="Standart" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="template-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>Standart</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="mx-3 my-4">
                                                    <button class="w-full p-1 text-sm bg-[#52D3A2] rounded text-center" id="templateCloseButton">Show Result</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex items-center">Order
                                            <button type="submit" id="dropdownOrderButton" data-dropdown-toggle="dropdown-Order" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2.5" name="view" id="">
                                                {{$order}}
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
                                                                <input wire:model="order" @if($order === 'Latest on the Right') checked @endif id="order-radio-1" name="order-radio" type="radio" value="Latest on the Right" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
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
                                                                <input wire:model="order" @if($order === 'Latest on the Left') checked @endif id="order-radio-1" name="order-radio" type="radio" value="Latest on the Left" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
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
                                        <div class="ml-3 flex items-center">Freeze Panes
                                            <button type="submit" id="dropdownFreezePanesButton" data-dropdown-toggle="dropdown-FreezePanes" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2.5" name="view" id="">
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
                                        <div class="ml-3 flex items-center">Decimal
                                            <button type="submit" id="dropdownDecimalButton" data-dropdown-toggle="dropdown-Decimal" class="flex items-center flowbite-select bg-gray-50 border border-gray-700 text-gray-900 text-sm ml-2 p-2.5" name="view" id="">
                                                {{$decimal}}
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
                                                                <input wire:model="decimal" @if($view === '.00') checked @endif id="decimal-radio-1" name="decimal-radio" type="radio" value=".00" class="cursor-pointer w-4 h-4 text-[#686868] bg-transpearent border-[#686868] border-2">
                                                            </div>
                                                            <div class="ml-4 text-sm cursor-pointer">
                                                                <label for="decimal-radio-1" class="cursor-pointer font-medium text-gray-900 dark:text-gray-300">
                                                                    <div>.00</div>
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
                                <div class="filters-row flex items-center mt-2">
                                    <b class="mr-3">Period Type:</b>
                                    <ul class="flex soft-radio-wrapper big-checked items-center">
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3">
                                                <input wire:model="period" @if($period === 'fiscal-annual') checked @endif value="fiscal-annual" id="date-fiscal-annual" type="radio" name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-3 ml-2 ">Fiscal Annual</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3">
                                                <input wire:model="period" @if($period === 'fiscal-quaterly') checked @endif value="fiscal-quaterly" id="date-fiscal-quaterly" type="radio"  name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-3 ml-2 ">Fiscal Quaterly</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3">
                                                <input wire:model="period" @if($period === 'fiscal-semi-annual') checked @endif value="fiscal-semi-annual" id="date-fiscal-semi-annual" type="radio"  name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-3 ml-2 ">Fiscal Semi-Annual</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3">
                                                <input wire:model="period" @if($period === 'YTD') checked @endif value="YTD" id="date-YTD" type="radio"  name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-3 ml-2 ">YTD</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3">
                                                <input wire:model="period" @if($period === 'LTM') checked @endif value="LTM" id="date-LTM" type="radio"  name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-3 ml-2 ">LTM</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3">
                                                <input wire:model="period" @if($period === 'annual') checked @endif value="annual" id="date-annual" id="annual" type="radio" name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-3 ml-2 ">Calendar Annual</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3">
                                                <input wire:model="period" @if($period === 'quarterly') checked @endif value="quarterly" id="date-quarterly" type="radio"  name="date-range" class="w-5 h-5 ">
                                                <span class="w-full py-3 ml-2 ">Calendar Quaterly</span>
                                            </label>
                                        </li>
                                        <li class="mr-2">
                                            <label class="flex items-center pl-3">
                                                <input wire:model="period" @if($period === 'SA') checked @endif value="SA" id="date-SA" type="radio"  name="date-sa" class="w-5 h-5 ">
                                                <span class="w-full py-3 ml-2 ">Calendar SA</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>

                                <div class="years-range-wrapper my-2" wire:ignore>
                                    <div class="dots-wrapper"></div>
                                    <div id="range-slider" class="range-slider"></div>
                                </div>

                                <div class="warning-wrapper mt-5 -mb-2">
                                    <div class="warning-text">
                                        <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.99967 14.6663C4.31777 14.6663 1.33301 11.6815 1.33301 7.99967C1.33301 4.31777 4.31777 1.33301 7.99967 1.33301C11.6815 1.33301 14.6663 4.31777 14.6663 7.99967C14.6663 11.6815 11.6815 14.6663 7.99967 14.6663ZM7.99967 13.333C10.9452 13.333 13.333 10.9452 13.333 7.99967C13.333 5.05415 10.9452 2.66634 7.99967 2.66634C5.05415 2.66634 2.66634 5.05415 2.66634 7.99967C2.66634 10.9452 5.05415 13.333 7.99967 13.333ZM7.33301 9.99967H8.66634V11.333H7.33301V9.99967ZM7.33301 4.66634H8.66634V8.66634H7.33301V4.66634Z" fill="#DA680B"/>
                                        </svg>
                                        Click on any of the row(s) to chart the data
                                    </div>
                                </div>

                                <div class="table-wrapper" style="font-size: 12px;">
                                    <div class="table min-w-full data border-collapse">
                                        <div class="row row-head">
                                            <div class="cell">Date</div>
                                            @foreach(array_keys($this->metrics) as $date)
                                                <div class="cell">{{ $date }}</div>
                                            @endforeach
                                        </div>
                                        {!! $table !!}
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
    let slideOpen = false;

    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(event) {
            var element = event.target;
            if (element.classList.contains('open-slide') && !slideOpen) {
                var value = element.dataset.value;
                var payload = JSON.parse(value);
                window.livewire.emit('slide-over.open', 'company-fact-slide', payload, {force: true});
                slideOpen = true;
            }
        });
    });

    Livewire.on('slide-over.close', () => {
        slideOpen = false;
    });
</script>
@endpush
