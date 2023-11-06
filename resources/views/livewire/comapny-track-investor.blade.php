<div class="bg-gray-100" style="margin-top: -2.5rem;">
    <div class="px-0 sm:px-6 lg:px-0 py-4 mt-6">
        <div class="place-items-center fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-transparent" wire:loading.grid>
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
        <div class="flex sm:items-start flex-col company-profile-page mt-0 mb-0">
            <div class="page-titles flex justify-start content-start mb-0 mt-2 mx-0">
                <div> <h4 class="text-sm font-[500] pr-1 mt-2">TrackInvestors</h4></div>
                <div class="pr-1 mt-0 mb-1"> <span class="text-sm font-[500">/</span> </div>
                <div> <h5 class="text-sm font-[500] pr-1 mt-2">Discover</h5></div>
                <div class="pr-0 mt-3"><img class="pr-1" src="{{url('/svg/chevron.svg')}}" alt=""/> </div>
            </div>   
            <div class="hidden md:flex tabs-wrapper w-full">
                <div @class(['tab text-base font-[500]', 'active font-[600]' => $infoTabActive == 'track-investor']) wire:click="setInfoActiveTab('track-investor')">TrackInvestor</div>
                <div @class(['tab text-base font-[500]', 'active font-[600]' => $infoTabActive == 'other-favorites']) wire:click="setInfoActiveTab('other-favorites')">Other Favorites</div>
            </div>
            <div class="hidden md:flex content-between items-center justify-between w-full">
                <div class=" title font-semibold text-2xl">TrackInvestor Funds</div>
                <div class="search mr-2">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-400">Search</label>
                    <div class="relative p-0 m-0 sm:mt-3 md:mt-3">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" id="default-search" wire:model.lazy="searchValue" wire:keydown="filterData($event.target.value)" class="block focus:outline-none focus:ring-0 focus:border-blue-500 h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 border-b-2 border-t-0 border-l-0 border-r-0 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Search" required>
                    </div>
                </div>
            </div>
            <div class="flex md:hidden justify-between relative w-full mt-5 mx-0" x-data="{dropdownMenu: false}" @keydown.window.escape="dropdownMenu = false" @click.away="dropdownMenu = false">
                <button @click="dropdownMenu = ! dropdownMenu" class="flex items-center p-2 bg-[#52D3A2]  rounded">
                    <span class="mr-4 font-normal text-sm p-x-4">{{$infoTabActive == 'track-investor' ? 'TrackInvestor' : 'Other Favorites'}} </span>
                    <svg class="w-5 h-5 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="dropdownMenu" class="absolute left-0 py-2 mt-2 bg-white  rounded-md shadow-xl w-44">
                    <a href="javascript;" wire:click.prevent="setInfoActiveTab('track-investor')" class="block px-4 py-2 text-sm text-gray-300 text-gray-700 hover:bg-gray-400 hover:text-white">
                        TrackInvestor
                    </a>
                    <a href="javascript;" wire:click.prevent="setInfoActiveTab('other-favorites')" class="block px-4 py-2 text-sm text-gray-300 text-gray-700 hover:bg-gray-400 hover:text-white">
                        Other Favorites
                    </a>
                </div>
                <div class="search mr-3">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-400">Search</label>
                    <div class="relative p-0 m-0 sm:mt-3 md:mt-3">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" wire:model.lazy="searchValue" wire:keydown="filterData($event.target.value)" id="default-search" class="block focus:outline-none focus:ring-0 focus:border-blue-500 h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 border-b-2 border-t-0 border-l-0 border-r-0 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Search" required>
                    </div>
                </div>
            </div>
            <div class="mb-10 w-full">
                @if(!$loading)
                    <div class="">
                        No data is loding
                    </div>
                @else
                    @if ($infoTabActive == 'track-investor')
                    <div>
                        <livewire:track-investor.fund/>
                    </div>
                    @elseif($infoTabActive == 'other-favorites')
                        <livewire:track-investor.favorites/>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>