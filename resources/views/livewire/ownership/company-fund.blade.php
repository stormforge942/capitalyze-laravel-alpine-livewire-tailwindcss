<div class="lg:px-8">
    <div class="flex items-center gap-2 text-sm font-medium text-dark-light2">
        <span class="px-2 py-1">Ownership</span>

        <span class="grid place-items-center text-dark-lighter">/</span>

        <a href="{{ route('company.ownership', $company->ticker) }}">
            <span class="px-2 py-1">Shareholders</span>
        </a>

        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M10.2536 8L6.25365 12L5.32031 11.0667L8.38698 8L5.32031 4.93333L6.25365 4L10.2536 8Z"
                fill="#464E49" />
        </svg>

        <a href="{{ route('company.fund', [$company->ticker, $fund->cik]) }}">
            <span class="px-2 py-1 text-blue">{{ $fund->name }}</span>
        </a>
    </div>

    <div class="mt-6">
        <h1 class="text-xl font-bold">{{ $fund->name }}</h1>
        <div class="flex items-center gap-2 mt-2 text-xs">
            <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                CIK:
                <span class="font-semibold text-blue">{{ $fund->cik }}</span>
            </div>

            <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                FORM TYPE:
                <span class="font-semibold text-blue">4</span>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <livewire:tabs :tabs="$tabs" :data="['fund' => $fund]">
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('overTimeMarketValue', renderOverTimeMarketValueChart)
        })

        function renderOverTimeMarketValueChart(data) {
            data = data.sort((a, b) => new Date(a.date) - new Date(b.date))

            const canvas = document.getElementById('overTimeMarketValue');

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: data.map(item => item.quarter),
                    datasets: [{
                        data: data.map(item => item.total),
                        borderColor: "#0E5FD9",
                        pointRadius: 0,
                        fill: true,
                        tension: 0.5,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderWidth: 4,
                        pointHoverBorderColor: '#0E5FD9',
                        backgroundColor(context) {
                            if (!context.chart.chartArea) {
                                return
                            }

                            const {
                                top,
                                bottom
                            } = context.chart.chartArea;

                            const gradient = context.chart.ctx.createLinearGradient(0, top, 0, bottom);

                            gradient.addColorStop(0.5, '#CFDFF7')
                            gradient.addColorStop(1, 'rgba(207, 223, 247, 0.00)')

                            return gradient;
                        },
                    }]
                },
                options: {
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    responsive: true,
                    aspectRatio: 3,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            displayColors: false,
                            backgroundColor: '#fff',
                            titleColor: '#121A0F',
                            bodyColor: '#121A0F',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: {
                                display: false
                            },
                            ticks: {
                                callback: function(value, index, values) {
                                    if (value >= 1e9) {
                                        value = (value / 1e9).toFixed(1) + 'B';
                                    } else if (value >= 1e6) {
                                        value = (value / 1e6).toFixed(1) + 'M';
                                    } else if (value >= 1e3) {
                                        value = (value / 1e3).toFixed(1) + 'k';
                                    } else {
                                        value = value.toString();
                                    }

                                    if (value.indexOf('.0') > -1) {
                                        value = value.replace('.0', '');
                                    }

                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function renderOverTimeSectorAllocation(data) {
            const canvas = document.getElementById('overTimeSectorAllocation');

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.quarter),
                    datasets: [{
                        data: data.map(item => item.weight),
                        backgroundColor: '#FFD599',
                    }]
                },
                options: {
                    responsive: true,
                    aspectRatio: 2.7,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                },
                                display: false
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                display: false
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            })
        }

        function renderLastQuarterSectorAllocation(data) {
            const canvas = document.getElementById('lastQuarterSectorAllocation');

            new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        data: data.map(item => item.weight),
                        backgroundColors: [
                            'rgb(168,236,29)',
                            'rgb(3,23,49)',
                            'rgb(223,223,212)',
                            'rgb(179,74,15)',
                            'rgb(35,7,82)',
                            'rgb(74,38,144)',
                            'rgb(19,253,206)',
                            'rgb(44,137,109)',
                            'rgb(89,79,129)',
                            'rgb(42,142,221)',
                            'rgb(164,130,131)',
                            'rgb(152,245,1)',
                            'rgb(224,30,164)',
                            'rgb(105,49,128)',
                            'rgb(127,22,217)',
                            'rgb(179,178,237)',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                }
            })
        }
    </script>
@endpush
