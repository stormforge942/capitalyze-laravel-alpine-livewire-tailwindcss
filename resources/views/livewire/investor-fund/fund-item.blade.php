<div x-data="{
    chart: null,
    chartData: @js($chartData),
    priceChange: @js($priceChange),
    init() {
        this.renderChart();
    },
    renderChart() {
        this.chart?.destroy();
        this.chart = window.investorFundPage.renderInvestorChart(this.$refs.canvas, this.chartData);
    },
}">
    <div class="bg-white px-4 py-6 md:px-6 rounded-lg relative" x-transition>
        <div>
            <div class="flex flex-row items-center gap-x-1">
                <div class="text-md font-extrabold">{{ $fund['name'] }}</div>
                <div class="flex flex-row items-center gap-x-1" :class="priceChange >= 0 ? 'text-green' : 'text-red'">
                    <span><b x-text="priceChange"></b> <small>USD</small></span>
                    <img src="{{ asset('svg/increase-icon.svg') }}" x-show="priceChange > 0" />
                    <img src="{{ asset('svg/decrease-icon.svg') }}" x-show="priceChange < 0" class="rotate-180" />
                </div>
            </div>
            <small class="text-sm {{ $percentage >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                {{ $percentage }}% price return over current year
            </small>
        </div>

        <div class="text-blue text-sm">
            {{ array_key_exists('fund_symbol', $fund) && $fund['fund_symbol'] ? $fund['fund_symbol'] : '' }}</div>

        <div class="mt-3 h-[300px]">
            <canvas x-ref="canvas"></canvas>
        </div>
    </div>
</div>
