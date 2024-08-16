<div class="mt-6 w-full items-center" x-data="{
    showDropdown: false,
}">
    <x-dropdown x-model="showDropdown" placement="bottom-start" :fullWidthTrigger="true" :teleport="true">
        <x-slot name="trigger">
            <div
                class="h-14 w-full border-[0.5px] border-[#D4DDD7] bg-white leading-[3rem] flex items-center focus-within:border-green-dark p-2">
                <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
                        fill="#828C85" />
                </svg>

                <div class="w-full text-left text-[#7C8286] ml-3 focus:outline-none">
                    Search
                </div>
            </div>
        </x-slot>
        <div class="w-[30rem] sm:w-[30rem]" x-data="{
            loading: @entangle('loading').defer,
            loadingInfinite: false,
            search: @entangle('search'),
            placeholder: 'Search investors',
            tmpCurInvestors: [],
            currentCategory: @entangle('category'),
            categories: {
                all: 'All Investors',
                fund: '13F Filers',
                mutual_fund: 'N-Port Filers',
                favourite: 'My Favourites'
            },
            investors: @entangle('investors').defer,
            canLoadMore: @entangle('canLoadMore').defer,
            init() {
                this.$watch('showDropdown', value => {
                    if (value) {
                        this.tmpCurInvestors = [...curInvestors];
                    }
                });
                this.$watch('search', value => {
                    this.loading = true;
                });
            },
            handleShowResult() {
                this.showDropdown = false;
                curInvestors = [...this.tmpCurInvestors];
            },
            handleClickInvestor(invt) {
                const id = this.generateID(invt);
                if (this.tmpCurInvestors.find(item => item.id === id)) {
                    this.tmpCurInvestors = this.tmpCurInvestors.filter(item => item.id !== id);
                } else {
                    this.tmpCurInvestors.push({
                        ...invt,
                        id: this.generateID(invt),
                        bAdded: true,
                    });
                }
            },
            get tmpCurInvestorIDs() {
                return this.tmpCurInvestors.map(item => item.id);
            },
            generateID(invt) {
                if (invt.type === 'fund') {
                    return `${invt.cik}-${invt.cusip}`;
                } else {
                    return `${invt.cik}-${invt.name}-${invt.fund_symbol}-${invt.series_id}-${invt.class_id}-${invt.class_name}`;
                }
            },
            changeCategory(category) {
                if (this.currentCategory === category) return;
                this.loading = true;
                this.currentCategory = category;
                this.$nextTick(() => this.$refs.investorList.scrollTop = 0);
            },
            loadMore() {
                return @this.loadMore();
            }
        }">
            <div class="flex justify-between gap-2 px-6 pt-6 mb-1">
                <span class="font-medium text-base">Search Investors</span>
                <button type="button" @click="showDropdown = false">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>
            <span class="px-6 text-gry-500 text-[#7C8286]">Add funds and analyze the overlap in their portfolios.</span>

            <div class="bg-white border-[0.5px] border-[#D4DDD7] p-2 flex items-center gap-x-1 mx-6 mt-2">
                <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
                        fill="#828C85" />
                </svg>
                <input type="search" placeholder="Search"
                    class="placeholder:text-gray-medium2 bg-transparent border-none flex-1 focus:outline-none focus:ring-0 h-[30px] search-x-button placeholder:font-medium text-sm w-full"
                    x-model.debounce.500ms="search">
            </div>

            <div class="grid grid-cols-12 gap-4 px-6 mt-4 mb-2">
                <div class="col-span-12 flex flex-row gap-3">
                    <template x-for="(value, key) in categories" :key="key">
                        <div @click="changeCategory(key)"
                            class="border-[0.5px] border-[#D4DDD7] p-2 rounded-full text-sm hover:cursor-pointer"
                            :class="currentCategory == key ? 'bg-green-light' : 'bg-white'">
                            <span x-text="value"></span>
                        </div>
                    </template>
                </div>
            </div>

            <div x-show="loading" class="grid place-items-center">
                <span class="mx-auto simple-loader text-blue"></span>
            </div>
            <div class="pl-8 pr-5 py-2 overflow-y-auto h-[200px]" x-ref="investorList">
                <template x-for="invt in investors" :key="generateID(invt)">
                    <div class="py-4 flex flex-row justify-between items-center hover:bg-gray-200 cursor-pointer"
                        @click="handleClickInvestor(invt)">
                        <div class="flex flex-row items-center">
                            <svg x-show="!(tmpCurInvestorIDs.includes(generateID(invt)))" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10C20 15.5228 15.5228 20 10 20ZM9 9H5V11H9V15H11V11H15V9H11V5H9V9Z"
                                    fill="#121A0F" />
                            </svg>
                            <svg x-show="(tmpCurInvestorIDs.includes(generateID(invt)))" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10C20 15.5228 15.5228 20 10 20ZM9 9H5V11H15V9H5"
                                    fill="#121A0F" />
                            </svg>
                            <span class="capitalize ml-4 font-bold text-black"
                                x-text="(invt.name.toLowerCase() + (invt.fund_symbol ? ` (${invt.fund_symbol})` : ''))"></span>
                        </div>
                        <span class="text-[#7C8286] whitespace-nowrap"
                            x-text="`Owns ${invt.portfolio_size} stocks`"></span>
                    </div>
                </template>

                <div class="grid place-items-center" x-show="loadingInfinite">
                    <span class="mx-auto simple-loader !text-green-dark"></span>
                </div>

                <template x-if="!loading && canLoadMore && currentCategory !== 'favourite'">
                    <div x-data="{
                        observe() {
                            if (loadingInfinite) return;
                    
                            const observer = new IntersectionObserver(entries => {
                                entries.forEach(entry => {
                                    if (entry.isIntersecting) {
                                        loadingInfinite = true;
                                        loadMore().finally(() => {
                                            loadingInfinite = false;
                                        });
                                    }
                                });
                            }, {
                                root: null
                            });
                    
                            observer.observe(this.$el);
                        }
                    }" x-init="observe"></div>
                </template>
            </div>
            <div class="p-6">
                <button type="button" @click="handleShowResult"
                    class="w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded disabled:pointer-events-none disabled:bg-[#D4DDD7] disabled:text-gray-medium2 text-base">
                    Show Result
                </button>
            </div>
        </div>
    </x-dropdown>
</div>
