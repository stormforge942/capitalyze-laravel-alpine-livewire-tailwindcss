<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Revenue Geographic Segmentation - Chart - {{ Str::title($period) }}</h1>
                </div>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <div class="align-middle">
                    <div class="inline-block min-w-full sm:rounded-lg">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
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
<script wire:model="json">
    let DateTime = luxon.DateTime;
    let data = {!! $json !!};
    let segments = {!! json_encode($segments) !!}
    let periodicity = '{!! $period !!}';
    let config;

    config = formatData(data, periodicity);

    function formatData(data, periodicity) {
        // Filter data for the last 4 years
        let currentDate = DateTime.local();
        let fourYearsAgo = currentDate.minus({
            years: 4
        }).startOf('year');
        let filteredData = data.filter(item => {
            const date = Object.keys(item)[0];
            return DateTime.fromISO(date) >= fourYearsAgo;
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
            .filter(item => DateTime.fromISO(item.date) >= fourYearsAgo)
            .map(item => item.date);

        let datasets = [];

        for (const category of Object.keys(normalizedData[0])) {
            if (category === 'date') {
                continue;
            }

            let data = normalizedData
                .filter(item => DateTime.fromISO(item.date) >= fourYearsAgo)
                .map((entry) => entry[category]);

            // Only add datasets if there is data available for the last 4 years
            if (data.some(value => value !== 0)) {
                datasets.push({
                    label: category,
                    data: data,
                    backgroundColor: getRandomColor(),
                    stack: 'Stack 0'
                });
            }
        }

        console.log(periodicity);

        let config = {
            type: 'bar'
            , data: {
                labels: periodicity == 'annual' ? labels.map((dateString) => DateTime.fromISO(dateString).toFormat('yyyy')) : labels.map((dateString) => DateTime.fromISO(dateString).toFormat('Qq-yyyy'))
                , datasets: datasets
            }
            , options: {
                scales: {
                    xAxes: [{
                        type: 'time'
                        , time: {
                            tooltipFormat: 'MMM dd, yyyy',
                            displayFormats: {
                                quarter: 'MMM YYYY'
                            }
                            , parser: 'YYYY-MM-DD'
                        }
                    }]
                    , yAxes: [{
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
                , title: {
                    display: true
                    , text: 'Apple Revenue by Product Category (Last 4 Years)'
                    , fontSize: 18
                }
            }
        };

        return config;
    }

    const canvas = document.getElementById('revenueChart');
    let myChart = new Chart(canvas, config);

    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    Livewire.on('updateChart', (data, periodicity) => {
            console.log('called');
            console.log(JSON.parse(data));
            myChart.destroy();
            let config = formatData(JSON.parse(data), periodicity);
            myChart = new Chart(canvas, config);
        });

</script>
@endpush