<div class="flex flex-col">
    <div class="place-items-center fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-transparent" wire:loading.grid>
        <span class="mx-auto simple-loader !text-blue"></span>
    </div>
    <!-- just for responsive view  -->
    <div class="mr-2 md:hidden absolute top-[52%] right-[2%] bg-white p-2 rounded-full {{$checkedCount ? 'border-2 border-[#2C71F0] bg-[#EAF1FE]' : ''}}">
        <div @click="open=true" class="flex justify-between items-center">
            <div><img src="{{asset('/svg/filter-list.svg')}}"/></div>
            <div class="flex justify-between items-center">
                <h4 class="text-sm ml-2 text-[#121A0F] font-[400]">Table Optios</h4>
                @if($checkedCount)
                    <span class="bg-[#2C71F0] px-3 ml-2 py-0 rounded-full text-[0.625rem] font-[600] text-white">{{$checkedCount}}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="hidden md:flex justify-between items-center mt-4 flex-wrap">
        <div class="flex justify-start items-center">
            <div class="flex ml-2 relative justify-center mt-0 mx-0 mb-3" x-data="{dropdownMenu: false}" @keydown.window.escape="dropdownMenu = false" @click.away="dropdownMenu = false">
                <button @click="dropdownMenu = ! dropdownMenu" class="flex items-center py-2 px-4 rounded-full w-full border-[#939598] bg-[#fff] z-20">
                    <span class="mr-4 text-sm p-x-4 font-[400]"> Sort by {{$col}}</span>
                    <svg class="w-5 h-5 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="dropdownMenu" class="absolute left-0 py-2 mt-10 bg-white  rounded-md shadow-xl w-44 z-50">
                    <div class="flex justify-start items-center content-start">
                        <a  wire:click.prevent="sortingOrder(['form_type','{{ $order}}'])"  class="block px-4 py-2 text-sm font-[400] cursor-pointer">
                            Sort by form type {{$col === 'form_type' ? "(sorting by $order )" : '' }}
                        </a>
                    </div>
                    <div class="flex justify-start items-center content-start">
                        <a  wire:click.prevent="sortingOrder(['filing_date', '{{$order}}'])"  class="block px-4 py-2 text-sm font-[400] cursor-pointer">
                            Sort by filing date {{$col === 'filing_date' ? "(sorting by $order )" : '' }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex ml-2 relative justify-between mt-0 mx-0 mb-3" x-data="{dropdownMenu: false}" @keydown.window.escape="dropdownMenu = false" @click.away="dropdownMenu = false">
                <button @click="open = ! open" class="flex {{$checkedCount ? 'bg-[#E2E2E2] border-2 border-[#9DA3A8]' : ''}} justify-between items-center py-2 px-4 rounded-full border-[#939598] bg-[#fff] z-20">
                    <span class="mr-4 text-sm p-x-4 font-[400] text-[#01090F]"> Select Filing Type</span>
                    @if($checkedCount)
                        <span class="bg-[#2C71F0] px-3 py-0 rounded-full text-[0.625rem] font-[600] text-white">{{$checkedCount}}</span>
                    @endif
                    <svg class="w-5 h-5 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- <div x-show="dropdownMenu" class="absolute left-0 py-2 mt-10 bg-white  rounded-md shadow-xl w-44 z-50">
                    <div class="flex justify-start items-center content-start">
                        <a href="javascript;" @click.prevent="open=true" class="block px-4 py-2 text-sm text-[#01090F] font-[400]">
                            Select Filing Type
                        </a>
                    </div>
                    <div class="flex justify-start items-center content-start">
                        <a href="javascript;" @click.prevent="open=true"   class="block px-4 py-2 text-sm font-[600]">
                            Sort by title
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="search mr-2">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-400">Search</label>
            <div class="relative p-0 m-0 sm:mt-3 md:mt-3">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" wire:keydown="handleSearchAllDocuments($event?.target?.value)"  id="default-search" class="flex focus:outline-none focus:ring-0 focus:border-blue-500 h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 border-b-2 border-t-0 border-l-0 border-r-0 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Search">
            </div>
        </div>
    </div>
    <livewire:all-filings.common-layout key="{{ now() }}" :order="$order" :data="$data"/>
</div>
