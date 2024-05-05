<div>
    <div>
        <h1 class="text-xl font-bold">Table</h1>
        <p class="mt-2 text-dark-light2">Build custom table to visualize financial data across companies</p>
    </div>

    <div class="mt-8">
        @livewire('builder.table-tabs')
    </div>

    @if ($tab)
        <div class="mt-6 relative" x-data="{
            summaries: [],
            tableData: [],
            columns: [],
            init() {
                this.makeTableData($wire.data)
            },
            makeTableData(data) {
                const years = [
                    {{-- 'FY 2018',
                    'FY 2019',
                    'FY 2020',
                    'FY 2021', --}} 'FY 2022',
                    'FY 2023',
                ];
        
                this.columns = [];
        
                $wire.metrics.forEach(metric => {
                    label = metric.split('||')[1]
        
                    years.forEach(year => {
                        this.columns.push({
                            label: `${label} (${year})`,
                            metric: metric,
                            year: year,
                        })
                    })
                })
        
                $wire.companies.forEach(company => {
                    let d = {};
        
                    this.columns.forEach(column => {
                        d[column.label] = data.data.annual[company]?.[column.metric]?.[column.year] || null;
                    })
        
                    const row = {
                        ticker: company,
                        name: company,
                        sector: '-',
                        marketCap: '-',
                        stockPrice: '-',
                        totalReturn: '-',
                        totalRevenue: '-',
                        columns: d,
                        notes: null,
                    };
        
                    this.tableData.push(row);
                })
        
                console.log(this.tableData)
            },
        }" wire:key="{{ \Str::random(5) }}"
            wire:loading.class="pointer-events-none animate-pulse">
            <div class="cus-loader" wire:loading.block>
                <div class="cus-loaderBar"></div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-2 whitespace-nowrap">
                <div class="bg-white p-2 rounded-t">
                    <livewire:builder.table.select-company :selected="$companies" :wire:key="Str::random(5)" />
                </div>
                <div class="bg-white p-2 rounded-t">
                    <livewire:builder.table.select-metrics :companies="$companies" :selected="$metrics"
                        :wire:key="Str::random(5)" />
                </div>
                <div class="bg-white p-2 rounded-t">
                    @include('livewire.builder.table.select-summary')
                </div>
            </div>
            <div class="mt-0.5 overflow-x-auto rounded-b-lg">
                <table class="overflow-hidden">
                    <tr class="font-bold whitespace-nowrap bg-[#EDEDED]">
                        <td class="py-3 pl-8">Ticker</td>
                        <template x-for="column in columns" :key="column.label">
                            <td class="py-3 pl-6" x-text="column.label">
                            </td>
                        </template>
                        <td class="py-3 pl-6 pr-8">Notes</td>
                    </tr>
                    <template x-for="(row, idx) in tableData" :key="idx">
                        <tr class="bg-white border-y-2 border-gray-light font-semibold">
                            <td class="py-4 pl-8" x-text="row.ticker"></td>
                            <template x-for="column in columns" :key="column.label">
                                <td class="py-3 pl-6" :class="row.columns[column.label]?.value < 0 ? 'text-red' : ''"
                                    x-text="row.columns[column.label]?.formatted || '-'">
                                </td>
                            </template>
                            <td class="py-4 pl-6 pr-8">
                                <button
                                    class="bg-[#EDEDED] hover:bg-gray-medium px-2 py-1 rounded-sm font-medium text-xs text-dark-light2 whitespace-nowrap"
                                    x-text="edit ? 'Save' : 'Add Note'">
                                </button>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>
        </div>
    @else
        <div class="py-10 grid place-items-center">
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
    @endif
</div>
