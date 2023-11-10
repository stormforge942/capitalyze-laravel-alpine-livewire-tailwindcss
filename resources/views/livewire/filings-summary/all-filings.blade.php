<div class="flex flex-col">
    <div class="hidden md:flex bg-[#F2F2F2] w-full border-b-2 border-[#E4E4E4] justify-between">
        <div class="mx-3 mt-1 -mb-0.5 text-[#121A0F] text-base innertab-active"><a href="#">All Documents </a></div>
        <div class="mx-3 mt-1 -mb-0.5 text-[#121A0F] text-base"><a href="#">Financials </a></div>
        <div class="mx-3 mt-1 -mb-0.5 text-[#121A0F] text-base"><a href="#">News </a></div>
        <div class="mx-3 mt-1 -mb-0.5 text-[#121A0F] text-base"><a href="#">Registrations and Prospectuses </a></div>
        <div class="mx-3 mt-1 -mb-0.5 text-[#121A0F] text-base"><a href="#">Proxy Materials</a></div>
        <div class="mx-3 mt-1 -mb-0.5 text-[#121A0F] text-base"><a href="#">Ownership</a></div>
        <div class="mx-3 mt-1 -mb-0.5 text-[#121A0F] text-base"><a href="#">Other </a></div>
    </div>
    <div class="md:hidden">
        <select id="countries" class="change-select-chevron text-[#121A0F] font-[500] focus:outline-none focus:ring-0 h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
            <option value="sort_by_date">All Documents</option>
            <option value="sort_by_title">Financials</option>
            <option value="sort_by_title">News</option>
            <!-- <option value="sort_by_title">Registrations and Prospectuses</option> -->
            <option value="sort_by_title">Proxy Materials</option>
            <option value="sort_by_title">Ownership</option>
            <option value="sort_by_title">Other</option>
        </select>
    </div>
    <!-- just for responsive view  -->
    <div class="mr-2 md:hidden absolute top-[52%] right-[2%] bg-white p-2 rounded-full">
        <div class="flex justify-between items-center">
            <div><img src="{{url('/svg/filter-list.svg')}}"/></div>
            <h4 class="text-sm ml-2 text-[#121A0F] font-[400]">Table Optios</h4>
        </div>
    </div>

    <div class="hidden md:flex justify-between items-center mt-4">
        <div class="flex justify-between items-center">
            <div class="mr-2">
                <select id="countries" class="h-7  py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
                    <option selected>Choose a value</option>
                    <option value="sort_by_date">Sort by date</option>
                    <option value="sort_by_title">Sort by title</option>
                </select>
            </div>
            <div class="ml-2">
                <select id="countries" class="h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
                    <option selected>Choose a value</option>
                    <option value="sort_by_date">Sort by date</option>
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
    <div class="flex flex-col mt-6">
        <div class="overflow-hidden overflow-x-auto border h-[32rem] overflow-y-auto border-gray-200 dark:border-gray-700 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-[#E6E6E6] dark:bg-gray-800 sticky top-0">
                    <tr>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">File name</th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">Description</th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">Filing Date</th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">Period of Report</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                    @foreach($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap">{{$item['name']}}</td>
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap">{{$item['desc']}}</td>
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap">{{$item['date_1']}}</td>
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap">{{$item['date_2']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
