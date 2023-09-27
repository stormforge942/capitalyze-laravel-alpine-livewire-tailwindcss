<div class="py-12">
    @if($noData)
        <div class="mx-auto flex">
            <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-1/2 md:mx-auto">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">No data available</h1>
                    </div>
                </div>
            </div>
        </div>
    @else
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

        @if(!$noData)
            <div class="mx-auto flex">
                <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-4 rounded w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Revenue Geographic Segmentation - {{ Str::title($period) }}</h1>
                        </div>
                    </div>
                    <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                        <div class="align-middle">
                            {{--                    <div class="inline-block min-w-full sm:rounded-lg">--}}
                            {{--                        {!! $table !!}--}}
                            {{--                    </div>--}}
                            <div class="inline-block min-w-full sm:rounded-lg">
                                <table class="table-auto min-w-full data">
                                    <thead>
                                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                            Segment
                                        </th>
                                        @foreach(array_keys($products) as $date)
                                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">
                                                {{ $date }}
                                            </th>
                                        @endforeach
                                    </thead>
                                    <tbody class="divide-y bg-white">
                                        @foreach($segments as $index => $segment)
                                            <tr class="{{ $index % 2 == 0 ? 'border border-slate-50 bg-cyan-50 hover:bg-blue-200' : 'border border-slate-50 bg-white border-slate-100 hover:bg-blue-200' }}">
                                                <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900"> {{ $segment }} </td>
                                                @foreach(array_keys($products) as $date)
                                                    @if(array_key_exists($segment, $products[$date]))
                                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                                            <div class="flex flex-row justify-between items-center space-x-2">
                                                                <span>
                                                                    ${{ number_format($products[$date][$segment]) }}
                                                                </span>
                                                                @if(auth()->user()->hasNavbar('create.company.segment.report'))
                                                                    <span wire:click="$emit('slide-over.open', 'company-segment-report-slide', [{{ $products[$date][$segment] }}, '{{ $date }}', '{{request()->path()}}'])" class="hover:text-gray-900 cursor-pointer bg-white hover:bg-opacity-20 bg-opacity-0 rounded-full whitespace-nowrap text-sm text-gray-800">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                                        </svg>
                                                                    </span>
                                                                @endif
                                                            </div>

                                                        </td>
                                                    @else
                                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900"></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
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
                        borderColor: colors,
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
                                label: function (context) {
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
                    ,
                };

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
                                    ,
                                }
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
