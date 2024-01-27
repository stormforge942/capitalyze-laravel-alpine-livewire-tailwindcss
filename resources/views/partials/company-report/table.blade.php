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

    <div class="flex justify-end items-baseline">
        <span class="currency-font">Currency: &nbsp;</span>
        <select wire:model="currency" id="currency-select" class="inline-flex font-bold !pr-8 bg-transparent">
            <option value="USD">USD</option>
            <option value="CAD">CAD</option>
            <option value="EUR">EUR</option>
        </select>
    </div>
</div>

<div class="relative" x-cloak>
    <div class="table-wrapper" style="font-size: 12px;">
        <div class="table w-full">
            <div class="table-cell text-center">
                <div class="row-group !inline-block mx-auto">

                    <div class="flex flex-row bg-[#EDEDED]">
                        <div class="ml-8 w-[250px] font-bold flex py-2 items-center justify-start text-base">
                            <span>
                                {{ $company['name'] }} ({{ $company['ticker'] }})
                            </span>
                        </div>
                        <div class="w-full flex flex-row bg-[#EDEDED] justify-between">
                            <template x-for="date in formattedTableDates" :key="date">
                                <div class="w-[150px] flex items-center justify-end text-base font-bold last:pr-8">
                                    <span class="py-2" x-text="formattedTableDate(date)"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="divide-y divide-[#D4DDD7] text-base" x-data="{ lastSection: null, nestingLevel: 0, loadChildren }">
                        <template x-for="(row, index) in rows" :key="`${index}-${row.title}`">
                            <div class="flex flex-col" :class="[rowContext.isBold ? 'font-bold' : '', classes]"
                                x-data="{
                                    isNewSection: false,
                                    get rowContext() {
                                        let splitted = row.title.split('|');
                                
                                        if (splitted.length === 1) return { title: splitted[0] };
                                
                                        return {
                                            title: splitted[0],
                                            isBold: splitted[1] === 'true',
                                            hasBorder: splitted[2] === 'true',
                                            section: parseInt(splitted[3]) || this.lastSection,
                                        };
                                    },
                                    get isRowSelectedForChart() {
                                        return this.selectedChartRows.find(item => item.id === row.id) ? true : false;
                                    },
                                    get classes() {
                                        let classes = '';
                                
                                        if (!this.rowContext.hasBorder) {
                                            classes += 'flex-col-border-less ';
                                        }
                                
                                        if (this.isNewSection) {
                                            classes += 'mt-4 ';
                                        }
                                
                                        return classes;
                                    },
                                    init() {
                                        if (
                                            index > 0 &&
                                            (this.rowContext.section !== this.lastSection)
                                        ) {
                                            this.isNewSection = true;
                                        }
                                
                                        this.lastSection = this.rowContext.section;
                                    },
                                    toggleRowForChart() {
                                        if (this.isRowSelectedForChart) {
                                            this.selectedChartRows = this.selectedChartRows.filter(item => item.id !== row.id);
                                        } else {
                                            let values = {};
                                
                                            for (const [key, value] of Object.entries(row.values)) {
                                                values[key] = value.value;
                                            }
                                
                                            this.selectedChartRows.push({
                                                id: row.id,
                                                title: this.rowContext.title,
                                                values,
                                                color: '#7C8286',
                                                type: 'line',
                                            });
                                        }
                                    },
                                }" x-init="loadChildren(this, nestingLevel + 1)">
                                <div class="flex w-full flex-row"
                                    :class="[isRowSelectedForChart ? 'bg-[#52D3A2]/20' : (row.segmentation ?
                                        'bg-[#52C6FF]/10' : 'bg-white')]">
                                    <div class="flex justify-end items-center ml-2">
                                        <input x-show="isRowSelectedForChart" type="checkbox" class="custom-checkbox"
                                            :checked="isRowSelectedForChart" @change="toggleRowForChart">
                                    </div>
                                    <div class="cursor-default py-2  w-[250px] truncate flex flex-row items-center"
                                        :class="isRowSelectedForChart ? 'ml-2' : 'ml-6'" style="">
                                        <a href="#" @click.prevent="toggleRowForChart" x-text="rowContext.title"
                                            class="whitespace-nowrap truncate text-base"
                                            :class="rowContext.isBold ? 'font-bold' : ''">
                                        </a>
                                    </div>
                                    <div class="w-full flex flex-row justify-between ">
                                        <template x-for="date in formattedTableDates" :key="date">
                                            <div class="w-[150px] flex items-center justify-end text-base last:pr-8"
                                                x-data="{
                                                    get formattedValue() {
                                                        const isPercent = rowContext.title.includes('%') ||
                                                            rowContext.title.includes('yoy') ||
                                                            rowContext.title.includes('per');
                                                
                                                        return formatTableValue(row.values[date]?.value, isPercent)
                                                    },
                                                }">

                                                <template x-if="formattedValue.isLink">
                                                    <button class="flex items-center underline">
                                                        Link
                                                    </button>
                                                </template>

                                                <template x-if="!formattedValue.isLink">
                                                    <div>
                                                        <x-review-number-button x-data="{ amount: row.values[date]?.value || 0, date }">
                                                            <span class="hover:underline cursor-pointer"
                                                                :class="formattedValue.isNegative ? 'text-red' : ''"
                                                                x-text="formattedValue.result"
                                                                @click="$wire.emit('rightSlide', row.values[date])">
                                                            </span>
                                                        </x-review-number-button>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div x-ref="nestedTable"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cus-loader" wire:loading.block>
        <div class="cus-loaderBar"></div>
    </div>
</div>


@push('scripts')
    <script>
        function loadChildren(componentInstance, nestingLevel) {
            const nestedTable = this.$refs.nestedTable;
            const template = `
                <template x-for="(row, index) in row.children" :key="index">
                    <div class="flex flex-col flex-col-border-less" x-data="{
                            showChildren: true,
                            get isRowSelectedForChart() {
                                return this.selectedChartRows.find(item => item.id === row.id) ? true : false;
                            },
                            toggleRowForChart() {
                                if(row.seg_start) {
                                    return;
                                }

                                if (this.isRowSelectedForChart) {
                                    this.selectedChartRows = this.selectedChartRows.filter(item => item.id !== row.id);
                                } else {
                                    let values = {};
                        
                                    for (const [key, value] of Object.entries(row.values)) {
                                        values[key] = value.value;
                                    }

                                    this.selectedChartRows.push({
                                        id: row.id,
                                        title: row.title,
                                        values: values,
                                        color: '#7C8286',
                                        type: 'line',
                                    });
                                }
                            },
                        }" x-init="loadChildren(this, ${nestingLevel + 1})">
                        <div class="flex w-full flex-row" :class="[isRowSelectedForChart ? 'bg-[#52D3A2]/20' : (row.segmentation ? 'bg-[#52C6FF]/10' : 'bg-white')]" >
                            <div class="flex justify-end items-center ml-2">
                                <input x-show="isRowSelectedForChart" type="checkbox" class="custom-checkbox"
                                    :checked="isRowSelectedForChart" @change="toggleRowForChart">
                            </div>
                            <div class="cursor-default py-2 w-[250px] truncate flex flex-row items-center gap-1"
                                :class="isRowSelectedForChart ? 'ml-2' : 'ml-6'" :style="{ paddingLeft: ${nestingLevel} + 'rem' }">
                                <a href="#" @click.prevent="toggleRowForChart"
                                    x-text="row.title" class="whitespace-nowrap truncate text-base cursor-pointer">
                                </a>
                                <button class="shrink-0" x-show="row.seg_start" :class="showChildren ? '' : '-rotate-90'" x-cloak @click="showChildren = !showChildren">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M14.668 7.99992C14.668 4.32659 11.6746 1.33325 8.0013 1.33325C4.32797 1.33325 1.33464 4.32658 1.33464 7.99992C1.33464 11.6733 4.32797 14.6666 8.0013 14.6666C11.6746 14.6666 14.668 11.6733 14.668 7.99992ZM7.64797 9.85992L5.29464 7.50658C5.19464 7.40658 5.14797 7.27992 5.14797 7.15325C5.14797 7.02658 5.19464 6.89992 5.29464 6.79992C5.48797 6.60658 5.80797 6.60658 6.0013 6.79992L8.0013 8.79992L10.0013 6.79992C10.1946 6.60658 10.5146 6.60658 10.708 6.79992C10.9013 6.99325 10.9013 7.31325 10.708 7.50658L8.35464 9.85992C8.1613 10.0599 7.8413 10.0599 7.64797 9.85992Z" fill="#3561E7"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="w-full flex flex-row justify-between ">
                                <template x-for="date in formattedTableDates" :key="date">
                                    <div class="w-[150px] flex items-center justify-end text-base last:pr-8"
                                        x-data="{
                                            get formattedValue() {
                                                const title = row.title.toLowerCase();
                                                const isPercent = title.includes('%') ||
                                                            title.includes('yoy') ||
                                                            title.includes('per');

                                                return formatTableValue(row.values[date]?.value, isPercent)
                                            },
                                        }"
                                    >
                                        <template x-if="formattedValue.isLink">
                                            <button type="button" class="flex gap-0.5 items-center underline" @click="Livewire.emit('modal.open', 'company-report.value-html-modal', { value: formattedValue.result, ticker: $wire.company.ticker })">
                                                <span>Show</span>
                                                <svg data-slot="icon" class="h-2.5 w-2.5" fill="none" stroke-width="2.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                                                </svg>
                                            </button>
                                        </template>

                                        <template x-if="!formattedValue.isLink">
                                            <div>
                                                <x-review-number-button x-data="{ amount: row.values[date]?.value || 0, date }">
                                                    <span class="hover:underline cursor-pointer"
                                                    :class="formattedValue.isNegative ? 'text-red' : ''"
                                                    x-text="formattedValue.result"
                                                    @click="$wire.emit('rightSlide', row.values[date])">
                                                    </span>
                                                </x-review-number-button>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div x-show="showChildren || !row.seg_start" x-cloak>
                            <div x-ref="nestedTable"></div>
                        </div>
                    </div>
                </template>
                `
            nestedTable.innerHTML = template;
            Alpine.initTree(nestedTable);
        }
    </script>
@endpush
