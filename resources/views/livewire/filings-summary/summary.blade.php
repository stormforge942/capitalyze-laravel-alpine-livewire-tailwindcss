<div x-cloak class="flex flex-col lg:flex-row justify-start items-center flex-wrap" x-data="{
    search: {},
    items: @js($items),
    order: @js($order),
    values: @js($values),
    sortByDateTitle: {},
    get filteredItems() {
        const filteredData = this.items.map(item => ({
            ...item,
            values: this.values.filter((value) => {
                if (item.params.length === 0) {
                    return true;
                } else {
                    return item.params.includes(value.form_type);
                }
            }).
            filter((value) => {
                const searchValue = this.search[item.value]?.toLowerCase()
                if (!searchValue) {
                    return true;
                }
                const matchesFormType = value.form_type?.toLowerCase().startsWith(searchValue);
                const matchesRegistrantName = value.registrant_name?.toLowerCase().startsWith(searchValue);
                return matchesFormType || matchesRegistrantName;
            }).
            sort((a, b) => {
                if (this.sortByDateTitle[item.value] === 'form_type') {
                    return a.form_type.localeCompare(b.form_type);
                } else if (this.sortByDateTitle[item.value] === 'filing_date') {
                    return new Date(a.filing_date) - new Date(b.filing_date);
                }
                return 0;
            })
        }));
        return filteredData;
    }
}">
    <?php $i = 0; ?>
    <template x-for="(item, key) in filteredItems" :key="key + item.value">
        <div
            class="bg-white p-3 rounded w-full lg:w-[calc(50%-1rem)] mr-0 lg-0 {{ $i % 2 === 0 ? 'lg:mr-3' : 'lg:ml-4' }} mb-5">
            <div
                class="flex justify-between items-center content-center py-2 mx-[-0.75rem] mb-1 border-b border-grey-light">
                <div>
                    <h4 x-text="item.name" class="mx-3 text-[#3561E7] font-[600] text-[0.8125rem]" />
                </div>
                <div class="hidden xl:flex justify-start items-center content-center">
                    <label class="mr-3 flex items-center cursor-pointer">
                        <input x-model="sortByDateTitle[item.value]" :name="key + item.value"
                            value="filing_date"
                            class="custom-radio focus:ring-0 border-gray-medium2 filing-summary mr-1 cursor-pointer"
                            type="radio">
                        </input>
                        <span class="text-sm leading-3">Sort by date</span>
                    </label>
                    <label class="mr-3 flex items-center cursor-pointer">
                        <input x-model="sortByDateTitle[item.value]" :name="key + item.value"
                            value="form_type"
                            class="custom-radio focus:ring-0 border-gray-medium2 filing-summary mr-1 cursor-pointer"
                            type="radio">
                        </input>
                        <span class="text-sm leading-3">Sort by title</span>
                    </label>
                    <div class="flex justify-start items-center content-center">
                        <div class="m-0 p-0 cursor-pointer">
                            <img class="mr-0" src="{{ asset('/svg/search.svg') }}" />
                        </div>
                        <input x-model="search[item.value]" type="search"
                            class="focus:ring-0 focus:border-blue-500 placeholder:text-sm text-sm  border-none w-[9rem] leading-[1.45rem] h-[1.45rem] search-x-button-small pl-1"
                            placeholder="search document" />
                    </div>
                </div>
                <div
                    class="2xl:hidden xl:hidden xs:flex-col sm:flex-row lg:flex-col xl:flex-row flex justify-between items-center">
                    <select x-model="sortByDateTitle[item.value]" id="countries"
                        class="h-7 py-0.75 px-3 rounded-full border border-solid border-[#939598] text-sm">
                        <option selected>Choose a value</option>
                        <option value="form_type">Sort by form type</option>
                        <option value="filing_date">Sort by filing Date</option>
                    </select>
                    <div class="flex justify-start items-start">
                        <div class="ml-3 p-0">
                            <img class="mt-1 mr-0" src="{{ asset('/svg/search.svg') }}" />
                        </div>
                        <div class="xs:flex xl:hidden 2xl:flex">
                            <input x-model="search[item.value]" type="search"
                                class="focus:ring-0 focus:border-blue-500 placeholder:text-sm text-sm  border-none w-[9rem] leading-[1.45rem] h-[1.45rem]"
                                placeholder="search document" />
                        </div>
                    </div>
                </div>
                <div class="mx-3">
                    <a hre="#" class="text-sm text-[#F78400]"
                        @click="$wire.emit('handleFilingsSummaryTab',['all-filings', item.value])">View All</a>
                </div>
            </div>
            <div class="overflow-hidden -mt-1 border h-[20rem] overflow-y-auto border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                        <template x-for="(val, index) in item.values" :key="index">
                            <tr @click="Livewire.emit('modal.open', 'company-link-s3-content', { row: val })"
                                class="hover:bg-gray-50 cursor-pointer">
                                <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap"
                                    x-text="val.form_type"></td>
                                <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap">
                                    <p class="truncate w-36" x-text="val.description"></p>
                                </td>
                                <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap"
                                    x-text="val.filing_date"></td>
                                <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap"
                                    x-text="val.filing_date"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        <?php $i++; ?>
    </template>
</div>
