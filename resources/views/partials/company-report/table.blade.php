<div class="flex justify-between items-center mt-6">
    <div class="warning-wrapper">
        <div class="warning-text text-sm">
            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7.99967 14.6663C4.31777 14.6663 1.33301 11.6815 1.33301 7.99967C1.33301 4.31777 4.31777 1.33301 7.99967 1.33301C11.6815 1.33301 14.6663 4.31777 14.6663 7.99967C14.6663 11.6815 11.6815 14.6663 7.99967 14.6663ZM7.99967 13.333C10.9452 13.333 13.333 10.9452 13.333 7.99967C13.333 5.05415 10.9452 2.66634 7.99967 2.66634C5.05415 2.66634 2.66634 5.05415 2.66634 7.99967C2.66634 10.9452 5.05415 13.333 7.99967 13.333ZM7.33301 9.99967H8.66634V11.333H7.33301V9.99967ZM7.33301 4.66634H8.66634V8.66634H7.33301V4.66634Z"
                    fill="#DA680B" />
            </svg>
            Click on any of the row(s) to chart the data
        </div>
    </div>

    <div class="flex justify-end items-center gap-x-5">
        <button class="bg-gray-200 rounded-lg hover:bg-gray-300 transition p-2"
            @click.prevent="showAllRows = !showAllRows">
            <svg class="h-4 w-4" data-slot="icon" fill="none" stroke-width="2" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" x-show="showAllRows" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
            </svg>
            <svg class="h-4 w-4" data-slot="icon" fill="none" stroke-width="2" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" x-show="!showAllRows" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88">
                </path>
            </svg>
        </button>

        <div class="flex items-center">
            <span class="currency-font">Currency: &nbsp;</span>
            <select wire:model="currency" id="currency-select" class="inline-flex font-bold !pr-8 bg-transparent">
                <option value="USD">USD</option>
            </select>
        </div>
    </div>
</div>

<div class="mt-6 relative">
    <div class="rounded-lg sticky-table-container">
        <table class="rounded-lg overflow-clip max-w-[max-content] mx-auto text-right"
            :class="tableClasses">
            <thead>
                <tr class="capitalize text-dark bg-[#EDEDED] text-base font-bold">
                    <th class="pl-6 py-2 bg-[#EDEDED] text-left">
                        {{ $company['name'] }} ({{ $company['ticker'] }})
                    </th>
                    <template x-for="date in formattedTableDates" :key="date">
                        <th class="pl-6 py-2 last:pr-6" x-text="formattedTableDate(date)"></th>
                    </template>
                </tr>
            </thead>
            <template x-for="(rows, groupIdx) in rowGroups">
                <tbody class="report-tbody">
                    <template x-for="(row, index) in rows" :key="`${index}-${row.title}`">
                        <tr x-data="{
                            get isRowSelectedForChart() {
                                return this.selectedChartRows.find(item => item.id === row.id) ? true : false;
                            },
                            get isLast() {
                                return rows.length - 1 === this.index;
                            },
                            get paddings() {
                                const beforeRow = this.rows[this.index - 1];
                                const afterRow = this.rows[this.index + 1];
                        
                                let top = 'pt-1';
                                let bottom = 'pb-1';
                        
                                if (this.index === 0 || this.row?.hasBorder) {
                                    top = 'pt-2';
                                }
                        
                                if (this.index === this.rows.length - 1 || afterRow?.hasBorder) {
                                    bottom = 'pb-2';
                                }
                        
                                return top + ' ' + bottom;
                            }
                        }"
                            :class="[
                                (row.hasBorder && index !== 0) ? 'border-[#D4DDD7] border-t' : '',
                                hideSegments.includes(row.parent) ? 'hidden' : '',
                                row.isBold ? 'font-bold' : '',
                                isRowSelectedForChart ? 'bg-[#d5ebe3]' : (row.segmentation ? 'bg-[#e4eff3]' :
                                    'bg-white'),
                            ]">
                            <td class="pl-6 text-left"
                                :class="[
                                    isRowSelectedForChart ? '!bg-[#d5ebe3]' : (row.segmentation ? '!bg-[#e4eff3]' : ''),
                                    index === 0 && groupIdx != 0 ? 'rounded-tl-lg' : '',
                                    isLast ? 'rounded-bl-lg' : '',
                                    paddings
                                ]">
                                <div class="flex items-center">
                                    <input x-show="isRowSelectedForChart" type="checkbox" class="custom-checkbox"
                                        :checked="isRowSelectedForChart" style="margin-left: -18px; margin-right: 2px;"
                                        @change="toggleRowForChart(row)">

                                    <p class="max-w-[200px] truncate overflow-ellipsis overflow-hidden"
                                        :style="`padding-left: ${row.depth * 8}px`"
                                        :class="!row.empty && !row.seg_start ? 'cursor-pointer' : ''" x-text="row.title"
                                        @click="toggleRowForChart(row)"></p>

                                    <template x-if="row.seg_start">
                                        <button class="ml-1 shrink-0 transition-all"
                                            :class="hideSegments.includes(row.id) ? '-rotate-90' : ''"
                                            @click="toggleSegment(row.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16" fill="none">
                                                <path
                                                    d="M14.668 7.99992C14.668 4.32659 11.6746 1.33325 8.0013 1.33325C4.32797 1.33325 1.33464 4.32658 1.33464 7.99992C1.33464 11.6733 4.32797 14.6666 8.0013 14.6666C11.6746 14.6666 14.668 11.6733 14.668 7.99992ZM7.64797 9.85992L5.29464 7.50658C5.19464 7.40658 5.14797 7.27992 5.14797 7.15325C5.14797 7.02658 5.19464 6.89992 5.29464 6.79992C5.48797 6.60658 5.80797 6.60658 6.0013 6.79992L8.0013 8.79992L10.0013 6.79992C10.1946 6.60658 10.5146 6.60658 10.708 6.79992C10.9013 6.99325 10.9013 7.31325 10.708 7.50658L8.35464 9.85992C8.1613 10.0599 7.8413 10.0599 7.64797 9.85992Z"
                                                    fill="#3561E7"></path>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </td>
                            <template x-for="date in formattedTableDates" :key="date">
                                <td class="pl-6 last:pr-6"
                                    :class="[
                                        isLast ? 'last:rounded-br-lg' : '',
                                        index === 0 && groupIdx != 0 ? 'last:rounded-tr-lg' : '',
                                        paddings
                                    ]">
                                    <x-review-number-button x-data="{ amount: row.values[date]?.value, date, }">
                                        <div class="hover:underline cursor-pointer"
                                            :class="row.values[date]?.isNegative ? 'text-red' : ''"
                                            x-text="row.values[date]?.result"
                                            @click="Livewire.emit('slide-over.open', 'slides.right-slide', {data: row.values[date]})">
                                        </div>
                                    </x-review-number-button>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </template>
        </table>
    </div>

    <div class="cus-loader" wire:loading.block>
        <div class="cus-loaderBar"></div>
    </div>
</div>
