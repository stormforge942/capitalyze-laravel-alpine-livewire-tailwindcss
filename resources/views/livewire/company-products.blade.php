<div class="py-12">
    <div class="mx-auto flex flex-col md:flex-row">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-4 rounded md:w-1/2 w-full">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Revenue Product Segmentation - Chart - {{ Str::title($period) }}</h1>
                </div>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <div class="align-middle">
                    <div class="inline-block min-w-full sm:rounded-lg min-h-[30rem]">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-4 rounded md:w-1/2 w-full mt-4 md:mt-0">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Revenue Product Segmentation - {{ Str::title($period) }}</h1>
                </div>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <div class="align-middle">
                    <div class="inline-block min-w-full sm:rounded-lg max-h-[30rem] flex justify-center">
                        <canvas id="Distribution"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto flex">
        <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-4 rounded w-full">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Revenue Geographic Segmentation - {{ Str::title($period) }}</h1>
                </div>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <div class="align-middle">
                    <div class="inline-block min-w-full sm:rounded-lg" wire:model="table">
                        {!! $table !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    let DateTime = luxon.DateTime;
    let data = "{!! $json !!}";
    let segments = {!! json_encode($segments) !!};
    let periodicity = '{!! $period !!}';
    let config;
    let colors = ['#7ff27d', '#fafa7e', '#f364ab', '#f5926a', '#525df0', '#8d47ef', '#b8f77c', '#c554ee', '#6dd8f2', '#6e47ef']

    data = JSON.parse(atob(data));
    config = formatData(data, periodicity);
    configDoughnut = generateDoughnut(data[0]);

    function generateDoughnut(data) {
        console.log(data);
        const firstKey = Object.keys(data)[0];
        const values = Object.values(data[firstKey]);
        const sum = values.reduce((acc, val) => +acc + +val);

		// Calculate percentages
		const percentages = values.map(val => ((val / sum) * 100).toFixed(2));

        let config = {
			type: 'doughnut',
			data: {
				labels: Object.keys(data[firstKey]),
				datasets: [{
					data: percentages,
					backgroundColor: colors,
					borderColor:colors,
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
                cutout: '70%',
				plugins: {
					legend: {
						position: 'top',
                        padding: 200,
					},
					title: {
						display: true,
						text: 'Product Distribution in Percentage'
					},
                    tooltip: {
                        callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                        }
                    }
				}
			}
		}

        return config;
    }

    function formatData(data, periodicity) {
        // Filter data for the last 4 years
        let indexColor = 0;
        let currentDate = DateTime.local();
        let sixYearsAgo = currentDate.minus({
            years: 6
        }).startOf('year');
        let filteredData = data.filter(item => {
            const date = Object.keys(item)[0];
            return DateTime.fromISO(date) >= sixYearsAgo;
        });

        let normalizedData = filteredData.map(item => {
            const date = Object.keys(item)[0];
            const categories = Object.keys(item[date]);
            const normalizedCategories = segments;

            const normalizedItem = {
                date
            , };

            for (const category of normalizedCategories) {
                normalizedItem[category] = categories.includes(category) ? item[date][category] : 0;
            }

            return normalizedItem;
        });

        normalizedData.sort((a, b) => DateTime.fromISO(a.date) - DateTime.fromISO(b.date));

        let labels = normalizedData
            .filter(item => DateTime.fromISO(item.date) >= sixYearsAgo)
            .map(item => item.date);

        let datasets = [];

        for (const category of Object.keys(normalizedData[0])) {
            if (category === 'date') {
                continue;
            }

            let data = normalizedData
                .filter(item => DateTime.fromISO(item.date) >= sixYearsAgo)
                .map((entry) => entry[category]);

            // Only add datasets if there is data available for the last 6 years
            if (data.some(value => value !== 0)) {
                datasets.push({
                    label: category,
                    data: data,
                    backgroundColor: colors[indexColor],
                    stack: 'Stack 0'
                });
                indexColor++;
            }
        }

        let config = {
            type: 'bar'
            , data: {
                labels: periodicity == 'annual' ? labels.map((dateString) => DateTime.fromISO(dateString).toFormat('yyyy')) : labels.map((dateString) => DateTime.fromISO(dateString).toFormat('Qq-yyyy'))
                , datasets: datasets
            }
            , options: {
                maintainAspectRatio: false,
                scales: {
                    x: [{
                        type: 'time'
                        , time: {
                            tooltipFormat: 'MMM dd, yyyy',
                            displayFormats: {
                                quarter: 'MMM YYYY'
                            }
                            , parser: 'YYYY-MM-DD'
                        }
                    }]
                    , y: [{
                        ticks: {
                            beginAtZero: true
                            , callbacks: {
                                label: (value) => '$' + value / 1000000000 + 'B'
                            , }
                        }
                    }]
                }
                , tooltips: {
                    mode: 'index'
                    , intersect: false
                    , callbacks: {
                        label: (tooltipItem, data) => {
                            const value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            const formattedValue = new Intl.NumberFormat('en-US', {
                                style: 'currency'
                                , currency: 'USD'
                            }).format(value);
                            formattedValue = formattedValue.replace(/^(\D+)/, "$1 ");
                            return `${data.datasets[tooltipItem.datasetIndex].label}: ${formattedValue}`;
                        }
                    }
                }
                , responsive: true
                , legend: {
                    position: 'bottom'
                }
            }
        };

        return config;
    }

    const canvasDoughnut = document.getElementById('Distribution');
    const canvas = document.getElementById('revenueChart');
    let myChart = new Chart(canvas, config);
    let doughnutChart = new Chart(canvasDoughnut, configDoughnut);

    Livewire.on('updateChart', (data, periodicity, seg) => {
        segments = seg;
        let jsonData = JSON.parse(atob(data));
        myChart.destroy();
        doughnutChart.destroy();
        let config = formatData(jsonData, periodicity);
        let configDoughnut = generateDoughnut(jsonData[0]);
        myChart = new Chart(canvas, config);
        doughnutChart = new Chart(canvasDoughnut, configDoughnut);
    });

</script>
@endpush