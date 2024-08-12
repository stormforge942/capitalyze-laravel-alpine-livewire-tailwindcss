<div x-data="{
        formTypes: @js($formTypes),
        selectedIds: @js($selectChecked),
        type: @js($type),
        items: @js($data),
        search: '',
        dta: [],
        latestValue: @js($selectChecked),
        selectedTab: @js($selectedTab),
        copyItems: this.items,
        dateSortOrder: @entangle('sortOrder').defer,
        sortCol: null,
        sortChanged: false,
        originalItems: null,
        init() {
            this.handleFormTypeTabs('0-9');
        },
        get filteredItems() {
            const searchValue = this.search;
            const itemsSource = !searchValue ? this.items : this.originalItems;
            const filteredData = itemsSource.filter((item) =>
            {
                if (!searchValue) {
                    return true;
                }

                return item?.toLowerCase().startsWith(searchValue);
            })

            this.filteredData = filteredData;
            return this.filteredData;
        },
        handleFormTypeTabs(form){
            if (!this.originalItems){
                this.originalItems = [...this.items];
            }

            this.selectedTab = form;

            let range = form.split('-');
            let startRange = range[0];
            let endRange = range[1];

            if (this.selectedTab === '0-9') {
                this.dta = this.originalItems.filter(item => /^\d/.test(item));
            } else {
                this.dta = this.originalItems.filter(item => item[0] >= startRange && item[0] <= endRange);
            }

            this.items = this.dta.sort();
        },
        get hasValueChanged() {
            return this.sortChanged || [...this.latestValue].sort().map(item => item).join('-') !== [...this.selectedIds].sort().map(item => item).join('-')
        },
        showResultAction() {
            this.sortChanged = false;

            if (this.type === 'filing') {
                $wire.emit('hideFilingDropdown');
                $wire.emit('emitCountInAllfilings', JSON.stringify(this.selectedIds), this.dateSortOrder);
            }

            if (this.type === 'exhibit') {
                $wire.emit('hideExhibitDropdown');
                $wire.emit('emitCountInKeyExhibits', JSON.stringify(this.selectedIds), this.dateSortOrder);
                openExhibitsPop = false;
            }
        }
    }"
>
    <div>
        <div class="flex flex-col rounded md:hidden mt-2">
            <div class="flex justify-between items-center p-2">
                <h4 class="text-[#7C8286] font-[400] text-base">Sort by Date</h4>
            </div>
        </div>
        <div class="flex flex-col md:hidden mt-2">
            <div class="flex justify-start items-center p-2">
                <input type="radio" x-model="dateSortOrder" value="desc" class="mr-3 focus:ring-0 text-[#121A0F]" name="sort" class="" id="sort-desc" @click="sortChanged = true" />
                <label for="sort">Newest to Oldest</label>
            </div>
        </div>
        <div class="flex flex-col md:hidden mb-2">
            <div class="flex justify-start items-center p-2">
                <input type="radio" x-model="dateSortOrder" value="asc" class="mr-3 focus:ring-0 text-[#121A0F]" name="sort" class="" id="sort-asc" @click="sortChanged = true" />
                <label for="sort">Oldest to Newest</label>
            </div>
        </div>

        <div class="flex flex-col rounded md:hidden mt-2">
            <div class="flex justify-between items-center p-2">
                <h4 class="text-[#7C8286] font-[400] text-base">Select Filing Type</h4>
            </div>
        </div>

        <div class="mt-3 sm:mt-1">
            <div class="overflow-y-auto h-[28rem] max-h-[200px] md:max-h-none">
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

                    <template x-if="filteredItems.length <= 0">
                        <div class="text-center mt-6 md:mt-20">
                            <div>
                                <svg class="inline-block" width="171" height="110" viewBox="0 0 171 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M165.224 -0.00585938H5.6258C4.13429 -0.00406794 2.70438 0.591306 1.64973 1.64966C0.595072 2.70802 0.00178517 4.14294 0 5.63968V22.8741C0.00178517 24.3709 0.595072 25.8058 1.64973 26.8642C2.70438 27.9225 4.13429 28.5179 5.6258 28.5197H165.224C166.715 28.5179 168.145 27.9225 169.2 26.8642C170.255 25.8058 170.848 24.3709 170.85 22.8741V5.63968C170.848 4.14294 170.255 2.70802 169.2 1.64966C168.145 0.591306 166.715 -0.00406794 165.224 -0.00585938ZM170.257 22.8741C170.255 24.2132 169.724 25.4968 168.781 26.4437C167.837 27.3906 166.558 27.9234 165.224 27.9253H5.6258C4.29142 27.9234 3.01226 27.3906 2.06872 26.4437C1.12517 25.4968 0.594222 24.2132 0.592259 22.8741V5.63968C0.594222 4.30062 1.12517 3.01697 2.06872 2.07011C3.01226 1.12326 4.29142 0.590448 5.6258 0.588478H165.224C166.558 0.590448 167.837 1.12326 168.781 2.07011C169.724 3.01697 170.255 4.30062 170.257 5.63968V22.8741Z" fill="#D4DDD7"/>
                                    <path d="M165.224 69.2303H5.6258C4.13429 69.2285 2.70438 68.6331 1.64973 67.5748C0.595072 66.5164 0.00178517 65.0815 0 63.5847V46.3506C0.00178517 44.8539 0.595072 43.419 1.64973 42.3606C2.70438 41.3022 4.13429 40.7069 5.6258 40.7051H165.224C166.715 40.7069 168.145 41.3022 169.2 42.3606C170.255 43.419 170.848 44.8539 170.85 46.3506V63.5847C170.848 65.0815 170.255 66.5164 169.2 67.5748C168.145 68.6331 166.715 69.2285 165.224 69.2303ZM5.6258 41.2994C4.29128 41.3009 3.01187 41.8336 2.06823 42.7806C1.12458 43.7275 0.593777 45.0114 0.592259 46.3506V63.5847C0.593509 64.9241 1.12419 66.2083 2.06787 67.1555C3.01154 68.1026 4.29111 68.6354 5.6258 68.637H165.224C166.558 68.6355 167.838 68.1029 168.782 67.1559C169.725 66.209 170.256 64.925 170.258 63.5858V46.3506C170.256 45.0114 169.725 43.7275 168.782 42.7806C167.838 41.8336 166.559 41.3009 165.224 41.2994H5.6258Z" fill="#D4DDD7"/>
                                    <path d="M165.224 109.933H5.6258C4.13429 109.932 2.70438 109.336 1.64973 108.278C0.595072 107.22 0.00178517 105.785 0 104.288V87.0537C0.00178517 85.557 0.595072 84.1221 1.64973 83.0637C2.70438 82.0054 4.13429 81.41 5.6258 81.4082H165.224C166.715 81.41 168.145 82.0054 169.2 83.0637C170.255 84.1221 170.848 85.557 170.85 87.0537V104.288C170.848 105.785 170.255 107.22 169.2 108.278C168.145 109.336 166.715 109.932 165.224 109.933ZM5.6258 82.0012C4.29128 82.0027 3.01187 82.5354 2.06823 83.4823C1.12458 84.4293 0.593777 85.7132 0.592259 87.0524V104.287C0.593688 105.626 1.12446 106.91 2.06811 107.857C3.01176 108.804 4.29123 109.337 5.6258 109.338H165.224C166.558 109.337 167.838 108.804 168.782 107.857C169.725 106.91 170.256 105.626 170.258 104.287V87.0537C170.256 85.7143 169.726 84.43 168.782 83.4827C167.838 82.5354 166.559 82.0026 165.224 82.0012H5.6258Z" fill="#D4DDD7"/>
                                    <path d="M27.1903 24.0841C25.2536 24.0841 23.3605 23.5078 21.7502 22.4281C20.14 21.3483 18.8849 19.8137 18.1438 18.0182C17.4027 16.2227 17.2088 14.247 17.5866 12.3409C17.9644 10.4348 18.897 8.6839 20.2664 7.30968C21.6358 5.93546 23.3806 4.9996 25.28 4.62045C27.1794 4.24131 29.1483 4.4359 30.9375 5.17962C32.7267 5.92334 34.256 7.18279 35.3319 8.7987C36.4079 10.4146 36.9822 12.3144 36.9822 14.2579C36.9822 16.8639 35.9505 19.3633 34.1142 21.206C32.2779 23.0488 29.7873 24.0841 27.1903 24.0841Z" fill="#52D3A2"/>
                                    <path d="M150.766 22.2798H46.2439C45.6156 22.2798 45.0131 22.0293 44.5688 21.5835C44.1246 21.1377 43.875 20.533 43.875 19.9026C43.875 19.2721 44.1246 18.6675 44.5688 18.2216C45.0131 17.7758 45.6156 17.5254 46.2439 17.5254H150.766C151.395 17.5254 151.997 17.7758 152.441 18.2216C152.886 18.6675 153.135 19.2721 153.135 19.9026C153.135 20.533 152.886 21.1377 152.441 21.5835C151.997 22.0293 151.395 22.2798 150.766 22.2798Z" fill="#EDEDED"/>
                                    <path d="M116.715 12.1782H46.2439C45.6156 12.1782 45.0131 11.9277 44.5688 11.4819C44.1246 11.0361 43.875 10.4315 43.875 9.80101C43.875 9.17054 44.1246 8.5659 44.5688 8.12009C45.0131 7.67428 45.6156 7.42383 46.2439 7.42383H116.715C117.344 7.42383 117.946 7.67428 118.39 8.12009C118.835 8.5659 119.084 9.17054 119.084 9.80101C119.084 10.4315 118.835 11.0361 118.39 11.4819C117.946 11.9277 117.344 12.1782 116.715 12.1782Z" fill="#EDEDED"/>
                                    <path d="M27.1903 64.795C25.2536 64.795 23.3605 64.2187 21.7502 63.139C20.14 62.0593 18.8849 60.5246 18.1438 58.7291C17.4027 56.9336 17.2088 54.9579 17.5866 53.0518C17.9644 51.1457 18.897 49.3948 20.2664 48.0206C21.6358 46.6464 23.3806 45.7105 25.28 45.3314C27.1794 44.9522 29.1483 45.1468 30.9375 45.8906C32.7267 46.6343 34.256 47.8937 35.3319 49.5096C36.4079 51.1256 36.9822 53.0254 36.9822 54.9688C36.9822 57.5749 35.9505 60.0742 34.1142 61.917C32.2779 63.7597 29.7873 64.795 27.1903 64.795Z" fill="#EDEDED"/>
                                    <path d="M150.766 62.9907H46.2439C45.6156 62.9907 45.0131 62.7402 44.5688 62.2944C44.1246 61.8486 43.875 61.244 43.875 60.6135C43.875 59.983 44.1246 59.3784 44.5688 58.9326C45.0131 58.4868 45.6156 58.2363 46.2439 58.2363H150.766C151.395 58.2363 151.997 58.4868 152.441 58.9326C152.886 59.3784 153.135 59.983 153.135 60.6135C153.135 61.244 152.886 61.8486 152.441 62.2944C151.997 62.7402 151.395 62.9907 150.766 62.9907Z" fill="#EDEDED"/>
                                    <path d="M116.715 52.8813H46.2439C45.6156 52.8813 45.0131 52.6309 44.5688 52.1851C44.1246 51.7393 43.875 51.1346 43.875 50.5041C43.875 49.8737 44.1246 49.269 44.5688 48.8232C45.0131 48.3774 45.6156 48.127 46.2439 48.127H116.715C117.344 48.127 117.946 48.3774 118.39 48.8232C118.835 49.269 119.084 49.8737 119.084 50.5041C119.084 51.1346 118.835 51.7393 118.39 52.1851C117.946 52.6309 117.344 52.8813 116.715 52.8813Z" fill="#EDEDED"/>
                                    <path d="M27.1903 105.498C25.2536 105.498 23.3605 104.922 21.7502 103.842C20.14 102.762 18.8849 101.228 18.1438 99.4323C17.4027 97.6367 17.2088 95.661 17.5866 93.7549C17.9644 91.8488 18.897 90.098 20.2664 88.7237C21.6358 87.3495 23.3806 86.4137 25.28 86.0345C27.1794 85.6554 29.1483 85.85 30.9375 86.5937C32.7267 87.3374 34.256 88.5969 35.3319 90.2128C36.4079 91.8287 36.9822 93.7285 36.9822 95.6719C36.9822 98.278 35.9505 100.777 34.1142 102.62C32.2779 104.463 29.7873 105.498 27.1903 105.498Z" fill="#EDEDED"/>
                                    <path d="M150.766 103.694H46.2439C45.6156 103.694 45.0131 103.443 44.5688 102.998C44.1246 102.552 43.875 101.947 43.875 101.317C43.875 100.686 44.1246 100.082 44.5688 99.6357C45.0131 99.1899 45.6156 98.9395 46.2439 98.9395H150.766C151.395 98.9395 151.997 99.1899 152.441 99.6357C152.886 100.082 153.135 100.686 153.135 101.317C153.135 101.947 152.886 102.552 152.441 102.998C151.997 103.443 151.395 103.694 150.766 103.694Z" fill="#EDEDED"/>
                                    <path d="M116.715 93.5923H46.2439C45.6156 93.5923 45.0131 93.3418 44.5688 92.896C44.1246 92.4502 43.875 91.8455 43.875 91.2151C43.875 90.5846 44.1246 89.98 44.5688 89.5341C45.0131 89.0883 45.6156 88.8379 46.2439 88.8379H116.715C117.344 88.8379 117.946 89.0883 118.39 89.5341C118.835 89.98 119.084 90.5846 119.084 91.2151C119.084 91.8455 118.835 92.4502 118.39 92.896C117.946 93.3418 117.344 93.5923 116.715 93.5923Z" fill="#EDEDED"/>
                                    <path d="M26.6898 17.7128C26.4466 17.7133 26.2099 17.6344 26.0153 17.488L26.0031 17.4789L23.4651 15.5307C23.3476 15.4403 23.2489 15.3275 23.1748 15.1988C23.1007 15.0701 23.0526 14.928 23.0332 14.7807C23.0138 14.6333 23.0235 14.4836 23.0617 14.34C23.1 14.1964 23.1661 14.0618 23.2562 13.9438C23.3463 13.8259 23.4587 13.7269 23.5869 13.6525C23.7152 13.5781 23.8567 13.5298 24.0036 13.5103C24.1504 13.4909 24.2996 13.5006 24.4427 13.539C24.5858 13.5774 24.72 13.6437 24.8375 13.7341L26.4814 14.9993L30.3658 9.91358C30.5478 9.67554 30.8165 9.51974 31.1129 9.48045C31.4092 9.44116 31.709 9.5216 31.9463 9.70408L31.9224 9.73792L31.947 9.70408C32.184 9.88693 32.339 10.1566 32.378 10.454C32.4171 10.7514 32.3371 11.0522 32.1554 11.2904L27.5863 17.2697C27.4805 17.4072 27.3445 17.5184 27.1889 17.5947C27.0333 17.671 26.8623 17.7104 26.6892 17.7097L26.6898 17.7128Z" fill="white"/>
                                </svg>
                            </div>

                            <div class="font-medium text-base mt-5">
                                <p x-show="type === 'filing'">No filing type here</p>
                                <p x-show="type === 'exhibit'">No exhibit type here</p>
                            </div>
                        </div>
                    </template>

                    <form>
                        <div class="grid xs:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-y-3 mx-1">
                            <template x-for="item in filteredItems" :key="item">
                                <div class="flex justify-start items-center my-2">
                                    <input type="checkbox" :value="item" x-model="selectedIds" class="focus:ring-0 text-[#121A0F] custom-checkbox" :id="item"/>
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
            <button @click.prevent="selectedIds = [];" :disabled="!(hasValueChanged || selectedIds.length > 0)" :class="`${hasValueChanged || selectedIds.length > 0 ? 'bg-[#DCF6EC] text-[#121A0F]' : 'bg-[#D1D3D5] text-[#828C85]'}`"  class="inline-flex text-base font-[500] justify-center w-full px-4 py-2  rounded">
                Reset
            </button>
        </span>

        <span class="flex w-full ml-2 rounded-md shadow-sm">
            <button @click.prevent="showResultAction()" :disabled="!hasValueChanged" :class="`${hasValueChanged ? 'bg-[#52D3A2] text-[#121A0F]' : 'bg-[#D1D3D5] text-[#828C85]'}`" class="inline-flex text-base font-[500] justify-center w-full px-4 py-2 rounded">
                Show Result
            </button>
        </span>
    </div>
</div>
