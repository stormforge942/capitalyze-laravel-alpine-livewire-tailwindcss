<div class="bg-gray-100" style="margin-top: -40px;">
    <div class="">
        <div class="px-4 sm:px-6 lg:px-8 py-4 mt-7">
            <div wire:loading.flex class="justify-center items-center min-w-full min-h-100vh company-profile-loading">
                <div class="grid place-content-center h-full" role="status">
                    <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="flex sm:items-start flex-col company-profile-page m-2" wire:loading.remove>
                <div>
                    <div class="page-titles flex justify-start content-start mb-0 mt-2 mx-2">
                        <div> <h4 class="text-[12px] font-[500] pr-1 mt-2">TrackInvestors</h4></div>
                        <div class="pr-1 mt-1 mb-1"> <span class="text-[12px] font-[500">/</span> </div>
                        <div> <h5 class="text-[12px] font-[500] pr-1 mt-2">Discover</h5></div>
                        <div class="pr-0 mt-1"><img class="pr-1 mt-3" src="{{url('/svg/chevron.svg')}}" alt=""/> </div>
                    </div> 
                </div>   
                <div class="hidden md:flex tabs-wrapper w-full">
                    <div @class(['tab text-[14px] font-[500]', 'active font-[600]' => $infoTabActive == 'track-investor']) wire:click="setInfoActiveTab('track-investor')">TrackInvestor</div>
                    <div @class(['tab text-[14px] font-[500]', 'active font-[600]' => $infoTabActive == 'other-favorites']) wire:click="setInfoActiveTab('other-favorites')">Other Favorites</div>
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
                            <input type="search" id="default-search" wire:change="filterData($event.target.value)" class="block focus:outline-none focus:ring-0 focus:border-blue-500 h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 border-b-2 border-t-0 border-l-0 border-r-0 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Search" required>
                        </div>
                    </div>
                </div>
                <div class="flex md:hidden justify-between relative w-full mt-5 mx-3" x-data="{dropdownMenu: false}" @keydown.window.escape="dropdownMenu = false" @click.away="dropdownMenu = false">
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
                    <div class="search mr-5">
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-400">Search</label>
                        <div class="relative p-0 m-0 sm:mt-3 md:mt-3">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" wire:change="filterData($event.target.value)" id="default-search" class="block focus:outline-none focus:ring-0 focus:border-blue-500 h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 border-b-2 border-t-0 border-l-0 border-r-0 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Search" required>
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
</div>