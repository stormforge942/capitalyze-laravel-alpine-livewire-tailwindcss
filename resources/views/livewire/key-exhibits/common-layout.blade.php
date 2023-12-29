<div class="flex flex-col" x-data="{
    open: false,
    search:'', 
    items: @js($data),
    filteredData: [],
    sortCol:null,
    filtered: [],
    sortOrder:false,
    get filteredItems() {
        const filteredData = this.items.filter((item) => 
        {
            const searchValue = this.search;
            if (!searchValue) {
                return true; 
            }
            const matchesFormType = item.form_type?.toLowerCase().startsWith(searchValue);
            const matchesRegistrantName = item.registrant_name?.toLowerCase().startsWith(searchValue);
            return matchesFormType || matchesRegistrantName;
        })
        this.filteredData = filteredData; 
        return this.filteredData;
    },
    sort(col) {
      if(this.sortCol === col) this.sortOrder = !this.sortOrder;
      this.sortCol = col;
      this.items.sort((a, b) => {
        if(a[this.sortCol] < b[this.sortCol]) return this.sortOrder?1:-1;
        if(a[this.sortCol] > b[this.sortCol]) return this.sortOrder?-1:1;
        return 0;
      });
    },
}">
    <div class="place-items-center fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-transparent" wire:loading.grid>
        <span class="mx-auto simple-loader !text-blue"></span>
    </div>
    <div class="hidden md:flex justify-between items-center mt-4 flex-wrap">
        <div class="flex justify-start items-center">
            <div class="flex ml-2 relative justify-center mt-0 mx-0 mb-3">
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
                <input type="search" x-model="search"  id="default-search" class="flex focus:outline-none focus:ring-0 focus:border-blue-500 h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 border-b-2 border-t-0 border-l-0 border-r-0 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Search">
            </div>
        </div>
    </div>
    <div class="flex flex-col mt-6">
        <div class="overflow-hidden overflow-x-auto border h-[32rem] overflow-y-auto border-gray-200 dark:border-gray-700 md:rounded-lg">
            <table  class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-[#E6E6E6] dark:bg-gray-800 sticky top-0">
                    <tr>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center cursor-pointer" @click.prevent="sort('form_type')">
                                File name
                                <div class="ml-2">
                                    <svg  fill="none" :class="sortCol === 'form_type' && !sortOrder ? 'text-blue-500' :'text-gray-500'" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current"><path d="M5 15l7-7 7 7"></path></svg>
                                    <svg  fill="none" :class="sortCol === 'form_type' && sortOrder  ? 'text-blue-500' :'text-gray-500'" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current "><path d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center cursor-pointer" @click.prevent="sort('description')">
                                Description
                                <div class="ml-2">
                                    <svg  fill="none" :class="sortCol === 'description' && !sortOrder ? 'text-blue-500' :'text-gray-500'" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current"><path d="M5 15l7-7 7 7"></path></svg>
                                    <svg  fill="none" :class="sortCol === 'description' && sortOrder  ? 'text-blue-500' :'text-gray-500'" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current "><path d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center cursor-pointer" @click.prevent="sort('filing_date')">
                                Filing Date
                                <div class="ml-2">
                                    <svg  fill="none" :class="sortCol === 'filing_date' && !sortOrder ? 'text-blue-500' :'text-gray-500'" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current"><path d="M5 15l7-7 7 7"></path></svg>
                                    <svg  fill="none" :class="sortCol === 'filing_date' && sortOrder  ? 'text-blue-500' :'text-gray-500'" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current "><path d="M19 9l-7 7-7-7"></path></svg>            
                                </div>
                            </div>
                        </th>
                        <th class="py-2.5 px-4 text-left text-base normal-case text-[#121A0F] font-[600] whitespace-nowrap">
                            <div class="flex items-center cursor-pointer" @click.prevent="sort('filing_date')">
                                Period of Report
                                <div class="ml-2">
                                    <svg  fill="none" :class="sortCol === 'filing_date' && !sortOrder ? 'text-blue-500' :'text-gray-500'" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current"><path d="M5 15l7-7 7 7"></path></svg>
                                    <svg  fill="none" :class="sortCol === 'filing_date' && sortOrder  ? 'text-blue-500' :'text-gray-500'" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer fill-current "><path d="M19 9l-7 7-7-7"></path></svg>            
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">   
                    <template x-for="(val, key) in filteredItems" :key="key">
                        <tr  class="hover:bg-gray-50 cursor-pointer" @click.prevent="$wire.emit('passDataInViewPopModel',[JSON.stringify(val), JSON.stringify(filtered)]); open=true;">
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap" x-text="val.form_type"></td>
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap"><p class="truncate w-96" x-text="val.description"></p></td>
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap" x-text="val.filing_date"></td>
                            <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap" x-text="val.filing_date"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    <div x-show="open" class="fixed  inset-0 z-50 flex items-center justify-center w-96" style="background-color: rgba(0,0,0,.5); width: 100%" >
        <livewire:filings-summary.view-pop-up-model :company="$company"/>
    </div>
</div>

