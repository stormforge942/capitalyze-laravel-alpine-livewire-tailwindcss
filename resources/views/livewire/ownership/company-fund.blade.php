<div>
    <h2 class="block mb-4 text-xl font-semibold lg:hidden text-blue">Ownership</h2>

    @livewire('ownership.breadcrumb', ['company' => $company->ticker])

    <div class="mt-6">
        <h1 class="text-xl font-bold">{{ $fund->name }}</h1>
        <div class="flex items-center gap-2 mt-2 text-xs">
            <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                CIK:
                <span class="font-semibold text-blue">{{ $fund->cik }}</span>
            </div>

            @if (count($formTypes))
                <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                    FORM TYPE:
                    <span class="font-semibold text-blue">{{ implode(',', $formTypes) }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-6" id="company-fund-tab">
        <livewire:tabs :tabs="$tabs" :data="['fund' => $fund, 'ticker' => $company->ticker]">
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
                    aspectRatio: 1,
                    maintainAspectRatio: false,
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
                    maintainAspectRatio: true,
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
