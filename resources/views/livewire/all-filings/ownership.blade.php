<div class="flex flex-col">
    <div class="place-items-center fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-transparent" wire:loading.grid>
        <span class="mx-auto simple-loader !text-blue"></span>
    </div>
    <!-- just for responsive view  -->
    <div class="mr-2 md:hidden absolute top-[52%] right-[2%] bg-white p-2 rounded-full">
        <div @click="open=true" class="flex justify-between items-center">
            <div><img src="{{asset('/svg/filter-list.svg')}}"/></div>
            <h4 class="text-sm ml-2 text-[#121A0F] font-[400]">Table Optios</h4>
        </div>
    </div>
    <div class="hidden md:flex justify-between items-center mt-4 flex-wrap">
        <div class="flex justify-start items-center">
            <div class="flex ml-2 relative justify-center mt-0 mx-0 mb-3" x-data="{dropdownMenu: false}" @keydown.window.escape="dropdownMenu = false" @click.away="dropdownMenu = false">
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
    <livewire:all-filings.common-layout key="{{ now() }}" :order="$order" :col="$col" :data="$data"/>
</div>


