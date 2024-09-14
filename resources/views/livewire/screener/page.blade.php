<?php
$metrics = App\Services\ChartBuilderService::options();
$flattenedMetrics = App\Services\ChartBuilderService::options(true);
?>

<div x-data="{
    universalCriteria: $wire.entangle('universalCriteria', true),
    financialCriteria: $wire.entangle('financialCriteria', true),
    summaries: @js($summaries),
    init() {
        this.$watch('universalCriteria', (val) => this.updateConfiguration(val, 'universal_criteria'), { deep: true });
    },
    get disabledGetResultButton() {
        return false
    },
    resetUniversalCriteria() {
        this.universalCriteria = {
            locations: { data: [], exclude: false },
            stock_exchanges: { data: [], exclude: false },
            industries: { data: [], exclude: false },
            sectors: { data: [], exclude: false },
            market_cap: [null, null],
        };
    },
    removeFinancialCriteria(id) {
        this.financialCriteria = this.financialCriteria.filter(criteria => criteria.id !== id);
    },
    getResult() {
        console.log('GET RESULT')
    },
    formatTableValue(value, applyUnits) {
        if (value === 'N/A') return value

        const formatted = window.formatNumber(value, {
            unit: 'None',
            decimalPlaces: this.decimal.decimalPlaces
        });

        return value < 0 ? '(' + formatted + ')' : formatted;
    },
    updateConfiguration(val, variable) {
        if (!this.$wire.tab) return;

        window.http(`/screener/${this.$wire.tab.id}/update`, {
            method: 'POST',
            body: {
                [variable]: val
            }
        })
    }
}" wire:key="{{ \Str::random(5) }}" x-cloak>
    <div>
        <h1 class="text-xl font-bold">Screener</h1>
        <p class="mt-2 text-dark-light2">Recent filings of all companies</p>
    </div>

    <div class="mt-8">
        @livewire('screener.screener-tabs')
    </div>

    @if ($tab)
        <div class="mt-6">
            <div>
                <div class="border-2 border-dashed border-green-dark p-6 mt-6 rounded-lg relative bg-white">
                    <div class="flex justify-between mb-6">
                        <div>
                            <h3 class="font-medium">Choose Criteria</h3>
                            <p class="text-sm text-dark-light2">Create your own stock screener with 100+ different
                                screening
                                criteria</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-select :options="$_options['summaries']" :multiple="true" :searchable="false" x-model="summaries">
                                <x-slot name="trigger">
                                    <div class="p-2 flex items-center gap-x-0.5 border border-green-muted rounded text-sm"
                                        :class="showDropdown ? 'bg-[#E2E2E2]' : 'bg-white hover:bg-[#E2E2E2]'">
                                        Add Summary
                                        <span :class="showDropdown ? 'rotate-180' : ''"
                                            class="transition-transform shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16" fill="none">
                                                <path
                                                    d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                                                    fill="#121A0F" />
                                            </svg>
                                        </span>
                                    </div>
                                </x-slot>

                                <x-slot name="bodyHeader">
                                    <div class="flex justify-between gap-2 px-6 pt-6">
                                        <div>
                                            <p class="font-medium text-base">Choose Summary</p>
                                            <p class="mt-2 text-sm text-[#7C8286]">Know the summary statistics of the
                                                chosen tickers</p>
                                        </div>

                                        <button type="button" @click="dropdown.hide()">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                                                    fill="#C22929" />
                                            </svg>
                                        </button>
                                    </div>
                                </x-slot>
                            </x-select>
                            <button
                                class="text-sm font-semibold flex justify-center items-center gap-2 bg-green-light4 px-4 py-2 rounded text-dark">
                                <p>Create Custom Formula</p>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.3345 6.70018H12.2345H11.2992H11.1992V6.60018V5.19088C11.1992 4.84611 11.0623 4.51546 10.8185 4.27167C10.5747 4.02787 10.244 3.89091 9.8992 3.89091H8.41565L9.42952 4.90553L9.50023 4.9763L9.42945 5.04698L8.76676 5.7087L8.69605 5.77931L8.62539 5.70865L6.63828 3.72163L6.60898 3.69234V3.65091V2.9976V2.95617L6.63828 2.92688L8.62633 0.938926L8.69709 0.868171L8.76779 0.938976L9.43048 1.60256L9.50107 1.67325L9.43046 1.74391L8.41658 2.75853H9.90172H9.902V2.85853C10.3641 2.85594 10.8164 2.99147 11.2009 3.24773C11.5854 3.504 11.8845 3.8693 12.0599 4.29677L12.3345 6.70018ZM12.3345 6.70018V6.60018M12.3345 6.70018V6.60018M12.3345 5.19024C12.3364 4.87006 12.2741 4.5528 12.1524 4.2588L12.3345 5.19056C12.3345 5.19045 12.3345 5.19034 12.3345 5.19024ZM12.3345 5.19024V6.60018M12.3345 5.19024V6.60018M4.30116 5.61955L4.30192 5.61924L5.30801 4.66636L5.39103 4.72211C5.39108 4.72204 5.39113 4.72197 5.39118 4.72189C5.65964 4.32205 5.80174 3.85128 5.80003 3.37075C5.80614 3.04483 5.74652 2.72102 5.62473 2.41864C5.50279 2.11591 5.32104 1.84088 5.09035 1.61001L5.09015 1.60982C4.85929 1.38003 4.58471 1.19885 4.28263 1.07699C3.98083 0.955237 3.6577 0.895162 3.33231 0.900304C2.85091 0.899595 2.38019 1.04223 1.98015 1.31005C1.57949 1.57658 1.26734 1.95645 1.08355 2.40117C0.899784 2.84584 0.852674 3.33516 0.948229 3.80671C1.04065 4.27906 1.27093 4.71346 1.61001 5.05507L1.61 5.05508L1.6112 5.05624C1.93249 5.36931 2.33098 5.59085 2.76542 5.69876V10.2882C2.33044 10.3948 1.93093 10.6168 1.61089 10.9313L1.61008 10.9321C1.2704 11.2737 1.04072 11.7077 0.948224 12.1806C0.852859 12.6523 0.900264 13.1418 1.08439 13.5865C1.26851 14.0311 1.58099 14.4109 1.98193 14.6771C2.38144 14.9444 2.85156 15.0864 3.33219 15.0851C3.81919 15.0945 4.29771 14.9567 4.70514 14.6898C5.11278 14.4226 5.43023 14.0386 5.61594 13.5881C5.74528 13.2806 5.80858 12.9489 5.80096 12.6152C5.80073 12.1357 5.65863 11.6661 5.39324 11.2656L5.39298 11.2652C5.05145 10.7551 4.53098 10.3931 3.93611 10.2496V5.73292C3.96172 5.72608 3.99227 5.71778 4.02512 5.70854C4.11457 5.68338 4.22635 5.64988 4.30116 5.61955ZM4.03583 11.5485C4.23777 11.6694 4.40312 11.8428 4.51422 12.0503C4.62519 12.2577 4.67821 12.4913 4.66772 12.7263C4.6555 12.9606 4.58174 13.1893 4.45213 13.3847C4.30625 13.5999 4.10154 13.7691 3.86235 13.8707C3.62475 13.9658 3.36675 13.9899 3.11757 13.9397L3.11693 13.9396C2.86422 13.8904 2.63193 13.7669 2.44981 13.585C2.26769 13.403 2.14401 13.1708 2.0946 12.9182L2.0945 12.9176C2.05659 12.7293 2.06104 12.5349 2.10754 12.3485C2.15403 12.1622 2.24141 11.9884 2.36333 11.84C2.48525 11.6915 2.63867 11.5721 2.81247 11.4902C2.98627 11.4084 3.17609 11.3662 3.3682 11.3668L3.36975 11.3667C3.60423 11.3638 3.83483 11.4267 4.03534 11.5483L4.03583 11.5485ZM3.11612 2.05135L3.11612 2.05135L3.11688 2.0512C3.36637 2.00029 3.62534 2.02431 3.8612 2.12023C4.10062 2.22188 4.30551 2.39063 4.45114 2.60614C4.58103 2.80221 4.65583 3.02959 4.66771 3.26448C4.67751 3.49942 4.62404 3.73268 4.51288 3.93989C4.40176 4.14703 4.23707 4.32054 4.03602 4.44231C3.83447 4.56031 3.60288 4.62516 3.3685 4.62516C3.11451 4.62516 2.86392 4.54832 2.64916 4.40854C2.43413 4.26268 2.26511 4.05807 2.16357 3.81903C2.06839 3.58144 2.04431 3.32345 2.0945 3.07427L2.09461 3.07368C2.14391 2.82102 2.26744 2.58879 2.4494 2.40669C2.63136 2.22458 2.86349 2.10086 3.11612 2.05135ZM12.1999 15.1H12.2999V15V12.3001H15H15.1V12.2001V11.2667V11.1667H15H12.2999V8.46681V8.36681H12.1999H11.2666H11.1666V8.46681V11.1667H8.4665H8.3665V11.2667V12.2001V12.3001H8.4665H11.1666V15V15.1H11.2666H12.1999Z"
                                        fill="black" stroke="black" stroke-width="0.2" />
                                </svg>
                            </button>
                            <button
                                class="text-sm font-semibold flex justify-center items-center gap-2 bg-dark-light2 px-4 py-2 rounded text-white">
                                <p>Collapse</p>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.6667 7.3334H8.66667V2.33339L10.6953 4.36198L12.8619 2.19531L13.8047 3.13812L11.6381 5.30479L13.6667 7.3334ZM2.33339 8.66667H7.3334V13.6667L5.30479 11.6381L3.13812 13.8047L2.19531 12.8619L4.36198 10.6953L2.33339 8.66667Z"
                                        fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="max-w-[1230px] w-full">
                        <h4 class="text-blue font-medium text-sm mb-2">Universe Criteria</h4>
                        <div class="flex border rounded-lg py-3">
                            <div
                                class="flex children-border-right flex-wrap gap-y-3 w-full overflow-x-clip overflow-y-visible">
                                <div class="px-4 flex-none">
                                    <x-criteria-selector :options="$options['country']" placeholder="Location"
                                        x-model="universalCriteria.locations"></x-criteria-selector>
                                </div>
                                <div class="px-4 flex-none">
                                    <x-criteria-selector :options="$options['exchange']" placeholder="Stock Exchange"
                                        x-model="universalCriteria.stock_exchanges"></x-criteria-selector>
                                </div>
                                <div class="px-4 flex-none">
                                    <x-criteria-selector :options="$options['sic_group']" placeholder="Industry"
                                        x-model="universalCriteria.industries"></x-criteria-selector>
                                </div>
                                <div class="px-4 flex-none">
                                    <x-criteria-selector :options="$options['sic_description']" placeholder="Sector"
                                        x-model="universalCriteria.sectors"></x-criteria-selector>
                                </div>
                                <div class="px-4 flex-none">
                                    @include('livewire.screener.select-market-cap')
                                </div>
                            </div>
                            <button @click="resetUniversalCriteria()"
                                class="ml-auto text-red text-sm px-4 mr-1 font-medium hover:underline">Reset</button>
                        </div>
                    </div>
                    <div class="my-6">
                        <h4 class="text-blue font-medium text-sm mb-2">Financial Criteria</h4>
                        <div class="space-y-4" x-data="{
                            get criterias() {
                                if (!this.financialCriteria.length) this.add(false);

                                return this.financialCriteria;
                            },
                            add(save = true) {
                                this.financialCriteria.push({
                                    id: Math.random().toString(36).substring(7),
                                    metric: null,
                                    type: 'value',
                                    period: 'annual',
                                    dates: [],
                                    operator: null,
                                    value: null,
                                });
                        
                                if (save) {
                                    this.updateConfiguration(this.financialCriteria, 'financial_criteria');
                                }
                            }
                        }">
                            <template x-for="(criteria, index) in criterias" :key="criteria.id">
                                <div class="flex items-center gap-x-4">
                                    @include('livewire.screener.financial-criteria')

                                    <template x-if="criterias.length === (index + 1)">
                                        <button type="button" @click="add"
                                            class="flex items-center justify-center gap-2 h-full bg-dark rounded-lg p-4 hover:bg-opacity-80 transition-all">
                                            <p class="text-green-dark font-bold">Add Criteria</p>
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10C20 15.5228 15.5228 20 10 20ZM9 9H5V11H9V15H11V11H15V9H11V5H9V9Z"
                                                    fill="#52D3A2" />
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div>
                        <button :disabled="disabledGetResultButton" @click="getResult()"
                            class="absolute left-1/2 transform -translate-x-1/2 -bottom-6 px-10 py-3 rounded-lg bg-dark hover:bg-dark-light2 font-bold text-white flex justify-between items-center gap-2 disabled:bg-[#EDEDED] disabled:text-dark-lighter transition-all">
                            <span>Get Result</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.33594 0.332031C9.64794 0.332031 12.3359 3.02003 12.3359 6.33203C12.3359 9.64403 9.64794 12.332 6.33594 12.332C3.02394 12.332 0.335938 9.64403 0.335938 6.33203C0.335938 3.02003 3.02394 0.332031 6.33594 0.332031ZM6.33594 10.9987C8.91427 10.9987 11.0026 8.91036 11.0026 6.33203C11.0026 3.7537 8.91427 1.66536 6.33594 1.66536C3.7576 1.66536 1.66927 3.7537 1.66927 6.33203C1.66927 8.91036 3.7576 10.9987 6.33594 10.9987ZM11.9928 11.0461L13.8784 12.9317L12.9356 13.8745L11.05 11.9889L11.9928 11.0461Z"
                                    :fill="disabledGetResultButton ? '#9DA3A8' : '#DCF6EC'" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="mt-10">
            <x-primary-tabs :tabs="$tabs" :active="$activeTab" @tab-changed="onTabSelect($event.detail.key)"
            min-width="160px" />
        </div>
        <div class="mt-12">
            <div class="mt-12 overflow-x-auto" wire:loading.class="pointer-events-none animate-pulse">
                <table>
                    <tr class="font-bold whitespace-nowrap bg-[#EDEDED]">
                        @foreach ($tableColumns as $column)
                            <td wire:key="{{ uniqid() }}" class="py-3 pl-6 [&:nth-child(n+3)]:text-right last:pr-6">
                                <span class="text-center inline-block" x-data="{ lines: '{{ $column['label'] }}'.split('\n') }">
                                    <template x-for="line in lines" :key="line">
                                        <span>
                                            <span x-text="line"></span>
                                            <br>
                                        </span>
                                    </template>
                                </span>
                            </td>
                        @endforeach
                    </tr>
    
                    @if (count($summaryRows) > 0 && $summaryPlacement === 'top')
                        <tr class="bg-white border-y-2 border-gray-light font-semibold">
                            <td class="py-3 pl-6" :colspan="$wire.tableColumns.length + 2">
                                <div class="flex gap-6 items-center">
                                    <span class="text-blue font-semibold text-sm+">
                                        Summary Statistics of generated table
                                    </span>
                                    <button wire:click="$set('summaryPlacement', 'bottom')"
                                        class="flex gap-4 items-center bg-green-light px-2 py-1 hover:bg-opacity-80 transition-all">
                                        <span class="text-sm font-semibold">Move summary to bottom</span>
                                        <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.57 0.332031H5.4248C4.0822 0.332031 3.36222 0.517685 2.71037 0.866298C2.05852 1.21491 1.54694 1.72649 1.19833 2.37834C0.849716 3.03019 0.664062 3.75017 0.664062 5.09277V8.90463C0.664062 10.2472 0.849716 10.9672 1.19833 11.619C1.54694 12.2709 2.05852 12.7825 2.71037 13.1311C3.36222 13.4797 4.0822 13.6654 5.4248 13.6654H6.57C7.9126 13.6654 8.6326 13.4797 9.2844 13.1311C9.93626 12.7825 10.4479 12.2709 10.7965 11.619C11.1451 10.9672 11.3307 10.2472 11.3307 8.90463V5.09277C11.3307 3.75017 11.1451 3.03019 10.7965 2.37834C10.4479 1.72649 9.93626 1.21491 9.2844 0.866298C8.6326 0.517685 7.9126 0.332031 6.57 0.332031ZM5.33073 6.33203V2.9987H6.66406V6.33203H5.33073ZM3.16927 8.1707L4.11208 7.2279L5.99773 9.1135L7.88333 7.2279L8.82613 8.1707L5.99773 10.9991L3.16927 8.1707Z"
                                                fill="#121A0F" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @foreach ($summaryRows as $summaryRow)
                            <tr wire:key="{{ uniqid() }}"
                                class="border-y-2 border-gray-light font-semibold summary-row"
                                style="background: rgba(82, 198, 255, 0.10)">
                                <td class="py-3 pl-6">{{ $summaryRow['title'] }}</td>
    
                                <td></td>
                                @foreach ($summaryRow['columns'] as $summaryRowColumn)
                                    <td wire:key="{{ uniqid() }}"
                                        class="py-3 pl-6 [&:nth-child(n+3)]:text-right last:pr-6">
                                        <span class="cursor-text" x-data>
                                            <span x-text="formatTableValue({{ $summaryRowColumn }}, true)"></span>
                                        </span>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
    
                    @foreach ($tableRows as $row)
                        <tr wire:key="{{ uniqid() }}"
                            class="bg-white border-y-2 border-gray-light font-semibold cursor-pointer data-row">
                            @foreach ($tableColumns as $column)
                                <td class="py-3 pl-6 [&:nth-child(n+3)]:text-right last:pr-6">
                                    <span class="cursor-text" x-data>
                                        <span x-text="formatTableValue('{{ $row[$column['key']] }}', false)"></span>
                                    </span>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
    
                    @if (count($summaryRows) > 0 && $summaryPlacement === 'bottom')
                        @foreach ($summaryRows as $summaryRow)
                            <tr wire:key="{{ uniqid() }}"
                                class="border-y-2 border-gray-light font-semibold summary-row"
                                style="background: rgba(82, 198, 255, 0.10)">
                                <td class="py-3 pl-6">{{ $summaryRow['title'] }}</td>
    
                                <td></td>
                                @foreach ($summaryRow['columns'] as $summaryRowColumn)
                                    <td wire:key="{{ uniqid() }}"
                                        class="py-3 pl-6 [&:nth-child(n+3)]:text-right last:pr-6">
                                        <span class="cursor-text" x-data>
                                            <span x-text="formatTableValue({{ $summaryRowColumn }}, true)"></span>
                                        </span>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="bg-white border-y-2 border-gray-light font-semibold">
                            <td class="py-3 pl-6" :colspan="$wire.tableColumns.length + 2">
                                <div class="flex gap-6 items-center">
                                    <span class="text-blue font-semibold text-sm+">
                                        Summary Statistics of generated table
                                    </span>
                                    <button wire:click="$set('summaryPlacement', 'top')"
                                        class="flex gap-4 items-center bg-green-light px-2 py-1 hover:bg-opacity-80 transition-all">
                                        <span class="text-sm font-semibold">Move summary to top</span>
                                        <svg class="rotate-180" width="12" height="14" viewBox="0 0 12 14"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.57 0.332031H5.4248C4.0822 0.332031 3.36222 0.517685 2.71037 0.866298C2.05852 1.21491 1.54694 1.72649 1.19833 2.37834C0.849716 3.03019 0.664062 3.75017 0.664062 5.09277V8.90463C0.664062 10.2472 0.849716 10.9672 1.19833 11.619C1.54694 12.2709 2.05852 12.7825 2.71037 13.1311C3.36222 13.4797 4.0822 13.6654 5.4248 13.6654H6.57C7.9126 13.6654 8.6326 13.4797 9.2844 13.1311C9.93626 12.7825 10.4479 12.2709 10.7965 11.619C11.1451 10.9672 11.3307 10.2472 11.3307 8.90463V5.09277C11.3307 3.75017 11.1451 3.03019 10.7965 2.37834C10.4479 1.72649 9.93626 1.21491 9.2844 0.866298C8.6326 0.517685 7.9126 0.332031 6.57 0.332031ZM5.33073 6.33203V2.9987H6.66406V6.33203H5.33073ZM3.16927 8.1707L4.11208 7.2279L5.99773 9.1135L7.88333 7.2279L8.82613 8.1707L5.99773 10.9991L3.16927 8.1707Z"
                                                fill="#121A0F" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
            <div
                class="flex justify-end items-center bg-white border-y-2 border-gray-light font-semibold cursor-pointer data-row py-4 px-6">
                <div class="flex items-center gap-4">
                    <div>
                        <p wire:ignore.self>
                            Showing:
                            <span class="font-semibold">{{ $page * $pageSize - $pageSize + 1 }}</span>
                            <span>to {{ $page < $totalPageCount ? $page * $pageSize : $totalRecordCount }}</span>
                            <span> of </span>
                            <span class="font-semibold">{{ $totalRecordCount }}</span>
                            Results
                        </p>
                    </div>
                    @if ($totalPageCount > 1)
                        <nav class="items-center justify-between sm:flex" x-data="{ pagesCount: @entangle('totalPageCount'), currentPage: $wire.entangle('page') }" wire:ignore>
                            <template x-if="currentPage > 1">
                                <div class="flex">
                                    <a @click="$wire.goToPage(1)"
                                        class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true" data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 S12l7.5 7.5"></path>
                                        </svg>
                                    </a>
                                    <a @click="$wire.prevPage()"
                                        class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true" data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                                        </svg>
                                    </a>
                                </div>
                            </template>
                            <template x-if="Math.abs(currentPage) > 3">
                                <div class="mx-1 mt-1 text-pg-primary-600 dark:text-pg-primary-300">
                                    <span>.</span>
                                    <span>.</span>
                                    <span>.</span>
                                </div>
                            </template>
                            <template x-for="pageNum in pagesCount">
                                <template x-if="Math.abs(currentPage - pageNum) < 3">
                                    <a @click="$wire.goToPage(pageNum)"
                                        :class="currentPage === pageNum ? 'text-blue pointer-events-none' : 'text-dark'"
                                        class="min-w-[35px] px-2 py-1 m-1 text-center bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300"
                                        x-text="pageNum"></a>
                                </template>
                            </template>
                            <template x-if="Math.abs(pagesCount - currentPage) > 2">
                                <div class="mx-1 mt-1 text-pg-primary-600 dark:text-pg-primary-300">
                                    <span>.</span>
                                    <span>.</span>
                                    <span>.</span>
                                </div>
                            </template>
                            <template x-if="currentPage < pagesCount">
                                <div class="flex">
                                    <a @click="$wire.nextPage()"
                                        class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true" data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                                        </svg>
                                    </a>
                                    <a @click="$wire.goToPage(pagesCount)"
                                        class="p-2 m-1 text-center text-dark bg-gray-100 rounded cursor-pointer border-1 hover:bg-gray-200 dark:text-pg-primary-300">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true" data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5"></path>
                                        </svg>
                                    </a>
                                </div>
                            </template>
                        </nav>
                    @endif
                </div>
    
            </div>
        </div>

        @if (!count($tableRows))
            <div class="mt-24 flex flex-col items-center">
                <svg width="168" height="164" viewBox="0 0 168 164" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_9710_178945)">
                        <path
                            d="M106.655 36.8798H61.3859C60.3543 36.881 59.3653 37.2914 58.6359 38.0209C57.9064 38.7504 57.4961 39.7394 57.4948 40.7711V141.388L56.976 141.546L45.8709 144.947C45.3446 145.108 44.7761 145.053 44.2903 144.795C43.8044 144.536 43.4409 144.096 43.2795 143.57L10.2468 35.6631C10.086 35.1367 10.1408 34.5681 10.3991 34.0821C10.6574 33.5962 11.0981 33.2326 11.6243 33.0714L28.7373 27.8311L78.3484 12.6445L95.4613 7.40419C95.7217 7.32404 95.9954 7.29603 96.2667 7.32177C96.5379 7.34751 96.8015 7.42649 97.0422 7.5542C97.2829 7.68191 97.496 7.85583 97.6695 8.06602C97.8429 8.27621 97.9731 8.51854 98.0528 8.77913L106.496 36.3609L106.655 36.8798Z"
                            fill="#F5F5F5" />
                        <path
                            d="M116.53 36.3621L106.353 3.11973C106.184 2.56585 105.907 2.05076 105.539 1.6039C105.171 1.15704 104.718 0.787167 104.206 0.515411C103.695 0.243655 103.135 0.0753432 102.558 0.0200995C101.982 -0.0351441 101.4 0.0237631 100.846 0.193449L76.7865 7.55845L27.178 22.7476L3.11821 30.1152C2.00052 30.4584 1.06466 31.2311 0.516056 32.2637C-0.0325492 33.2963 -0.149081 34.5044 0.192045 35.6228L34.9731 149.232C35.2502 150.134 35.8093 150.925 36.5685 151.486C37.3276 152.048 38.2468 152.352 39.1911 152.352C39.6281 152.353 40.0627 152.287 40.4802 152.158L56.9732 147.109L57.492 146.949V146.406L56.9732 146.565L40.3272 151.662C39.3407 151.963 38.2751 151.86 37.3642 151.376C36.4534 150.892 35.7717 150.067 35.4686 149.081L0.690209 35.4697C0.540037 34.9812 0.487698 34.4678 0.536187 33.9591C0.584677 33.4503 0.733038 32.9561 0.972785 32.5047C1.21253 32.0534 1.53896 31.6538 1.93335 31.3288C2.32775 31.0038 2.78238 30.7598 3.27121 30.6107L27.331 23.2431L76.9397 8.05654L100.999 0.68895C101.37 0.57579 101.756 0.518092 102.143 0.517731C102.975 0.519599 103.785 0.78783 104.453 1.28314C105.122 1.77844 105.614 2.4748 105.858 3.2702L115.988 36.3621L116.149 36.881H116.688L116.53 36.3621Z"
                            fill="#464E49" />
                        <path
                            d="M31.8258 33.1568C31.3259 33.1565 30.8391 32.9959 30.4371 32.6986C30.0351 32.4014 29.7389 31.9831 29.592 31.5052L26.2508 20.5908C26.161 20.2976 26.1298 19.9896 26.1591 19.6844C26.1883 19.3792 26.2774 19.0827 26.4213 18.8119C26.5651 18.5412 26.7609 18.3014 26.9974 18.1063C27.2339 17.9112 27.5066 17.7646 27.7997 17.6748L73.4392 3.70137C74.0312 3.52069 74.6708 3.58231 75.2175 3.87271C75.7641 4.1631 76.1733 4.65855 76.3551 5.2503L79.6963 16.1648C79.8769 16.7569 79.8152 17.3964 79.5248 17.9431C79.2345 18.4898 78.7391 18.899 78.1475 19.0809L32.5079 33.0543C32.2869 33.1222 32.057 33.1567 31.8258 33.1568Z"
                            fill="#52D3A2" />
                        <path
                            d="M49.3287 11.664C52.194 11.664 54.5168 9.34105 54.5168 6.47556C54.5168 3.61006 52.194 1.28711 49.3287 1.28711C46.4634 1.28711 44.1406 3.61006 44.1406 6.47556C44.1406 9.34105 46.4634 11.664 49.3287 11.664Z"
                            fill="#52D3A2" />
                        <path
                            d="M49.3243 9.75847C51.1387 9.75847 52.6096 8.28751 52.6096 6.47298C52.6096 4.65846 51.1387 3.1875 49.3243 3.1875C47.5099 3.1875 46.0391 4.65846 46.0391 6.47298C46.0391 8.28751 47.5099 9.75847 49.3243 9.75847Z"
                            fill="white" />
                        <path
                            d="M156.329 151.025H68.6503C68.0657 151.024 67.5052 150.792 67.0919 150.378C66.6785 149.965 66.446 149.405 66.4453 148.82V43.7539C66.446 43.1693 66.6785 42.6088 67.0918 42.1954C67.5052 41.782 68.0657 41.5495 68.6503 41.5488H156.329C156.914 41.5495 157.474 41.782 157.887 42.1954C158.301 42.6088 158.533 43.1693 158.534 43.7539V148.82C158.533 149.405 158.301 149.965 157.887 150.378C157.474 150.792 156.914 151.024 156.329 151.025Z"
                            fill="#D4DDD7" />
                        <path
                            d="M115.991 36.3574H61.3864C60.2174 36.3591 59.0967 36.8243 58.27 37.651C57.4434 38.4777 56.9782 39.5985 56.9766 40.7676V146.56L57.4954 146.402V40.7676C57.4966 39.7359 57.907 38.7469 58.6364 38.0174C59.3659 37.2879 60.3549 36.8775 61.3864 36.8763H116.152L115.991 36.3574ZM163.592 36.3574H61.3864C60.2174 36.3591 59.0967 36.8243 58.27 37.651C57.4434 38.4777 56.9782 39.5985 56.9766 40.7676V159.583C56.9782 160.752 57.4434 161.873 58.27 162.7C59.0967 163.526 60.2174 163.992 61.3864 163.993H163.592C164.761 163.992 165.882 163.526 166.708 162.7C167.535 161.873 168 160.752 168.002 159.583V40.7676C168 39.5985 167.535 38.4777 166.708 37.651C165.882 36.8243 164.761 36.3591 163.592 36.3574ZM167.483 159.583C167.482 160.615 167.071 161.604 166.342 162.333C165.613 163.063 164.624 163.473 163.592 163.474H61.3864C60.3549 163.473 59.3659 163.063 58.6364 162.333C57.907 161.604 57.4966 160.615 57.4954 159.583V40.7676C57.4966 39.7359 57.907 38.7469 58.6364 38.0174C59.3659 37.2879 60.3549 36.8775 61.3864 36.8763H163.592C164.624 36.8775 165.613 37.2879 166.342 38.0174C167.071 38.7469 167.482 39.7359 167.483 40.7676V159.583Z"
                            fill="#464E49" />
                        <path
                            d="M136.354 47.7795H88.6237C88.0047 47.7788 87.4113 47.5326 86.9736 47.0949C86.5359 46.6572 86.2898 46.0637 86.2891 45.4447V34.0301C86.2898 33.4111 86.536 32.8176 86.9736 32.3799C87.4113 31.9422 88.0047 31.696 88.6237 31.6953H136.354C136.973 31.696 137.567 31.9422 138.004 32.3799C138.442 32.8176 138.688 33.4111 138.689 34.0301V45.4447C138.688 46.0637 138.442 46.6572 138.004 47.0949C137.567 47.5326 136.973 47.7788 136.354 47.7795Z"
                            fill="#52D3A2" />
                        <path
                            d="M112.485 32.4667C115.35 32.4667 117.673 30.1438 117.673 27.2783C117.673 24.4128 115.35 22.0898 112.485 22.0898C109.62 22.0898 107.297 24.4128 107.297 27.2783C107.297 30.1438 109.62 32.4667 112.485 32.4667Z"
                            fill="#52D3A2" />
                        <path
                            d="M112.488 30.4416C114.233 30.4416 115.648 29.0267 115.648 27.2813C115.648 25.536 114.233 24.1211 112.488 24.1211C110.743 24.1211 109.328 25.536 109.328 27.2813C109.328 29.0267 110.743 30.4416 112.488 30.4416Z"
                            fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_9710_178945">
                            <rect width="168" height="164" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <p class="mt-6 font-bold text-xl">No Data</p>
                <p class="mt-2">There are no available data at the moment.</p>
            </div>
        @endif
        </div> --}}
    @else
        <div class="py-10 grid place-items-center">
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
    @endif
</div>
