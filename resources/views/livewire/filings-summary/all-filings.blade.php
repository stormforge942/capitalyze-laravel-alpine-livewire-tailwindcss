<div class="flex flex-col" x-data="{ open: false }">
    <div class="hidden md:flex bg-[#F2F2F2] w-full border-b-2 border-[#E4E4E4] justify-between">
        <div wire:click.prevent="handleTabs('all-documents')" class="mx-3 mt-1 -mb-0.5 text-[#121A0F] font-[500] text-base {{$selectedTab === 'all-documents' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">All Documents </a></div>
        <div wire:click.prevent="handleTabs('financials')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'financials' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Financials </a></div>
        <div wire:click.prevent="handleTabs('news')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'news' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">News </a></div>
        <div wire:click.prevent="handleTabs('registrations-and-prospectuses')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'registrations-and-prospectuses' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Registrations and Prospectuses </a></div>
        <div wire:click.prevent="handleTabs('proxy-materials')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'proxy-materials' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Proxy Materials</a></div>
        <div wire:click.prevent="handleTabs('ownership')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'ownership' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Ownership</a></div>
        <div wire:click.prevent="handleTabs('other')" class="mx-3 mt-1 -mb-0.5 font-[500] text-base {{$selectedTab === 'other' ? 'innertab-active text-[#121A0F]' : 'text-[#A5A5A5]'}}"><a href="#">Other </a></div>
    </div>
    <div class="md:hidden">
    <select id="countries" wire:change="handleTabs($event?.target?.value)" class="change-select-chevron text-[#121A0F] font-[500] focus:outline-none focus:ring-0 h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
            <option value="all-documents">All Documents</option>
            <option value="financials">Financials</option>
            <option value="news">News</option>
            <option value="registrations-and-prospectuses">Registrations and Prospectuses</option>
            <option value="proxy-materials">Proxy Materials</option>
            <option value="ownership">Ownership</option>
            <option value="other">Other</option>
        </select>
    </div>
    <!-- just for responsive view  -->
    <div class="mr-2 md:hidden absolute top-[52%] right-[2%] bg-white p-2 rounded-full">
        <div @click="open=true" class="flex justify-between items-center">
            <div><img src="{{url('/svg/filter-list.svg')}}"/></div>
            <h4 class="text-sm ml-2 text-[#121A0F] font-[400]">Table Optios</h4>
        </div>
    </div>
    <div class="hidden md:flex justify-between items-center mt-4">
        <div class="flex justify-between items-center">
            <div class="mr-2">
                <select id="countries" class="h-9 outline-none focus:outline  py-0.75 px-3 rounded-full border border-none border-[#939598] text-sm">
                    <option value="sort_by_date">Sort by date</option>
                    <option value="sort_by_title">Sort by title</option>
                </select>
            </div>
            <div class="ml-2">
                <select id="countries" @change="open=true" class="h-9 outline-none focus:outline  py-0.75 px-3 rounded-full border border-none border-[#939598] text-sm">
                    <option value="sort_by_date">Select Filing Type</option>
                    <option value="sort_by_title">Sort by title</option>
                </select>
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
                <input type="search" id="default-search" class="flex focus:outline-none focus:ring-0 focus:border-blue-500 h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 border-b-2 border-t-0 border-l-0 border-r-0 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Search">
            </div>
        </div>
    </div>
    @if($selectedTab === 'all-documents')
        <livewire:is :component="'all-filings.'. $selectedTab"/>
    @elseif($selectedTab === 'financials')
        <livewire:is :component="'all-filings.'. $selectedTab"/>
    @endif
    <!-- Dialog (full screen) -->
    <div class="absolute top-10 left-0 flex items-center justify-center w-full h-full" style="background-color: rgba(0,0,0,.5);" x-show="open"  >
        <livewire:all-filings.filings-pop-up/>
    </div>
</div>
