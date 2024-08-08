<div x-data="{
    currentChartPeriod: $wire.entangle('currentChartPeriod'),
    chartData: $wire.entangle('chartData').defer,
    showDropdown: false,
    chart: null,
    init() {
        this.$watch('currentChartPeriod', value => {
            this.showDropdown = false
        });
        this.$watch('chartData', value => {
            this.renderChart();
        });

        this.renderChart();
    },
    renderChart() {
        this.chart?.destroy();
        this.chart = window.investorFundPage.renderOverviewChart(this.$refs.canvas, this.chartData);
    },
}" id="livewireComponent">
    <div class="bg-white px-4 py-6 md:px-6 rounded-lg relative" x-transition>
        <div class="flex items-center gap-x-5">
            <div>
                <b class="font-extrabold">{{ $name }} ({{ $ticker }})</b><br>
                <small class="text-sm {{ $percentage >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                    {{ $percentage }}% price return over {{ $chartPeriods[$currentChartPeriod] }}
                </small>
            </div>

            <div class="flex-1 flex justify-end xl:justify-center">
                <div class="hidden xl:block">
                    @include('livewire.investor-fund.overview-graph-filters')
                </div>

                <x-dropdown placement="bottom-end" class="block xl:hidden" x-model="showDropdown">
                    <x-slot name="trigger">
                        <div
                            class="p-2 mr-5 flex items-center gap-x-2 border border-[#ECE9F1] text-[#686868] text-sm rounded">
                            <span
                                class="capitalize whitespace-nowrap">{{ $chartPeriods[$currentChartPeriod] ?? 'N/A' }}</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.99479 9.33366L5.32812 6.66699H10.6615L7.99479 9.33366Z" fill="black" />
                            </svg>
                        </div>
                    </x-slot>

                    <div class="p-4">
                        @include('livewire.investor-fund.overview-graph-filters')
                    </div>
                </x-dropdown>
            </div>
        </div>

        <div class="mt-3 place-items-center h-[300px]" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div class="mt-3 h-[300px]" wire:loading.remove>
            <canvas x-ref="canvas"></canvas>
        </div>
    </div>
</div>
