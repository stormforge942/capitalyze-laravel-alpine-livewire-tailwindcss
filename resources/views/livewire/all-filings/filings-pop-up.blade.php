<div class="w-full p-2 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-4 lg:p-8 md:mx-0" @click.away="open = false">
    <div class="place-items-center fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-transparent" wire:loading.grid>
        <span class="mx-auto simple-loader !text-blue"></span>
    </div>    
    <div class="flex justify-between items-center m-0">
        <h4 class="text-base font-[500] text-[#121A0F]">Browse Filing Types</h4>
        <div class="cursor-pointer" @click="open = false">   
            <img src="{{asset('/svg/close.svg')}}" alt="close icon"/>
        </div>
    </div> 
    <div>
        <div class="flex flex-col rounded md:hidden mt-2">
            <div class="flex justify-between items-center p-2">
                <h4 class="text-[#7C8286] font-[400] text-base">Sort</h4>
                <img src="{{asset('/svg/right-values.svg')}}" alt="Right Values Icon"/>
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
                <img src="{{asset('/svg/right-values.svg')}}" alt="Right Values Icon"/>
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
                            <input type="search" id="default-search" class="flex rounded-sm border-[#E8EBF2] ring-[#E8EBF2] focus:ring-[#E8EBF2] focus:outline-none focus:ring-0  h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 bg-white dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Search">
                        </div>
                    </div>
                    <div class="flex justify-start items-center overflow-auto-x bg-[#E8EBF2] my-4 rounded">
                        <div class="flex justify-start items-center w-full overflow-x-auto">
                            @foreach($formTypes as $form)
                                <div class="mr-3 cursor-pointer {{$selectedTab === $form ? 'border-[#52D3A2] bg-green-100 px-[1.5rem] border-2' : 'px-[1rem]'}}  py-[0.15rem] rounded text-sm text-[#01090F] font-[500]" wire:click.prevent="handleFormTypeTabs('{{$form}}')">{{ $form }}</div>
                            @endforeach
                        </div>
                    </div>
                    <form>
                        <div class="grid xs:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-y-3 mx-1">
                            @foreach($data as $item)
                                <div class="flex justify-start items-center">
                                    <input type="checkbox" value="{{$item}}" wire:model="selectedIds" class="focus:ring-0 text-[#121A0F] focus:border-transparent" id="{{$item}}"/> 
                                    <label class="ml-3 text-[#121A0F] text-base font-[400]" for="{{$item}}">{{$item}}</label>
                                </div>
                            @endforeach
                        <div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 sm:mt-6">
        <span class="flex w-full rounded-md shadow-sm">
            <button wire:click.prevent="handleCheckBox" @click="open=false" class="inline-flex text-base {{count($selectedIds) > 0 ? 'bg-[#52D3A2] text-[#121A0F]' : 'bg-[#D1D3D5] text-[#fff]' }} font-[500] justify-center w-full px-4 py-2  rounded ">
                Show Result
            </button>
        </span>
    </div>
</div>

