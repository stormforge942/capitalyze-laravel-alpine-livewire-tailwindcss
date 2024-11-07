<?php
$metrics = App\Services\ScreenerTableBuilderService::options();
$flattenedMetrics = App\Services\ScreenerTableBuilderService::options(true);
?>

<div x-cloak>
    <div>
        <h1 class="text-xl font-bold">Screener</h1>
        <p class="mt-2 text-dark-light2">Recent filings of all companies</p>
    </div>

    <div class="mt-8">
        @livewire('screener.screener-tabs')
    </div>

    @if ($tab)
        <div class="mt-6" x-data="{
            universalCriteria: $wire.entangle('universalCriteria', true),
            financialCriteria: $wire.entangle('financialCriteria', true),
            summaries: $wire.entangle('summaries'),
            criteriaResultCount: {},
            get universalResultCount() {
                if (!this.criteriaResultCount.hasOwnProperty('universal')) {
                    return 'empty';
                }
        
                return this.criteriaResultCount.universal.toLocaleString() + ' Results';
            },
            get disabledGetResultButton() {
                console.log(this.universalCriteria)
                const uCount = Object.values(this.universalCriteria).filter(c => (c.data || []).length || c.displayOnly).length;
        
                const fCount = this.financialCriteria.filter(c => {
                    let condition = c.metric && c.type && c.period && c.dates.length && c.operator
        
                    if (c.operator === 'display') {
                        return condition;
                    }
        
                    if (c.operator === 'between') {
                        return condition && c.value && c.value[0] && c.value[1];
                    }
        
                    return condition && c.value;
                }).length;

                console.log(uCount, fCount)
        
                return (uCount + fCount) < 1;
            },
            init() {
                this.refreshCriteriaResultCount();
            },
            resetUniversalCriteria() {
                this.universalCriteria = {
                    locations: { data: [], exclude: false },
                    stock_exchanges: { data: [], exclude: false },
                    industries: { data: [], exclude: false },
                    sectors: { data: [], exclude: false },
                    market_cap: null,
                };
            },
            removeFinancialCriteria(id) {
                this.financialCriteria = this.financialCriteria.filter(criteria => criteria.id !== id);
            },
            getResult() {
                $wire.generateResult()
            },
            formatTableValue(value, applyUnits) {
                if (value === 'N/A') return value
        
                const formatted = window.formatNumber(value, {
                    unit: 'None',
                    decimalPlaces: this.decimal.decimalPlaces
                });
        
                return value < 0 ? '(' + formatted + ')' : formatted;
            },
            refreshCriteriaResultCount() {
                const tabCriterias = @js($tabCriterias ?? ['key' => 'value']);
        
                const uLength = Object.values(tabCriterias.universal).filter(c => (c.data || []).length).length;
                const fLength = tabCriterias.financial.filter(c => c.operator !== 'display').length;
        
                if (!(uLength + fLength)) {
                    this.criteriaResultCount = {};
                    return;
                };
        
                window.http('{{ route('screener.criteria-result-count') }}', {
                        method: 'POST',
                        body: tabCriterias
                    }).then(res => res.json())
                    .then(data => this.criteriaResultCount = data);
            }
        
        }" wire:key="{{ \Str::random(5) }}">
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
                        {{-- <button
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
                        </button> --}}
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
                        <div class="ml-auto flex items-center children-border-right">
                            <div class="pr-4" x-show="universalResultCount !== 'empty'" x-cloak>
                                <span
                                    class="bg-blue font-medium text-white rounded-xl py-0.5 px-1.5 whitespace-nowrap text-sm"
                                    x-text="universalResultCount">
                                </span>
                            </div>

                            <button @click="resetUniversalCriteria()"
                                class="text-red text-sm px-4 mr-1 font-medium hover:underline">Reset</button>
                        </div>
                    </div>
                </div>
                <div class="my-6">
                    <h4 class="text-blue font-medium text-sm mb-2">Financial Criteria</h4>
                    <div class="space-y-4" x-data="{
                        get criterias() {
                            if (!this.financialCriteria.length) this.add();
                    
                            return this.financialCriteria;
                        },
                        add() {
                            this.financialCriteria.push({
                                id: Math.random().toString(36).substring(7),
                                metric: null,
                                type: 'value',
                                period: 'annual',
                                dates: [],
                                operator: null,
                                value: null,
                            });
                        }
                    }" wire:ignore>
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
                <div class="inline-block absolute left-1/2 transform -translate-x-1/2 -bottom-6 bg-gray-light">
                    <button @click="getResult"
                        class="px-10 py-3 rounded-lg bg-dark hover:bg-dark-light2 font-bold text-white flex justify-between items-center gap-2 disabled:bg-opacity-70 disabled:cursor-not-allowed disabled:bg-dark"
                        wire:loading.attr="disabled" :disabled="disabledGetResultButton">
                        <span>Get Result</span>
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.33594 0.332031C9.64794 0.332031 12.3359 3.02003 12.3359 6.33203C12.3359 9.64403 9.64794 12.332 6.33594 12.332C3.02394 12.332 0.335938 9.64403 0.335938 6.33203C0.335938 3.02003 3.02394 0.332031 6.33594 0.332031ZM6.33594 10.9987C8.91427 10.9987 11.0026 8.91036 11.0026 6.33203C11.0026 3.7537 8.91427 1.66536 6.33594 1.66536C3.7576 1.66536 1.66927 3.7537 1.66927 6.33203C1.66927 8.91036 3.7576 10.9987 6.33594 10.9987ZM11.9928 11.0461L13.8784 12.9317L12.9356 13.8745L11.05 11.9889L11.9928 11.0461Z"
                                fill="#DCF6EC" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-11">
            <livewire:screener.table-view-control :tab="$tab" :wire:key="'view-control' . $tab['id']" />

            <livewire:screener.table :universal="$tabCriterias['universal']" :financial="$tabCriterias['financial']" :summaries="$summaries" :view="$view"
                :wire:key="'table' . $tab['id']" />
        </div>
    @else
        <div class="py-10 grid place-items-center">
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>
    @endif
</div>
