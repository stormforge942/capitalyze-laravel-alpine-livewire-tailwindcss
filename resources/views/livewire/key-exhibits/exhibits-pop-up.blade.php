<div x-data="{
        formTypes: @js($formTypes),
        selectedIds: @js($selectChecked),
        items: @js($data),
        search: '',
        dta: [],
        latestValue: @js($selectChecked),
        selectedTab: @js($selectedTab),
        copyItems: this.items,
        sortBy: null,
        sortCol: null,
        sortOrder: false,
        originalItems: null,
        get filteredItems() {
            const filteredData = this.items.filter((item) =>
            {
                const searchValue = this.search;
                if (!searchValue) {
                    return true;
                }
                return item?.toLowerCase().startsWith(searchValue);
            })
            this.filteredData = filteredData;
            return this.filteredData;
        },
        handleFormTypeTabs(form){
            if(!this.originalItems){
                this.originalItems = [...this.items];
            }
            this.selectedTab = form;
            let range = form.split('-');
            let startRange = range[0];
            let endRange = range[1];

            if (this.selectedTab === 'D-9') {
                this.dta = this.originalItems.filter(item => /\d/.test(item));
            } else {
                this.dta = this.originalItems.filter(item => {
                    let wordParts = item.split('-');
                    let firstPart = wordParts[0];
                    let lastPart = wordParts[wordParts.length - 1];
                    let firstChar = firstPart[0];
                    let lastChar = lastPart[lastPart.length - 1];

                    return startRange <= firstChar && lastChar <= endRange;
                });
            }

            // Update this.items based on this.dta
            this.items = this.dta.length > 0 ? this.dta : [...this.originalItems];
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
        get hasValueChanged() {
            return [...this.latestValue].sort().map(item => item).join('-') !== [...this.selectedIds].sort().map(item => item).join('-')
        }
    }"
    @click.away="open = false"
>
    <div class="flex justify-between items-center m-0 md:hidden">
        <h4 class="text-base font-[500] text-[#121A0F]">Browse Exhibit Types</h4>
        <div class="cursor-pointer" @click="openExhibitsPop = false">
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
                <input type="radio" x-model="sortBy" value="filing_date" @change="sort('filing_date')" class="mr-3 focus:ring-0 text-[#121A0F] focus:border-transparent" name="sort" class="" id="sort"/>
                <label for="sort">By Date</label>
            </div>
        </div>
        <div class="flex rounded flex-col md:hidden bg-[#FAFAFA] my-2">
            <div class="flex justify-start items-center p-2">
                <input type="radio" x-model="sortBy" value="form_type" @change="sort('form_type')" class="mr-3 focus:ring-0 text-[#121A0F] focus:border-transparent" name="sort" class="" id="sort"/>
                <label for="sort">By file type</label>
            </div>
        </div>
        <div class="flex flex-col md:hidden bg-[#FAFAFA] my-2">
            <div class="flex justify-between items-center p-2">
                <h4 class="text-[#7C8286] text-sm font-[400]">Select File Type</h4>
                <img src="{{asset('/svg/right-values.svg')}}" alt="Right Values Icon"/>
            </div>
        </div>
        <div class="mt-3 sm:mt-1">
            <div class="overflow-y-auto h-[28rem]">
                <div class="flex flex-col w-[100%] m-0">
                    <div class="search hidden md:flex flex-col">
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-400">Search</label>
                        <div class="relative p-0 m-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" x-model="search" id="default-search" class="flex rounded-sm border-[#E8EBF2] ring-[#E8EBF2] focus:ring-[#E8EBF2] focus:outline-none focus:ring-0 h-0 leading-3 w-full p-4 pl-10 text-sm text-gray-900 bg-white dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:py-6 sm:pl-12 sm:pr-6 sm:text-base sm:rounded-lg" placeholder="Search">
                        </div>
                    </div>
                    <div class="flex justify-start items-center overflow-auto-x my-4">
                        <div class="flex justify-start items-center rounded border border-[#E8EBF2] overflow-visible">
                            <template x-for="form in formTypes" :key="form">
                                <div :class="`${selectedTab === form ? 'border-[#52D3A2] bg-green-100 border-2 -m-px' : 'opacity-50'}`" class="tracking-widest px-6 sm:px-9 cursor-pointer py-[0.15rem] rounded text-sm text-[#01090F] font-[500]" @click.prevent="handleFormTypeTabs(form)" x-text="form"></div>
                            </template>
                        </div>
                    </div>
                    <form>
                        <div class="grid xs:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-y-3 mx-1">
                            <template x-for="item in filteredItems" :key="item">
                                <div class="flex justify-start items-center my-2">
                                    <input type="checkbox" :value="item" x-model="selectedIds" class="focus:ring-0 text-[#121A0F] focus:border-transparent" :id="item"/>
                                    <label class="ml-3 text-[#121A0F] text-base font-[400]" :for="item" x-text="item"></label>
                                </div>
                            </template>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 sm:mt-6 flex">
        <span class="flex w-full rounded-md shadow-sm">
            <button @click.prevent="selectedIds = [];" :disabled="!(hasValueChanged || selectedIds.length > 0)" :class="`${hasValueChanged || selectedIds.length > 0 ? 'bg-[#DCF6EC] text-[#121A0F]' : 'bg-[#D1D3D5] text-[#828C85]'}`"  class="inline-flex text-base font-[500] justify-center w-full px-4 py-2 rounded">
                Reset
            </button>
        </span>

        <span class="flex w-full ml-2 rounded-md shadow-sm">
            <button @click.prevent="$wire.emit('emitCountInKeyExhibits', JSON.stringify(selectedIds)); openExhibitsPop = false;" :disabled="!hasValueChanged" :class="`${hasValueChanged ? 'bg-[#52D3A2] text-[#121A0F]' : 'bg-[#D1D3D5] text-[#828C85]'}`"  class="inline-flex text-base font-[500] justify-center w-full px-4 py-2 rounded">
                Show Result
            </button>
        </span>
    </div>
</div>
