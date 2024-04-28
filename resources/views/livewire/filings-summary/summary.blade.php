<div x-cloak class="grid grid-cols-1 xl:grid-cols-2 gap-6" x-data="{
    search: {},
    items: @js($items),
    order: @js($order),
    values: @js($values),
    sortByDateTitle: {},
    init() {
        this.items.forEach((item) => {
            this.sortByDateTitle[item.value] = 'filing_date';
        });
    },
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
                    return new Date(b.acceptance_time) - new Date(a.acceptance_time);
                }
                return 0;
            })
        }));
        return filteredData;
    }
}">
    <template x-for="(item, key) in filteredItems" :key="key + item.value">
        <div class="bg-white rounded overflow-hidden">
            <div class="flex justify-between items-center py-3 px-4 border-b border-green-muted">
                <div>
                    <h4 x-text="item.name.split(' ')[0]"
                        class="text-[#3561E7] font-[600] text-[0.8125rem] max-w-[100px] whitespace-nowrap truncate text-ellipsis"
                        :data-tooltip-content="item.name" />
                </div>

                <div class="flex items-center">
                    <div class="hidden 2xl:flex justify-start items-center gap-1">
                        <label class="cursor-pointer flex items-center gap-1">
                            <input x-model="sortByDateTitle[item.value]" :name="key + item.value" value="filing_date"
                                class="custom-radio custom-radio-xs" type="radio">
                            </input>
                            <span class="text-sm">Sort by date</span>
                        </label>
                        <label class="mr-3 cursor-pointer flex items-center gap-1">
                            <input x-model="sortByDateTitle[item.value]" :name="key + item.value" value="form_type"
                                class="custom-radio custom-radio-xs" type="radio">
                            </input>
                            <span class="text-sm">Sort by title</span>
                        </label>
                    </div>

                    <select x-model="sortByDateTitle[item.value]" id="countries"
                        class="inline-block 2xl:hidden py-1 px-2 rounded-full border border-solid border-green-muted text-sm">
                        <option value="filing_date">Sort by date</option>
                        <option value="form_type">Sort by type</option>
                    </select>

                    <div class="ml-4 flex gap-1 items-center">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.5763 9.54717H10.0343L9.8422 9.36192C10.5146 8.57976 10.9194 7.56432 10.9194 6.45969C10.9194 3.99657 8.92281 2 6.45969 2C3.99657 2 2 3.99657 2 6.45969C2 8.92281 3.99657 10.9194 6.45969 10.9194C7.56432 10.9194 8.57976 10.5146 9.36192 9.8422L9.54717 10.0343V10.5763L12.9777 14L14 12.9777L10.5763 9.54717ZM6.45969 9.54717C4.75129 9.54717 3.37221 8.1681 3.37221 6.45969C3.37221 4.75129 4.75129 3.37221 6.45969 3.37221C8.1681 3.37221 9.54717 4.75129 9.54717 6.45969C9.54717 8.1681 8.1681 9.54717 6.45969 9.54717Z"
                                fill="#464E49" />
                        </svg>

                        <input x-model="search[item.value]" type="search"
                            class="focus:ring-0 focus:border-blue-500 text-sm border-none w-[120px] search-x-button-small placeholder:text-dark-light2 px-0"
                            placeholder="Search document" />
                    </div>

                    <div class="ml-6">
                        <a hre="#"
                            class="text-sm text-[#F78400] font-bold hover:text-[#cd7a1b] whitespace-nowrap"
                            @click.prevent="$wire.emit('handleFilingsSummaryTab',['all-filings', item.value])">
                            View All
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <div class="h-[20rem] overflow-scroll filing-table no-horizontal-scrollbar">
                    <table class="min-w-full">
                        <tbody class="bg-white divide-y divide-green-muted">
                            <template x-for="(val, index) in item.values" :key="index">
                                <tr @click="Livewire.emit('modal.open', 'company-link-s3-content', { row: val })"
                                    :style="index === 0 ? 'border-top: none !important;' : ''"
                                    class="hover:bg-gray-50 cursor-pointer">
                                    <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap"
                                        x-text="val.form_type"></td>
                                    <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap">
                                        <p class="truncate w-36" x-text="val.description"
                                            :data-tooltip-content="val.description"></p>
                                    </td>
                                    <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap"
                                        x-text="val.acceptance_time"></td>
                                    <td class="px-4 py-3 text-base  font-[400] text-[#121A0F] whitespace-nowrap"
                                        x-text="val.filing_date"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>
</div>
