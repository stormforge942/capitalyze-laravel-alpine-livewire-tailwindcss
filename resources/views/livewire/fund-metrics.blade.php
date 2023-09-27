<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block mb-3">
                    <h1 class="text-base font-semibold leading-10 text-gray-900">Fund Metrics - {{ Str::title($fund->name) }}</h1>
                </div>
                <div class="grid gap-4 w-full grid-cols-1 xl:grid-cols-2 items-start">
                    <div class="block w-full rounded rounded-lg border border-sky-950 overflow-hidden">
                        <div class="chart-title whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">
                            <p>13F Sector Allocation Over Time</p>
                        </div>
                        <div wire:loading.flex class="justify-center items-center p-4">
                                 <div class="grid place-content-center h-full" role="status">
                                    <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        <div wire:init="getInvestorData" class="p-4" wire:loading.remove>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                    <div class="block w-full rounded rounded-lg border border-sky-950 overflow-hidden">
                        <div class="chart-title whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">
                            <p>Market Value over Time</p>
                        </div>
                        <div wire:loading.flex class="justify-center items-center p-4">
                                 <div class="grid place-content-center h-full" role="status">
                                    <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        <div wire:init="getTotalValue" class="p-4" wire:loading.remove>
                            <canvas id="ChartValue"></canvas>
                        </div>
                    </div>
                    <div class="block w-full rounded rounded-lg border border-sky-950 overflow-hidden">
                        <div class="chart-title whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">
                            <p>13F Sector Allocation last Quarter</p>
                        </div>
                        <div wire:loading.flex class="justify-center items-center p-4">
                                 <div class="grid place-content-center h-full" role="status">
                                    <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        <div class="p-4" wire:loading.remove>
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('livewire:load', function () {
    Livewire.on('renderChart', function (chartData) {
        var ctx = document.getElementById('myChart').getContext('2d');

        var tailwindColors = {
            'red-500': 'rgba(239, 68, 68, 1)',
            'yellow-500': 'rgba(245, 158, 11, 1)',
            'green-500': 'rgba(16, 185, 129, 1)',
            'blue-500': 'rgba(59, 130, 246, 1)',
            'indigo-500': 'rgba(99, 102, 241, 1)',
            'purple-500': 'rgba(167, 139, 250, 1)',
            'pink-500': 'rgba(236, 72, 153, 1)',
            'red-700': 'rgba(185, 28, 28, 1)',
            'yellow-700': 'rgba(158, 94, 7, 1)',
            'green-700': 'rgba(4, 120, 87, 1)',
            'blue-700': 'rgba(29, 78, 216, 1)',
            'indigo-700': 'rgba(54, 57, 160, 1)',
            'purple-700': 'rgba(96, 64, 156, 1)',
            'pink-700': 'rgba(159, 18, 107, 1)',
            'gray-500': 'rgba(143, 146, 161, 1)',
            'gray-700': 'rgba(75, 85, 99, 1)',
        };
        var colorIndex = 0;

        var sortedKeys = Object.keys(chartData).sort();

        var chartLabels = sortedKeys.map(date => {
            var year = date.substr(0, 4);
            var month = date.substr(5, 2);
            var quarter;
            switch (month) {
                case '03':
                    quarter = 'Q1';
                    break;
                case '06':
                    quarter = 'Q2';
                    break;
                case '09':
                    quarter = 'Q3';
                    break;
                case '12':
                    quarter = 'Q4';
                    break;
            }
            return quarter + ' ' + year;
        });

        var datasets = [];

        // Step 1: Create a list of all unique industries.
        var industries = new Set();
        sortedKeys.forEach((quarter) => {
            Object.keys(chartData[quarter]).forEach((industry) => {
                industries.add(industry);
            });
        });

        // Step 2: For each industry, create a dataset with the data for all quarters.
        industries.forEach((industry) => {
            var data = sortedKeys.map((quarter) => {
                return chartData[quarter] && chartData[quarter][industry] ? chartData[quarter][industry] : 0;
            });
            var colorKeys = Object.keys(tailwindColors);
            datasets.push({
                label: industry,
                data: data,
                backgroundColor: tailwindColors[colorKeys[colorIndex % colorKeys.length]],
                stack: 'Stack 0'
            });
            colorIndex++;
        });

        const config = {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Include a % sign in the ticks and limit to 2 decimal places
                            callback: function(value, index, values) {
                                return Number(value).toFixed(2) + ' %';
                            }
                        }
                    }
                },
                // Move the legend to the bottom of the chart
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += Number(context.parsed.y).toFixed(2) + '%';
                                }
                                return label;
                            }
                        }
                    }
                },
                tooltips: {
                    callbacks: {
                        // Include a % sign in the tooltips and limit to 2 decimal places
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var currentValue = dataset.data[tooltipItem.index];
                            return dataset.label + ': ' + Number(currentValue).toFixed(2) + ' %';
                        }
                    }
                },
                responsive: true,
                aspectRatio: 1.3,
            }
        };

        new Chart(ctx, config);
    });

    Livewire.on('renderValue', function (chartData) {
        var ctx = document.getElementById('ChartValue').getContext('2d');
        
        // Convert dates to quarters
        var quarters = Object.keys(chartData).map(date => {
            var year = date.substr(0, 4);
            var month = date.substr(5, 2);
            var quarter;
            switch (month) {
                case '03':
                    quarter = 'Q1';
                    break;
                case '06':
                    quarter = 'Q2';
                    break;
                case '09':
                    quarter = 'Q3';
                    break;
                case '12':
                    quarter = 'Q4';
                    break;
            }
            return quarter + '-' + year;
        });

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: quarters, // This should be your quarters
                datasets: [{
                    data: Object.values(chartData), // This should be your total_values for each quarter
                    fill: true, // Fill the area under the line
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color for the filled area
                    borderColor: 'rgb(75, 192, 192)', // Color for the line
                    tension: 0.1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false, // Hide the legend
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

    Livewire.on('renderIndustryDistribution', function (chartData) {
    const ctx = document.getElementById('pieChart').getContext('2d');
    const labels = Object.keys(chartData);
    const data = Object.values(chartData);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Industry Distribution',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 1.5,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += Number(context.parsed).toFixed(2) + '%';
                            }
                            return label;
                        }
                    }
                }
                }
            }
        });
    });

});

</script>

@endpush