<div x-data="{
    loading: false,
    curInvestors: [],
    visibleInvestorsCount: 50,
    overlapMatrix: @entangle('overlapMatrix').defer,
    init() {
        this.$watch('curInvestors', value => {
            const param = this.curInvestors.filter(invt => invt.bAdded);
            this.loading = true;
            this.$wire.updateInvestors(param)
                .finally(() => this.loading = false);
        });
    },
    showInvestorActivities(company_name, data) {
        Livewire.emit('modal.open', 'investor-fund.company-fund-content', { name: company_name, data: data });
    },
    removeCurInvestor(invt) {
        this.curInvestors = this.curInvestors.filter(item => !(item.cik === invt.cik && item.fund_symbol === invt.fund_symbol && item.class_id === invt.class_id && item.series_id === invt.series_id));
    },
    handleSelectAll(event) {
        this.curInvestors.forEach(invt => invt.bAdded = event.target.checked);
    },
    get selectAllStatus() {
        return this.curInvestors.length && this.curInvestors.every(invt => invt.bAdded);
    },
    getNewPosition(funds) {
        return funds.filter(fund => fund.change_amount > 0 && fund.previous == 0);
    },
    getIncreasedPosition(funds) {
        return funds.filter(fund => fund.change_amount > 0 && fund.previous != 0);
    },
    getReducedPosition(funds) {
        return funds.filter(fund => fund.change_amount < 0);
    },
    getMaintainedPosition(funds) {
        return funds.filter(fund => fund.change_amount == 0);
    },
}">
    <h2 class="text-xl font-semibold">Overlap Matrix</h2>

    <!-- Filters -->
    @include('livewire.track-investor.overlap-matrix-filters')

    <template x-if="! curInvestors.length">
        <div class="grid place-items-center py-24">
            <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M129.234 9.42323C129.234 7.26938 127.349 5.38477 125.195 5.38477H41.7338C39.5799 5.38477 37.6953 7.26938 37.6953 9.42323V22.8848C37.6953 25.0386 39.5799 26.9232 41.7338 26.9232H125.195C127.349 26.9232 129.234 25.0386 129.234 22.8848V9.42323Z"
                    fill="#52D3A2" />
                <path
                    d="M26.9195 41.7308C26.9195 39.577 25.0349 37.6924 22.881 37.6924H14.8041C12.6502 37.6924 10.7656 39.577 10.7656 41.7308V76.7308C10.7656 78.8847 12.6502 80.7693 14.8041 80.7693H22.881C25.0349 80.7693 26.9195 78.8847 26.9195 76.7308V41.7308Z"
                    fill="#464E49" />
                <path
                    d="M26.9195 95.577C26.9195 93.4232 25.0349 91.5386 22.881 91.5386H14.8041C12.6502 91.5386 10.7656 93.4232 10.7656 95.577V130.577C10.7656 132.731 12.6502 134.615 14.8041 134.615H22.881C25.0349 134.615 26.9195 132.731 26.9195 130.577V95.577Z"
                    fill="#464E49" />
                <path
                    d="M78.0799 41.7308C78.0799 39.577 76.1953 37.6924 74.0415 37.6924H41.7338C39.5799 37.6924 37.6953 39.577 37.6953 41.7308V49.8078C37.6953 51.9616 39.5799 53.8462 41.7338 53.8462H74.0415C76.1953 53.8462 78.0799 51.9616 78.0799 49.8078V41.7308Z"
                    fill="#D4DDD7" />
                <path
                    d="M129.228 41.7308C129.228 39.577 127.344 37.6924 125.19 37.6924H92.8822C90.7284 37.6924 88.8438 39.577 88.8438 41.7308V49.8078C88.8438 51.9616 90.7284 53.8462 92.8822 53.8462H125.19C127.344 53.8462 129.228 51.9616 129.228 49.8078V41.7308Z"
                    fill="#D4DDD7" />
                <path
                    d="M78.0799 68.6537C78.0799 66.4998 76.1953 64.6152 74.0415 64.6152H41.7338C39.5799 64.6152 37.6953 66.4998 37.6953 68.6537V76.7306C37.6953 78.8845 39.5799 80.7691 41.7338 80.7691H74.0415C76.1953 80.7691 78.0799 78.8845 78.0799 76.7306V68.6537Z"
                    fill="#D4DDD7" />
                <path
                    d="M129.228 68.6537C129.228 66.4998 127.344 64.6152 125.19 64.6152H92.8822C90.7284 64.6152 88.8438 66.4998 88.8438 68.6537V76.7306C88.8438 78.8845 90.7284 80.7691 92.8822 80.7691H125.19C127.344 80.7691 129.228 78.8845 129.228 76.7306V68.6537Z"
                    fill="#D4DDD7" />
                <path
                    d="M78.0799 95.577C78.0799 93.4232 76.1953 91.5386 74.0415 91.5386H41.7338C39.5799 91.5386 37.6953 93.4232 37.6953 95.577V103.654C37.6953 105.808 39.5799 107.692 41.7338 107.692H74.0415C76.1953 107.692 78.0799 105.808 78.0799 103.654V95.577Z"
                    fill="#D4DDD7" />
                <path
                    d="M129.228 95.577C129.228 93.4232 127.344 91.5386 125.19 91.5386H92.8822C90.7284 91.5386 88.8438 93.4232 88.8438 95.577V103.654C88.8438 105.808 90.7284 107.692 92.8822 107.692H125.19C127.344 107.692 129.228 105.808 129.228 103.654V95.577Z"
                    fill="#D4DDD7" />
                <path
                    d="M78.0799 122.5C78.0799 120.346 76.1953 118.461 74.0415 118.461H41.7338C39.5799 118.461 37.6953 120.346 37.6953 122.5V130.577C37.6953 132.731 39.5799 134.615 41.7338 134.615H74.0415C76.1953 134.615 78.0799 132.731 78.0799 130.577V122.5Z"
                    fill="#D4DDD7" />
                <path
                    d="M129.228 122.5C129.228 120.346 127.344 118.461 125.19 118.461H92.8822C90.7284 118.461 88.8438 120.346 88.8438 122.5V130.577C88.8438 132.731 90.7284 134.615 92.8822 134.615H125.19C127.344 134.615 129.228 132.731 129.228 130.577V122.5Z"
                    fill="#D4DDD7" />
            </svg>


            <p class="mt-6 text-xl font-bold">No Data</p>
            <p class="mt-2 text-md">Use the search bar to add funds and analyze the overlap in their portfolios</p>
        </div>
    </template>
    <template x-if="curInvestors.length">
        <div class="mt-6">
            <div class="flex gap-x-4">
                <div class="w-2/3 lg:w-1/2 xl:w-2/5">
                    <div
                        class="py-3 font-semibold text-md bg-white text-black flex flex-row justify-center items-center">
                        Investor List
                        <span class="ml-2 rounded-full bg-black text-white text-sm px-1"
                            x-text="curInvestors.length"></span>
                    </div>
                    <div class="my-3 py-3 px-4 bg-white">
                        <div>
                            <label class="cursor-pointer rounded flex items-center mt-3 py-1 gap-x-3">
                                <input type="checkbox" class="custom-checkbox border-dark focus:ring-0"
                                    x-bind:value="selectAllStatus" @input="handleSelectAll">
                                <span class="font-bold">Select All</span>
                            </label>
                            <template x-for="invt in curInvestors" :key="invt.name + '-' + invt.fund_symbol">
                                <div class="flex flex-row justify-between items-center gap-x-2">
                                    <div class="flex flex-row justify-start items-center gap-x-1">
                                        <label class="cursor-pointer py-1 rounded flex items-center gap-x-3">
                                            <input type="checkbox" :name="name" x-model="invt.bAdded"
                                                class="custom-checkbox border-dark focus:ring-0">
                                            <span class="capitalize break-all"
                                                x-text="invt.fund_symbol ? `${invt.name.toLowerCase()} (${invt.fund_symbol})` : invt.name.toLowerCase()"></span>
                                        </label>

                                        <span
                                            class="rounded-full text-xs font-medium leading-none grid place-items-center bg-blue text-white min-w-[20px] min-h-[20px]"
                                            x-text="invt.portfolio_size">
                                        </span>
                                    </div>
                                    <div class="hover:cursor-pointer hover:text-red" @click="removeCurInvestor(invt)">
                                        <svg width="11" height="11" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.00045 4.05767L7.94676 1.11137C8.14203 0.916104 8.45861 0.916104 8.65387 1.11137L8.88957 1.34706C9.08483 1.54233 9.08483 1.85891 8.88956 2.05417L5.94325 5.00047L8.88956 7.94671C9.08482 8.14197 9.08483 8.45856 8.88956 8.65382L8.65387 8.88952C8.45861 9.08478 8.14203 9.08478 7.94676 8.88952L5.00045 5.94327L2.05418 8.88952C1.85892 9.08478 1.54234 9.08478 1.34707 8.88952L1.11137 8.65382C0.916108 8.45856 0.916108 8.14197 1.11137 7.94671L4.05765 5.00047L1.11137 2.05417C0.916104 1.85891 0.916105 1.54233 1.11137 1.34707L1.34707 1.11136C1.54233 0.916103 1.85892 0.916105 2.05418 1.11137L5.00045 4.05767Z"
                                                fill="#C22929" />
                                        </svg>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="flex flex-row items-center mt-6">
                            <svg width="16px" height="16px">
                                <circle cx="8" cy="8" r="6" fill="blue" />
                            </svg>
                            <span class="pl-3">New Buys</span>
                        </div>
                        <div class="flex flex-row items-center">
                            <svg width="16px" height="16px">
                                <circle cx="8" cy="8" r="6" fill="green" />
                            </svg>
                            <span class="pl-3">Position Increased</span>
                        </div>
                        <div class="flex flex-row items-center">
                            <svg width="16px" height="16px">
                                <circle cx="8" cy="8" r="6" fill="red" />
                            </svg>
                            <span class="pl-3">Position Reduced</span>
                        </div>
                        <div class="flex flex-row items-center">
                            <svg width="16px" height="16px">
                                <circle cx="8" cy="8" r="6" fill="gray" />
                            </svg>
                            <span class="pl-3">Position Maintained</span>
                        </div>
                    </div>
                </div>
                <div class="w-1/3 lg:w-1/2 xl:w-3/5 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                    <template x-if="loading">
                        <div class="col-span-5 py-10 grid place-items-center">
                            <span class="mx-auto simple-loader !text-green-dark"></span>
                        </div>
                    </template>
                    <template x-if="!loading">
                        <template x-for="(value, key) in overlapMatrix">
                            <div class="col-span-1">
                                <div class="py-3 font-semibold text-md bg-white text-black flex flex-row justify-center items-center"
                                    x-text="key + ' investors'"></div>

                                <div>
                                    <template x-for="investor in value">
                                        <div class="my-3 px-2 py-3 bg-white">
                                            <div class="flex flex-row justify-between text-md font-semibold px-2 py-2">
                                                <span x-text="investor.company_name"></span>
                                                <span x-text="'$' + investor.price"></span>
                                            </div>

                                            <div class="my-3 mx-2">
                                                <div x-show="getNewPosition(investor.funds).length"
                                                    class="flex flex-row text-sm">
                                                    <div class="pt-0.5">
                                                        <svg width="16px" height="16px">
                                                            <circle cx="8" cy="8" r="6"
                                                                fill="blue" />
                                                        </svg>
                                                    </div>
                                                    <span class="pl-1">
                                                        <span class="capitalize"
                                                            x-text="getNewPosition(investor.funds).map(fund => (fund.fund_symbol ? `${fund.name.toLowerCase()} (${fund.fund_symbol})` : fund.name.toLowerCase())).join(' | ')"></span>
                                                    </span>
                                                </div>
                                                <div x-show="getIncreasedPosition(investor.funds).length"
                                                    class="flex flex-row text-sm mt-3">
                                                    <div class="pt-0.5">
                                                        <svg width="16px" height="16px">
                                                            <circle cx="8" cy="8" r="6"
                                                                fill="green" />
                                                        </svg>
                                                    </div>
                                                    <span class="pl-1">
                                                        <span class="capitalize"
                                                            x-text="getIncreasedPosition(investor.funds).map(fund => (fund.fund_symbol ? `${fund.name.toLowerCase()} (${fund.fund_symbol})` : fund.name.toLowerCase())).join(' | ')"></span>
                                                    </span>
                                                </div>
                                                <div x-show="getReducedPosition(investor.funds).length"
                                                    class="flex flex-row text-sm mt-3">
                                                    <div class="pt-0.5">
                                                        <svg width="16px" height="16px">
                                                            <circle cx="8" cy="8" r="6"
                                                                fill="red" />
                                                        </svg>
                                                    </div>
                                                    <span class="pl-1">
                                                        <span class="capitalize"
                                                            x-text="getReducedPosition(investor.funds).map(fund => (fund.fund_symbol ? `${fund.name.toLowerCase()} (${fund.fund_symbol})` : fund.name.toLowerCase())).join(' | ')"></span>
                                                    </span>
                                                </div>
                                                <div x-show="getMaintainedPosition(investor.funds).length"
                                                    class="flex flex-row text-sm mt-3">
                                                    <div class="pt-0.5">
                                                        <svg width="16px" height="16px">
                                                            <circle cx="8" cy="8" r="6"
                                                                fill="gray" />
                                                        </svg>
                                                    </div>
                                                    <span class="pl-1">
                                                        <span class="capitalize"
                                                            x-text="getMaintainedPosition(investor.funds).map(fund => (fund.fund_symbol ? `${fund.name.toLowerCase()} (${fund.fund_symbol})` : fund.name.toLowerCase())).join(' | ')"></span>
                                                    </span>
                                                </div>
                                            </div>

                                            <a class="block mx-auto font-semibold text-center cursor-pointer"
                                                @click.prevent="showInvestorActivities(key, investor)">See Investors
                                                Activities</a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>
