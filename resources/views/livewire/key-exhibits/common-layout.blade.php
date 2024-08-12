<div class="flex flex-col" x-data="{
    openExhibitsPop: false,
    search: @js($search),
    items: @js($data),
    filtered: @js($filtered),
    dateSortOrder: @entangle('dateSortOrder').defer,
    init() {
        this.$watch('search', (newVal, oldVal) => {
            @this.emit('onSearch', newVal);
        })

        this.$watch('dateSortOrder', (newVal, oldVal) => {
            @this.emit('onDateSort', newVal);

            Livewire.emit('setSortOrder', newVal);
        })
    }
}">
    <div class="flex flex-col">
        <div class="mr-2 md:hidden absolute top-[52%] right-[2%] bg-white p-2 rounded-full border-2 border-[#2C71F0] {{$checkedCount ? 'bg-[#EAF1FE]' : ''}} z-10">
            <div @click="openExhibitsPop = true" class="flex justify-between items-center">
                <div>
                    <img src="{{asset('/svg/filter-list.svg')}}"/>
                </div>

                <div class="flex justify-between items-center">
                    <h4 class="text-sm ml-2 text-[#121A0F] font-[400]">Table Options</h4>

                    {{ $checkedCount }}
                    @if($checkedCount)
                        <span class="bg-[#2C71F0] px-3 ml-2 py-0 rounded-full text-[0.625rem] font-[600] text-white">{{$checkedCount}}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-2 mt-4 hidden md:grid">
            <div class="col-span-7 sm:col-span-2">
                <x-search-filter x-model.debounce.800ms="search" py="3"></x-search-filter>
            </div>

            <div class="col-span-5 sm:col-span-5 px-4 py-3 bg-white flex flex-wrap items-center border border-[#D4DDD7] rounded-lg">
                <div class="flex ml-2 relative justify-center mx-0 my-auto" x-data="{ dropdownMenu: false }"
                     @keydown.window.escape="dropdownMenu = false"
                     @click.away="dropdownMenu = false"
                >
                    <x-select :options="['desc' => 'Newest to Oldest', 'asc' => 'Oldest to Newest']" placeholder="Sort by Date" x-model="dateSortOrder" ></x-select>
                </div>

                <div class="flex ml-2 relative justify-center mt-0 mx-0" x-data="{openExhibitsPop: false}" @keydown.window.escape="openExhibitsPop = false" @click.away="openExhibitsPop = false">
                    <button @click="openExhibitsPop = ! openExhibitsPop" class="border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1 bg-white hover:bg-[#E2E2E2] {{ $checkedCount ? 'bg-[#E2E2E2] border-2 border-[#9DA3A8]' : '' }} ">
                        <span class="text-sm p-x-4 font-[400] text-[#01090F]"> Select Exhibit Type</span>

                        @if($checkedCount)
                            <span class="bg-[#2C71F0] px-2 py-0 ml-2 leading-5 rounded-full text-[0.625rem] font-[600] text-white">{{$checkedCount}}</span>
                        @endif

                        <span :class="openExhibitsPop ? 'rotate-180' : ''" class="transition-transform shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z" fill="#121A0F"></path>
                            </svg>
                        </span>
                    </button>
                    <div x-show="openExhibitsPop" class="absolute left-0 py-2 mt-10 bg-white rounded-md shadow-xl z-50 sm:left-1/2 transform -translate-x-1/2 left-1/2 2xl:translate-x-0 2xl:left-0">
                        <x-slot name="trigger">
                            <div class="border-[0.5px] border-[#D4DDD7] p-2 rounded-full flex items-center gap-x-1"
                                 :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'">
                                <span class="text-sm truncate" x-text="valueText"></span>

                                <span :class="openExhibitsPop ? 'rotate-180' : ''" class="transition-transform shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                        fill="#121A0F" />
                                </svg>
                            </span>
                            </div>
                        </x-slot>

                        <div class="w-[800px]">
                            <div class="flex justify-between gap-2 px-6 pt-6">
                                <span class="font-medium text-base">Browse Filing Types</span>

                                <button @click="openExhibitsPop = false">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                            fill="#C22929" />
                                    </svg>
                                </button>
                            </div>

                            <div class="py-4 px-6">
                                <livewire:filings-filter-pop-up :type="'exhibit'" :selectChecked="$selectChecked" :sortOrder="$dateSortOrder" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col mt-6 table-clickable" @click.prevent="($event.target.closest('tr')?.querySelector('.row-data')) && Livewire.emit('modal.open', 'company-link-s3-content', { row: JSON.parse($event.target.closest('tr').querySelector('.row-data').getAttribute('data-row')) })">
            <livewire:key-exhibits.exhibits-table :company="$company" :selectedTab="$selectedTab" :filtered="$filtered" />
        </div>
    </div>

    <div class="fixed z-50 top-0 left-0 flex items-center justify-center w-full h-full md:hidden" style="background-color: rgba(0,0,0,.5);" x-show="openExhibitsPop">
        <div class="px-6 py-6 mx-2 text-left bg-white rounded shadow-xl max-w-[90vw]">
            <livewire:filings-filter-pop-up :type="'exhibit'" :selectChecked="$selectChecked" :sortOrder="$dateSortOrder" />
        </div>
    </div>
</div>
