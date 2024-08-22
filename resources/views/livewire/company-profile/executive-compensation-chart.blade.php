<div class="mt-4 relative grid grid-cols-12 gap-x-4" x-data="{
    totalRevenue: $wire.entangle('totalRevenue'),
    chartData: $wire.entangle('chartData'),
    chart: null,

    init() {
        this.drawChart();
        this.$watch('chartData', value => {
            this.drawChart();
        });
    },

    drawChart() {
        if (!this.chart) {
            this.chart = new Chart(this.$refs.chartRevenue.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: []
                },
            });
        }

        this.chart.data.labels = Object.keys(this.chartData);
        this.chart.data.datasets = [{
            label: 'Compensation',
            data: Object.values(this.chartData),
            borderWidth: 1
        }];
    }
}">
    <div class="col-span-12 md:col-span-6">
        <div class="block rounded rounded-lg border border-sky-950 overflow-hidden">
            <div class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">
                <p>{{ $year }} Compensation</p>
            </div>
            <canvas x-ref="chartRevenue" class="p-4"></canvas>
        </div>
    </div>
    <div class="col-span-12 md:col-span-6">
        <div class="rounded rounded-lg border border-sky-950 w-full overflow-scroll inline-block">
            <table class="table-auto min-w-full" style="font-size:1em;color:#000;">
                <thead>
                    <tr>
                        <th colspan="2" scope="colgroup"
                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center capitalize">
                            {{ $year }} Compensation List</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t border-gray-200">
                        <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">
                            Position And Name
                        </th>
                        <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">
                            % of Total Revenue</th>
                    </tr>
                    @foreach ($chartData as $name => $value)
                        <tr>
                            <td class="px-3 py-3.5">
                                <span class="text-base font-semibold">{{ $name }}</span>
                            </td>
                            <td class="px-3 py-3.5 text-left text-sm text-blue-500">
                                {{ number_format($value, 4) }} %</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
