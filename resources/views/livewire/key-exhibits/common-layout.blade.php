<div class="flex flex-col"> 
    <div class="flex flex-col mt-6">
        <div class="overflow-hidden overflow-x-auto border h-[32rem] overflow-y-auto border-gray-200 dark:border-gray-700 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-[#E6E6E6] dark:bg-gray-800 sticky top-0">
                    <tr>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center">
                                File name
                                <a href="#">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49"/>
                                    </svg>
                                </a>
                            </div>
                        </th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center">
                                Description
                                <a href="#">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49"/>
                                    </svg>
                                </a>
                            </div>
                        </th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center">
                                Filing Date
                                <a href="#">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49"/>
                                    </svg>
                                </a>
                            </div>
                        </th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center">
                                Period of Report
                                <a href="#">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49"/>
                                    </svg>
                                </a>
                            </div>
                        </th>
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
