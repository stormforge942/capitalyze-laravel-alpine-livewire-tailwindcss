<div class="mt-6 w-full items-center relative" x-data="{
    showDropdown: false,
    search: @entangle('search'),
    view: @entangle('view'),
    loading: @entangle('loading').defer,
    loadingInfinite: false,
    showingTmpCurInvestors: false,
    tmpCurInvestors: [],
    currentCategory: @entangle('category'),
    categories: {
        all: 'All Investors',
        fund: '13F Filers',
        mutual_fund: 'N-Port Filers',
        favourite: 'My Favorites'
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
            this.$nextTick(() => this.$refs.investorList.scrollTop = 0);
        });
        this.$watch('view', value => {
            this.loading = true;
            loading = true;
            this.$nextTick(() => {
                if (this.$refs.investorList) this.$refs.investorList.scrollTop = 0
            });
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
    countInTmpCurInvestors(category) {
        if (category === 'all') return this.tmpCurInvestors.length;
        if (category === 'fund' || category === 'mutual_fund') return this.tmpCurInvestors.filter(item => item.type === category).length;
        return this.tmpCurInvestors.filter(item => item.isFavorite === true).length;
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
    },
}" @click.away="showDropdown = false;">
    <div class="w-full grid gap-2 grid-cols-12 h-14">
        <div class="col-span-12 xl:col-span-6 border-[0.5px] border-[#D4DDD7] bg-white leading-[3rem] flex items-center focus-within:border-green-dark p-2 rounded-lg">
            <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
                    fill="#828C85" />
            </svg>

            <input type="search" placeholder="Search"
                class="placeholder:text-gray-medium2 bg-transparent border-none flex-1 focus:outline-none focus:ring-0 h-[30px] search-x-button placeholder:font-medium text-sm w-full"
                x-model.debounce.500ms="search"
                @focus="showDropdown = true;" @input="showDropdown = true;">
        </div>
        <div class="col-span-12 xl:col-span-6">
            <x-filter-box>
                @if (isset($views))
                    <x-select placeholder="View" :options="$views" x-model="view"></x-select>
                @endif
            </x-filter-box>
        </div>
    </div>
    <div class="z-[1000] dropdown-body absolute bg-white rounded-lg w-full xl:w-1/2" x-show="showDropdown" style="top: 70px; left: 0px;">
        <div class="w-full">
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

            <div class="grid grid-cols-12 gap-4 px-6 mt-4 mb-2">
                <div class="col-span-12 flex flex-row gap-3">
                    <template x-for="(value, key) in categories" :key="key">
                        <div @click="changeCategory(key)"
                            class="border-[0.5px] border-[#D4DDD7] px-3 py-2 rounded-full text-sm hover:cursor-pointer flex flex-row items-center"
                            :class="currentCategory == key ? 'bg-green-light' : 'bg-white'">
                            <span x-text="value"></span>
                            <span x-show="countInTmpCurInvestors(key) > 0" class="ml-2 rounded-full bg-black text-white text-sm px-1" x-text="countInTmpCurInvestors(key)"></span>
                        </div>
                    </template>
                </div>
            </div>

            <div class="py-2 px-6">
                <div @click="showingTmpCurInvestors = !showingTmpCurInvestors"
                    class="py-4 px-2 flex flex-row justify-between items-center hover:bg-gray-200 cursor-pointer bg-gray-100 rounded-md">
                    <div class="flex flex-row justify-center items-center gap-x-1 font-semibold">
                        Selected Investors
                        <span class="ml-2 rounded-full bg-black text-white text-sm px-1"
                            x-text="tmpCurInvestors.length"></span>
                    </div>
                    <svg x-show="! showingTmpCurInvestors" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.1685 12.0046L8.21875 7.05483L9.63297 5.64062L15.9969 12.0046L9.63297 18.3685L8.21875 16.9543L13.1685 12.0046Z" fill="#121A0F"/>
                    </svg>
                    <svg x-show="showingTmpCurInvestors" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.9954 13.1724L16.9452 8.22266L18.3594 9.63688L11.9954 16.0008L5.6315 9.63688L7.0457 8.22266L11.9954 13.1724Z" fill="#121A0F"/>
                    </svg>
                </div>

                <div x-show="showingTmpCurInvestors">
                    <template x-for="invt in tmpCurInvestors">
                        <div class="py-4 px-2 flex flex-row justify-between items-center cursor-pointer">
                            <div class="flex flex-row items-center">
                                <span class="capitalize font-bold text-black"
                                    x-text="(invt.name.toLowerCase() + (invt.fund_symbol ? ` (${invt.fund_symbol})` : ''))"></span>
                            </div>
                            <div class="flex flex-row justify-center items-center gap-x-2">
                                <span class="text-[#7C8286] whitespace-nowrap"
                                    x-text="`Owns ${invt.portfolio_size} stocks`"></span>
                                <div class="hover:cursor-pointer hover:text-red" @click="handleClickInvestor(invt)">
                                    <svg width="25" height="25" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.9987 14.6663C4.3168 14.6663 1.33203 11.6815 1.33203 7.99967C1.33203 4.31777 4.3168 1.33301 7.9987 1.33301C11.6806 1.33301 14.6654 4.31777 14.6654 7.99967C14.6654 11.6815 11.6806 14.6663 7.9987 14.6663ZM7.9987 7.05687L6.11308 5.17125L5.17027 6.11405L7.0559 7.99967L5.17027 9.88527L6.11308 10.8281L7.9987 8.94247L9.8843 10.8281L10.8271 9.88527L8.9415 7.99967L10.8271 6.11405L9.8843 5.17125L7.9987 7.05687Z" fill="#C22929"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div x-show="loading" class="grid place-items-center">
                <span class="mx-auto simple-loader text-blue"></span>
            </div>


            <div class="px-8 py-2 overflow-y-auto h-[200px] show-scrollbar" x-ref="investorList">
                <template x-for="invt in investors">
                    <div class="py-4 px-2 flex flex-row justify-between items-center hover:bg-gray-200 cursor-pointer"
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
    </div>
</div>
