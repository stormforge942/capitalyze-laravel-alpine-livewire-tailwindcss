<div class="discover flex-1 mb-10">
    <div class="flex content-between items-center justify-between">
        <div class="title font-semibold">Discover Funds</div>
        <div class="search">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative p-0 m-0">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="default-search" class="block w-full p-4 pl-10 text-sm text-gray-900 border-b-2 border-t-0 border-l-0 border-r-0 border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Discover items..." required>
            </div>
        </div>
    </div>
    @if($loading)
        <div class="flex-1 mt-6 ml-0 mr-0">
            <div class="grid grid-cols-5 gap-y-2">
                @foreach($favorites as $item)
                    <div class="box shadow-md bg-[#ffffff] p-3 m-2 border-r-0.5">
                        <div class="flex content-center justify-between items-center">
                            <div>
                                <h4 class="text-sm font-semibold text-[#3561E7]">{{$item['title']}}</h4>
                            </div>
                            <div class="p-1 bg-[width:3px_3px] shadow-sm bg-[#52D3A2]">
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-y-3">
                            @foreach($item['items'] as $value)
                                <div class="m-0 p-2">
                                    <label class="font-normal text-xs">{{$value['label']}}</label>
                                    <div class="font-semibold text-sm">{{$value['value']}}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>