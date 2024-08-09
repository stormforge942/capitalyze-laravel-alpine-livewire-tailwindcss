<div class="mt-6 w-full items-center" x-data="{
    showDropdown: false,
    search: $wire.entangle('search'),
    loading: @entangle('loading').defer,
    loadingInfinite: false,
    tmpCurInvestors: [],
    currentCategory: @entangle('category'),
    canLoadMore: @entangle('canLoadMore').defer,
    investors: @entangle('investors').defer,
    categories: {
        all: 'All Investors',
        fund: '13F Filers',
        mutual_fund: 'N-Port Filers',
        favourite: 'My Favourites'
    },
    init() {
        this.$watch('showDropdown', value => {
            if (value) {
                this.tmpCurInvestors = [...curInvestors];
            } else {
                curInvestors = [...this.tmpCurInvestors];
            }
        });
    },
    handleClickInvestor(invt) {
        const id = this.generateID(invt);
        const index = this.tmpCurInvestors.findIndex(item => item.id === id);
        if (index >= 0) {
            this.tmpCurInvestors.splice(index, 1);
        } else {
            this.tmpCurInvestors.push({ ...invt, id, bAdded: true });
        }
    },
    get tmpCurInvestorIDs() {
        return this.tmpCurInvestors.map(item => item.id);
    },
    generateID(invt) {
        return invt.type === 'fund' ?
            `${invt.cik}-${invt.cusip}` :
            `${invt.cik}-${invt.name}-${invt.fund_symbol}-${invt.series_id}-${invt.class_id}-${invt.class_name}`;
    },
    changeCategory(category) {
        if (this.currentCategory !== category) {
            this.loading = true;
            this.currentCategory = category;
            this.$nextTick(() => this.$refs.investorList.scrollTop = 0);
        }
    },
    loadMore() {
        return @this.loadMore();
    }
}">
    <x-dropdown x-model="showDropdown" placement="bottom-start" :fullWidthTrigger="true" :teleport="true">
        <x-slot name="trigger">
            <div class="bg-white border-[0.5px] border-[#D4DDD7] p-2 flex items-center gap-x-1 w-full">
                <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
                        fill="#828C85" />
                </svg>
                <input type="search" placeholder="Search"
                    class="placeholder:text-gray-medium2 bg-transparent border-none flex-1 focus:outline-none focus:ring-0 h-[30px] search-x-button placeholder:font-medium text-sm w-full"
                    x-model.debounce.500ms="search">
            </div>
        </x-slot>
        <div class="w-[30rem] sm:w-[30rem]">
            <div class="flex justify-between gap-2 px-6 pt-6 mb-3">
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
                            <span class="ml-4 font-bold text-black"
                                x-text="invt.name + (invt.fund_symbol ? ` (${invt.fund_symbol})` : '')"></span>
                        </div>
                        <span class="text-[#7C8286] whitespace-nowrap"
                            x-text="`Owns ${invt.stock_count} stocks`"></span>
                    </div>
                </template>

                <div class="grid place-items-center" x-show="loadingInfinite">
                    <span class="mx-auto simple-loader !text-green-dark"></span>
                </div>

                <template x-if="canLoadMore && currentCategory !== 'favourite'">
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
        </div>
    </x-dropdown>
</div>
