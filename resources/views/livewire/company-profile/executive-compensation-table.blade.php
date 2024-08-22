<div class="mt-4 relative">
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
        number_format(number, decimals = 0, decPoint = '.', thousandsSep = ',') {
            if (!isFinite(number)) {
                return '0';
            }
    
            const fixedNumber = number.toFixed(decimals);
            const [integerPart, decimalPart] = fixedNumber.split('.');
    
            // Add thousands separator
            const integerWithThousands = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);
    
            // Combine the integer part and decimal part
            const result = decimalPart ? integerWithThousands + decPoint + decimalPart : integerWithThousands;
    
            return result;
        }
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
                                    @click="Livewire.emit('slide-over.open', 's3-link-html-content', { url: values.s3_url, sourceLink: values.url})">Show
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
                                <span x-text="number_format(row.total)"></p>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="number_format(row.salary)"></p>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="number_format(row.bonus)"></p>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="number_format(row.stock_award)"></p>
                            </td>
                            <td class="py-2 text-right">
                                <span x-text="number_format(row.incentive_plan_compensation)"></p>
                            </td>
                            <td class="pr-6 py-2 text-right">
                                <span x-text="number_format(row.all_other_compensation)"></p>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </template>
        </table>
    </div>
</div>
