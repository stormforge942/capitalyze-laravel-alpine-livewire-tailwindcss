<div class="flex flex-col" x-data="{open: false}">
    <div class="flex flex-col mt-6">
        <div class="overflow-hidden overflow-x-auto border h-[32rem] overflow-y-auto border-gray-200 dark:border-gray-700 md:rounded-lg">
            <table  class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-[#E6E6E6] dark:bg-gray-800 sticky top-0">
                    <tr>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center cursor-pointer" wire:click.prevent="handleSorting('form_type')">
                                File name
                                <div class="ml-2">
                                    <svg  fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current {{$col === 'form_type' && $order === 'asc' ? 'text-blue-500' :'text-gray-500' }}"><path d="M5 15l7-7 7 7"></path></svg>
                                    <svg  fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current {{$col === 'form_type' && $order === 'desc' ? 'text-blue-500' :'text-gray-500' }}"><path d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center cursor-pointer" wire:click.prevent="handleSorting('description')">
                                Description
                                <div class="ml-2">
                                    <svg  fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current {{$col === 'description' && $order === 'asc' ? 'text-blue-500' :'text-gray-500' }}"><path d="M5 15l7-7 7 7"></path></svg>
                                    <svg  fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current {{$col === 'description' && $order === 'desc' ? 'text-blue-500' :'text-gray-500' }}"><path d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center cursor-pointer" wire:click.prevent="handleSorting('filing_date')">
                                Filing Date
                                <div class="ml-2">
                                    <svg  fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current {{$col === 'filing_date' && $order === 'asc' ? 'text-blue-500' :'text-gray-500' }}"><path d="M5 15l7-7 7 7"></path></svg>
                                    <svg  fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current {{$col === 'filing_date' && $order === 'desc' ? 'text-blue-500' :'text-gray-500' }}"><path d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center cursor-pointer" wire:click.prevent="handleSorting('filing_date')">
                                Period of Report
                                <div class="ml-2">
                                    <svg  fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current {{$col === 'filing_date' && $order === 'asc' ? 'text-blue-500' :'text-gray-500' }}"><path d="M5 15l7-7 7 7"></path></svg>
                                    <svg  fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current {{$col === 'filing_date' && $order === 'desc' ? 'text-blue-500' :'text-gray-500' }}"><path d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">   
                    @foreach($data as $item)
                        <tr class="hover:bg-gray-50 cursor-pointer" wire:click.prevent="$emit('passDataInViewPopModel',['{{ json_encode($item) }}', '{{json_encode($filtered)}}'])" @click="open = true">
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap">{{$item->form_type ?? $item['form_type'] }}</td>
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap"><p class="truncate w-96">{{$item->description ?? $item['description']}}</p></td>
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap">{{$item->filing_date ?? $item['filing_date']}}</td>
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap">{{$item->filing_date ?? $item['filing_date']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div x-show="open" class="fixed  inset-0 z-50 flex items-center justify-center w-96" style="background-color: rgba(0,0,0,.5); width: 100%" >
        <livewire:filings-summary.view-pop-up-model :company="$company"/>
    </div>
</div>

