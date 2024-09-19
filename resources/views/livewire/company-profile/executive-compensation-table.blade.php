<div class="mt-4 relative">
    <div wire:loading.flex class="justify-center items-center p-4">
        <div class="grid place-content-center h-full" role="status">
            <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor" />
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="rounded-lg sticky-table-container" x-data="{
        data: $wire.entangle('data').defer,
        hideSegments: [],
        toggleSegment(date) {
            if (this.hideSegments.includes(date)) {
                this.hideSegments = this.hideSegments.filter(item => item !== date);
            } else {
                this.hideSegments.push(date);
            }
        },
        init() {
            this.$watch('data', value => {
                this.hideSegments = [];
            });
        },
    }">
        <table class="rounded-lg overflow-clip w-full text-right">
            <thead>
                <tr class="capitalize text-dark bg-[#EDEDED] text-base font-bold">
                    <th class="pl-6 py-2 bg-[#EDEDED] text-left">Current Position</th>
                    <th class="py-2">year</th>
                    <th class="py-2">total</th>
                    <th class="py-2">salary</th>
                    <th class="py-2">bonus</th>
                    <th class="py-2">stock_award</th>
                    <th class="py-2">incentive_plan</th>
                    <th class="pr-6 py-2">other</th>
                </tr>
            </thead>
            <template x-for="(values, filing_date) in data">
                <tbody>
                    <tr class="bg-white">
                        <td class="pl-6 py-2 text-left font-bold">
                            <div class="flex items-center">
                                <span x-text="filing_date"></span>
                                <button class="ml-1 shrink-0 transition-all"
                                    :class="hideSegments.includes(filing_date) ? '-rotate-90' : ''"
                                    @click="toggleSegment(filing_date)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none">
                                        <path
                                            d="M14.668 7.99992C14.668 4.32659 11.6746 1.33325 8.0013 1.33325C4.32797 1.33325 1.33464 4.32658 1.33464 7.99992C1.33464 11.6733 4.32797 14.6666 8.0013 14.6666C11.6746 14.6666 14.668 11.6733 14.668 7.99992ZM7.64797 9.85992L5.29464 7.50658C5.19464 7.40658 5.14797 7.27992 5.14797 7.15325C5.14797 7.02658 5.19464 6.89992 5.29464 6.79992C5.48797 6.60658 5.80797 6.60658 6.0013 6.79992L8.0013 8.79992L10.0013 6.79992C10.1946 6.60658 10.5146 6.60658 10.708 6.79992C10.9013 6.99325 10.9013 7.31325 10.708 7.50658L8.35464 9.85992C8.1613 10.0599 7.8413 10.0599 7.64797 9.85992Z"
                                            fill="#3561E7"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="bg-white" colspan="7">
                            <div>
                                <button type="button"
                                    class="inline-block px-2 py-1 bg-[#DCF6EC] hover:bg-green-dark transition-all rounded"
                                    @click="Livewire.emit('slide-over.open', 's3-link-html-content', { url: values.s3_url, sourceLink: values.url, quantity: values.data[0]?.total})">Show
                                    Report</button>
                            </div>
                        </td>
                    </tr>
                    <template x-for="(row, index) in values.data">
                        <tr x-show="!hideSegments.includes(filing_date)" class="bg-[#e4eff3]">
                            <td class="pl-6 py-2 text-left">
                                <span class="pl-3" x-text="row.name_and_position"></span>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="row.year"></p>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="window.formatDecimalNumber(row.total)"></p>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="window.formatDecimalNumber(row.salary)"></p>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="window.formatDecimalNumber(row.bonus)"></p>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="window.formatDecimalNumber(row.stock_award)"></p>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="window.formatDecimalNumber(row.incentive_plan_compensation)"></p>
                            </td>
                            <td class="pr-6 py-2 text-right">
                                <span x-text="window.formatDecimalNumber(row.all_other_compensation)"></p>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </template>
        </table>
    </div>
</div>
