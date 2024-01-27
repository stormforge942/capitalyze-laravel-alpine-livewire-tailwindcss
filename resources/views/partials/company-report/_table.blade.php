<div class="flex flex-col" :class="[rowContext.isBold ? 'font-bold' : '', classes]" x-data="{
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
        if(row.empty) return;

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
}"
    x-init="loadChildren(this, nestingLevel + 1)">
    <div class="flex w-full flex-row"
        :class="[isRowSelectedForChart ? 'bg-[#52D3A2]/20' : (row.segmentation ?
            'bg-[#52C6FF]/10' : 'bg-white'), row.empty ? 'empty-row' + (!showEmptyRows ? ' hidden' : '') : '']">
        <div class="flex justify-end items-center ml-2">
            <input x-show="isRowSelectedForChart" type="checkbox" class="custom-checkbox" :checked="isRowSelectedForChart"
                @change="toggleRowForChart">
        </div>
        <div class="cursor-default py-2  w-[250px] truncate flex flex-row items-center"
            :class="isRowSelectedForChart ? 'ml-2' : 'ml-6'" style="">
            <a href="#" @click.prevent="toggleRowForChart" x-text="rowContext.title"
                class="whitespace-nowrap truncate text-base" :class="rowContext.isBold ? 'font-bold' : ''">
            </a>
        </div>
        <div class="w-full flex flex-row justify-between ">
            <template x-for="date in formattedTableDates" :key="date">
                <div class="w-[150px] flex items-center justify-end text-base last:pr-8" x-data="{
                    get formattedValue() {
                        const title = row.title.toLowerCase();
                        const isPercent = title.includes('%') ||
                            rowContext.title.includes('yoy') ||
                            rowContext.title.includes('per');
                
                        return formatTableValue(row.values[date]?.value, isPercent)
                    },
                }">

                    <template x-if="formattedValue.isLink">
                        <button type="button" class="flex gap-0.5 items-center underline"
                            @click="Livewire.emit('modal.open', 'company-report.value-html-modal', { value: formattedValue.result, ticker: $wire.company.ticker })">
                            <span>Show</span>
                            <svg data-slot="icon" class="h-2.5 w-2.5" fill="none" stroke-width="2.5"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                            </svg>
                        </button>
                    </template>

                    <template x-if="!formattedValue.isLink">
                        <div>
                            <x-review-number-button x-data="{ amount: row.values[date]?.value || 0, date }">
                                <span class="hover:underline cursor-pointer"
                                    :class="formattedValue.isNegative ? 'text-red' : ''" x-text="formattedValue.result"
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
