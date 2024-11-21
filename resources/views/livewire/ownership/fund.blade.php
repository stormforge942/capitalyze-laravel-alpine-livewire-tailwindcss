<div x-data="{ tab: null }" @tab-changed="tab = $event.detail;">
    <div class="mb-4 flex lg:hidden items-center justify-between">
        <h2 class="text-xl font-semibold text-blue">Ownership</h2>

        <x-download-data-buttons x-show="tab?.key === 'holdings'" x-cloak />
    </div>

    @livewire('ownership.breadcrumb')

    <div class="mt-6 flex items-center justify-between">
        <div>
            <div class="flex flex-row items-center gap-x-4">
                <h1 class="text-xl font-bold">{{ $fund->name }}</h1>
                <div class="px-4 py-2 flex flex-row items-center gap-x-2 hover:cursor-pointer" wire:click="addOrRemoveFromFavourite">
                    @if ($isFavorite)
                        <span>Remove From Favourites</span>
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.9991 11.173L3.24269 13.2757C2.87038 13.4841 2.4249 13.1604 2.50805 12.7419L3.34702 8.51961L0.186483 5.59686C-0.126768 5.30717 0.0433897 4.78348 0.467087 4.73324L4.74198 4.22638L6.54506 0.317342C6.72377 -0.0700937 7.27442 -0.0700927 7.45312 0.317344L9.25616 4.22638L13.531 4.73324C13.9547 4.78348 14.1249 5.30717 13.8117 5.59685L10.6512 8.51961L11.4901 12.7419C11.5733 13.1604 11.1278 13.4841 10.7555 13.2757L6.9991 11.173ZM6.9991 9.64501L9.83023 11.2297L9.1979 8.04747L11.58 5.84461L8.35803 5.46257L6.9991 2.51635L5.64012 5.46257L2.41817 5.84461L4.80024 8.04747L4.16792 11.2297L6.9991 9.64501Z" fill="none" stroke="#FFD700"/>
                        </svg>
                    @else
                        <span>Add To Favourites</span>
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.9991 11.173L3.24269 13.2757C2.87038 13.4841 2.4249 13.1604 2.50805 12.7419L3.34702 8.51961L0.186483 5.59686C-0.126768 5.30717 0.0433897 4.78348 0.467087 4.73324L4.74198 4.22638L6.54506 0.317342C6.72377 -0.0700937 7.27442 -0.0700927 7.45312 0.317344L9.25616 4.22638L13.531 4.73324C13.9547 4.78348 14.1249 5.30717 13.8117 5.59685L10.6512 8.51961L11.4901 12.7419C11.5733 13.1604 11.1278 13.4841 10.7555 13.2757L6.9991 11.173ZM6.9991 9.64501L9.83023 11.2297L9.1979 8.04747L11.58 5.84461L8.35803 5.46257L6.9991 2.51635L5.64012 5.46257L2.41817 5.84461L4.80024 8.04747L4.16792 11.2297L6.9991 9.64501Z" fill="#121A0F"/>
                        </svg>
                    @endif
                </div>
            </div>
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
                        },
                        addLogo: false,
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
                                display: false,
                            },
                            border: {
                                display: false
                            },
                        }
                    }
                }
            });
        }

        function renderOverTimeSectorAllocation(data) {
            const canvas = document.getElementById('overTimeSectorAllocation');

            data = data.map(item => ({
                ...item,
                borderRadius: 2,
            }))

            if (window.otsaChart) {
                window.otsaChart.data.datasets = data;
                window.otsaChart.update();
                return;
            }

            window.otsaChart = new Chart(canvas, {
                type: 'bar',
                data: {
                    datasets: data
                },
                plugins: [
                    window.chartJsPlugins.htmlLegend
                ],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    maxBarThickness: 80,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        htmlLegend: {
                            container: document.querySelector('#otsa-legend'),
                            grid: {
                                columns: 2,
                            },
                        },
                        addLogo: false,
                    },
                    scales: {
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            border: {
                                display: false
                            },
                            ticks: {
                                callback: (value) => value + '%',
                            },
                            border: {
                                display: false
                            },
                            max: 100
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
                        backgroundColor: data.backgroundColors,
                    }]
                },
                plugins: [
                    window.chartJsPlugins.htmlLegend
                ],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        addLogo: false,
                        htmlLegend: {
                            container: document.querySelector('#lqsa-legend'),
                            grid: {
                                columns: 2,
                            },
                        }
                    },
                }
            })
        }
    </script>
@endpush
