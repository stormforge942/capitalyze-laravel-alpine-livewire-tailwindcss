<div x-data="{
    chart: null,
    chartData: @js($chartData),
    init() {
        this.renderChart();
    },
    renderChart() {
        this.chart?.destroy();
        this.chart = window.investorFundPage.renderInvestorChart(this.$refs.canvas, this.chartData);
    },
}">
    <div class="bg-white px-4 py-6 md:px-6 rounded-lg relative" x-transition>
        <div class="font-extrabold">{{ $fund['name'] }}</div>
        <div class="text-blue-light text-sm">
            {{ array_key_exists('fund_symbol', $this->fund) ? $this->fund['fund_symbol'] : '' }}</div>

        <div class="mt-3 h-[300px]">
            <canvas x-ref="canvas"></canvas>
        </div>
    </div>
</div>
