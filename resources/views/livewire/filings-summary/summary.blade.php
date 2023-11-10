<div class="flex flex-col lg:flex-row justify-start items-center flex-wrap">
    @for($i=0; $i<10; $i++)
        <div class="bg-white p-3 rounded w-full lg:w-[calc(50%-1rem)] mr-0 lg-0 {{$i%2 === 0 ? 'lg:mr-3': 'lg:ml-4'}} mb-5">
            <div class="flex justify-between items-center content-center py-2 mx-[-0.75rem] mb-1 border-b border-grey-light">
                <div>
                    <h4 class="mx-3 text-base text-[#3561E7]">Financials</h4>
                </div>
                <div class="hidden xl:flex justify-start items-center content-center">
                    <div class="mx-2">
                        <input name="sort_by_date" class="text-sm mx-1 mt-[-0.125rem]" type="radio">
                            <label class="text-sm mt-1">Sort by date</label>
                        </input>
                    </div>
                    <div class="mr-2">
                        <input name="sort_by_date" class="text-sm mx-1 mt-[-0.125rem]" type="radio">
                            <label class="text-sm mt-1">Sort by title</label>
                        </input>
                    </div>
                    <div class="flex justify-center items-center content-center">
                        <div class="m-0 p-0"> 
                            <img class="mt-1 mr-0" src="{{url('/svg/search.svg')}}"/>
                        </div>
                        <input type="search" class="focus:ring-0 focus:border-blue-500 placeholder:text-sm text-sm  border-none w-[9rem] leading-[1.45rem] h-[1.45rem]" placeholder="search document"/>
                    </div>
                </div>
                <div class="flex xl:hidden justify-between items-center">
                    <select id="countries" class="h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
                        <option selected>Choose a value</option>
                        <option value="sort_by_date">Sort by date</option>
                        <option value="sort_by_title">Sort by title</option>
                    </select>
                    <div class="ml-3 p-0"> 
                        <img class="mt-1 mr-0" src="{{url('/svg/search.svg')}}"/>
                    </div>
                </div>
                <div class="mx-3">
                    <a hre="#" class="text-sm text-[#F78400]">View All</a>
                </div>
            </div>
            <div class="overflow-hidden -mt-1 overflow-x-auto border h-[20rem] overflow-y-auto border-gray-200 dark:border-gray-700">    
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
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
    @endfor
</div>
