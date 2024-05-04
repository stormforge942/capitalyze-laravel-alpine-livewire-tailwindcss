<div class="flex justify-between items-center mt-6">
    <div class="warning-wrapper">
        <div class="warning-text text-sm font-medium">
            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7.99967 14.6663C4.31777 14.6663 1.33301 11.6815 1.33301 7.99967C1.33301 4.31777 4.31777 1.33301 7.99967 1.33301C11.6815 1.33301 14.6663 4.31777 14.6663 7.99967C14.6663 11.6815 11.6815 14.6663 7.99967 14.6663ZM7.99967 13.333C10.9452 13.333 13.333 10.9452 13.333 7.99967C13.333 5.05415 10.9452 2.66634 7.99967 2.66634C5.05415 2.66634 2.66634 5.05415 2.66634 7.99967C2.66634 10.9452 5.05415 13.333 7.99967 13.333ZM7.33301 9.99967H8.66634V11.333H7.33301V9.99967ZM7.33301 4.66634H8.66634V8.66634H7.33301V4.66634Z"
                    fill="#DA680B" />
            </svg>
            Click on row(s) to chart data; click values to view source filing
        </div>
    </div>

    <div class="flex justify-end items-center gap-x-5 text-sm+">
        @can('review-data')
            <button class="font-semibold hover:drop-shadow transition-all" type="button" @click="publicView = !publicView">
                <span x-show="!publicView">Public View</span>
                <span x-show="publicView" x-cloak>Exit Public View</span>
            </button>
        @endcan

        <button class="font-semibold hover:drop-shadow transition-all text-sm+"
            @click.prevent="showAllRows = !showAllRows">
            <div class="flex items-center gap-x-2" x-show="!showAllRows" x-cloak>
                <span>Show Details</span>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.789062 8C1.41607 4.58651 4.40672 2 8.0015 2C11.5962 2 14.5869 4.58651 15.2139 8C14.5869 11.4135 11.5962 14 8.0015 14C4.40672 14 1.41607 11.4135 0.789062 8ZM8.0015 11.3333C9.84244 11.3333 11.3348 9.84093 11.3348 8C11.3348 6.15905 9.84244 4.66667 8.0015 4.66667C6.16053 4.66667 4.66814 6.15905 4.66814 8C4.66814 9.84093 6.16053 11.3333 8.0015 11.3333ZM8.0015 10C6.8969 10 6.00148 9.1046 6.00148 8C6.00148 6.8954 6.8969 6 8.0015 6C9.10604 6 10.0015 6.8954 10.0015 8C10.0015 9.1046 9.10604 10 8.0015 10Z"
                        fill="#121A0F" />
                </svg>
            </div>
            <div class="flex items-center gap-x-2" x-show="showAllRows" x-cloak>
                <span>Hide Details</span>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_11707_132448)">
                        <path
                            d="M3.01495 3.95655L0.930409 1.87201L1.87322 0.929199L15.0726 14.1285L14.1298 15.0714L11.9231 12.8647C10.7889 13.5838 9.44384 14.0003 8.0015 14.0003C4.40672 14.0003 1.41607 11.4138 0.789062 8.0003C1.08018 6.41538 1.88085 5.00877 3.01495 3.95655ZM9.83977 10.7814L8.86377 9.80537C8.60264 9.9303 8.31024 10.0003 8.0015 10.0003C6.8969 10.0003 6.00148 9.10483 6.00148 8.0003C6.00148 7.6915 6.07145 7.3991 6.19639 7.13797L5.22041 6.16201C4.8714 6.68897 4.66814 7.3209 4.66814 8.0003C4.66814 9.84123 6.16053 11.3336 8.0015 11.3336C8.68084 11.3336 9.31277 11.1304 9.83977 10.7814ZM5.31761 2.50693C6.14882 2.17989 7.05417 2.00027 8.0015 2.00027C11.5962 2.00027 14.5869 4.58678 15.2139 8.0003C15.0058 9.13337 14.5372 10.1754 13.8725 11.0618L11.2993 8.48863C11.3227 8.32923 11.3348 8.16617 11.3348 8.0003C11.3348 6.15932 9.84244 4.66694 8.0015 4.66694C7.83557 4.66694 7.6725 4.67905 7.5131 4.70245L5.31761 2.50693Z"
                            fill="#121A0F" />
                    </g>
                    <defs>
                        <clipPath id="clip0_11707_132448">
                            <rect width="16" height="16" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
        </button>

        <div class="flex items-center">
            <span class="currency-font">Currency: &nbsp;</span>
            <select wire:model="currency" id="currency-select" class="inline-flex font-bold !pr-8 bg-transparent">
                <option value="USD">USD</option>
            </select>
        </div>
    </div>
</div>

<div class="mt-4 relative">
    <div class="rounded-lg sticky-table-container">
        <table class="rounded-lg overflow-clip max-w-[max-content] mx-auto text-right" :class="tableClasses">
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
                                !row.empty && !row.seg_start ? 'cursor-pointer' : '',
                                !row.empty && !row.seg_start && !isRowSelectedForChart ? 'financials-table-row' : '',
                            ]"
                            @click="(e) => {
                                if(e.target.classList.contains('clickable')) return;

                                toggleRowForChart(row);
                            }">
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

                                    <p class="max-w-[250px] w-[max-content] whitespace-normal"
                                        :style="`padding-left: ${row.depth * 8}px`" x-text="row.title"
                                        :data-tooltip-content="row.title"></p>

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
                                <td class="pl-6 last:pr-6" style="vertical-align: center;"
                                    :class="[
                                        isLast ? 'last:rounded-br-lg' : '',
                                        index === 0 && groupIdx != 0 ? 'last:rounded-tr-lg' : '',
                                        paddings
                                    ]">
                                    <template x-if="row.values[date].isLink">
                                        <button type="button"
                                            class="inline-flex items-center gap-x-0.5 text-sm font-medium hover:text-blue clickable"
                                            @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', {data: row.values[date]})">
                                            <span>show</span>
                                            <svg class="h-3 w-3" data-slot="icon" fill="none" stroke-width="2.5"
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25">
                                                </path>
                                            </svg>
                                        </button>
                                    </template>
                                    <template x-if="!row.values[date].isLink">
                                        <div>
                                            <x-review-number-button x-data="{ amount: row.values[date]?.value, date, }" x-show="!publicView">
                                                <div class="hover:underline cursor-pointer clickable"
                                                    :class="row.values[date]?.isNegative ? 'text-red' : ''"
                                                    x-text="row.values[date]?.result"
                                                    @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', {data: row.values[date]})">
                                                </div>
                                            </x-review-number-button>

                                            <div class="hover:underline cursor-pointer clickable"
                                                :class="row.values[date]?.isNegative ? 'text-red' : ''"
                                                x-text="row.values[date]?.result"
                                                @click.prevent="Livewire.emit('slide-over.open', 'slides.right-slide', {data: row.values[date]})"
                                                x-cloak x-show="publicView">
                                            </div>
                                        </div>
                                    </template>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </template>
        </table>
    </div>
</div>
