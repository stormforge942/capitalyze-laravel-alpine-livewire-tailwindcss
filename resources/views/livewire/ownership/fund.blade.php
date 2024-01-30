<div x-data="{ tab: null }" @tab-changed="tab = $event.detail;">
    <div class="mb-4 flex lg:hidden items-center justify-between">
        <h2 class="text-xl font-semibold text-blue">Ownership</h2>

        <x-download-data-buttons x-show="tab?.key === 'holdings'" x-cloak />
    </div>

    @livewire('ownership.breadcrumb')

    <div class="mt-6 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold">{{ $fund->name }}</h1>
            <div class="flex items-center gap-2 mt-2 text-xs">
                <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                    CIK:
                    <span class="font-semibold text-blue">{{ $fund->cik }}</span>
                </div>
            </div>
        </div>

        <x-download-data-buttons class="hidden lg:block" x-show="tab?.key === 'holdings'" x-cloak />
    </div>

    <div class="mt-6" id="company-fund-tab">
        <livewire:tabs :tabs="$tabs" :data="['fund' => $fund, 'company' => $company]" :ssr="false">
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
                        backgroundColor: chartJsPlugins.makeLinearGradientBackgroundColor([
                            [0.5, '#CFDFF7'],
                            [1, 'rgba(207, 223, 247, 0.00)'],
                        ]),
                    }]
                },
                plugins: [chartJsPlugins.pointLine],
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
                            bodyFont: {
                                size: 15
                            },
                            external: chartJsPlugins.largeTooltip,
                            enabled: false,
                            position: 'nearest',
                            callbacks: {
                                title: function(context) {
                                    return context[0].label;
                                },
                                label: function(context) {
                                    const val = Intl.NumberFormat().format(context.raw)
                                    return `Value|${val}`;
                                }
                            },
                        },
                        pointLine: {
                            color: '#0E5FD9',
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
                    datasets: data
                },
                options: {
                    responsive: true,
                    aspectRatio: 1.7,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: "bottom",
                            align: "start",
                            labels: {
                                boxWidth: 12,
                                boxHeight: 12,
                                font: {
                                    size: 12,
                                },
                            },
                        },
                    },
                    scales: {
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            border: {
                                display: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                },
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            stacked: true,
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
                    labels: data.labels,
                    datasets: [{
                        data: data.data,
                        backgroundColors: data.backgroundColor,
                    }]
                },
                options: {
                    responsive: true,
                    aspectRatio: 1,
                    plugins: {
                        legend: {
                            display: true,
                            position: "bottom",
                            align: "start",
                            labels: {
                                boxWidth: 12,
                                boxHeight: 12,
                                font: {
                                    size: 12,
                                },
                            },
                        },
                    },
                }
            })
        }
    </script>
@endpush
