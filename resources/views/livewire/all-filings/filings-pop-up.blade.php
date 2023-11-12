<div class="w-full p-2 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-4 lg:p-8 md:mx-0" @click.away="open = false">
    <div class="flex justify-between items-center m-0">
        <h4 class="text-base font-[500] text-[#121A0F]">Browse Filing Types</h4>
        <div class="cursor-pointer" @click="open = false">   
            <img src="{{url('/svg/close.svg')}}" alt="close icon"/>
        </div>
    </div> 
    <div>
        <div class="flex flex-col rounded md:hidden mt-2">
            <div class="flex justify-between items-center p-2">
                <h4 class="text-[#7C8286] font-[400] text-base">Sort</h4>
                <img src="{{url('/svg/right-values.svg')}}" alt="Right Values Icon"/>
            </div>
        </div>
        <div class="flex flex-col md:hidden my-2">
            <div class="flex justify-start items-center p-2">
                <input type="radio" class="mr-3 focus:ring-0 text-[#121A0F] focus:border-transparent" name="sort" class="" id="sort"/>
                <label for="sort">By Date</label>
            </div>
        </div>
        <div class="flex rounded flex-col md:hidden bg-[#FAFAFA] my-2">
            <div class="flex justify-start items-center p-2">
                <input type="radio" class="mr-3 focus:ring-0 text-[#121A0F] focus:border-transparent" name="sort" class="" id="sort"/>
                <label for="sort">By file type</label>
            </div>
        </div> 
        <div class="flex flex-col md:hidden bg-[#FAFAFA] my-2">
            <div class="flex justify-between items-center p-2">
                <h4 class="text-[#7C8286] text-sm font-[400]">Select File Type</h4>
                <img src="{{url('/svg/right-values.svg')}}" alt="Right Values Icon"/>
            </div>
        </div>   
        <div class="mt-3">
            <div class="overflow-y-auto h-[30rem]">
                <div class="flex flex-col w-[100%] m-0">
                    <div class="search">
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-400">Search</label>
                        <div class="relative p-0 m-0 sm:mt-3 md:mt-3">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" class="flex focus:outline-none focus:ring-0  h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 border-b-0 border-t-0 border-l-0 border-r-0 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Search">
                        </div>
                    </div>
                    <div class="flex justify-start items-center bg-[#E8EBF2] my-4 rounded">
                        <div class="mr-3 bg-[#52D3A2] px-[1rem] py-[0.25rem] rounded text-sm text-[#01090F] font-[500]"><a hre="#">D-9</a></div>
                        <div class="mr-3  px-[1rem] py-[0.25rem] rounded text-sm text-[#7C8286] font-[500]"><a hre="#">A-G</a></div>
                        <div class="mr-3  px-[1rem] py-[0.25rem] rounded text-sm text-[#7C8286] font-[500]"><a hre="#">H-N</a></div>
                        <div class="mr-3  px-[1rem] py-[0.25rem] rounded text-sm text-[#7C8286] font-[500]"><a hre="#">O-Q</a></div>
                        <div class="mr-3  px-[1rem] py-[0.25rem] rounded text-sm text-[#7C8286] font-[500]"><a hre="#">Q-W</a></div>
                        <div class="mr-3  px-[1rem] py-[0.25rem] rounded text-sm text-[#7C8286] font-[500]"><a hre="#">X-Z</a></div>
                    </div>
                    <div class="grid xs:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-y-3">
                        @for($i=0; $i<100; $i++)
                            <div class="flex justify-start items-center">
                                <input type="checkbox" class="focus:ring-0 text-[#121A0F] focus:border-transparent" id="{{$i}}"/> 
                                <label class="ml-3 text-[#121A0F] text-base font-[400]" for="{{$i}}">486APOS</label>
                            </div>
                        @endfor
                    <div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 sm:mt-6">
        <span class="flex w-full rounded-md shadow-sm">
            <button class="inline-flex text-base bg-[#D1D3D5] text-[#fff] font-[500] justify-center w-full px-4 py-2  rounded ">
                Show Result
            </button>
        </span>
    </div>
</div>

