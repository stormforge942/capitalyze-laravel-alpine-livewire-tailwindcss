<div class="px-8">
    <div class="flex items-center gap-2 text-dark-light2 font-medium text-sm">
        <span class="px-2 py-1">Ownership</span>
        <span class="grid place-items-center text-dark-lighter">/</span>

        <a class="flex items-center gap-1"
            href="{{ route('company.ownership', $company->ticker) }}">
            <span class="px-2 py-1">Shareholders</span>

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M10.2536 8L6.25365 12L5.32031 11.0667L8.38698 8L5.32031 4.93333L6.25365 4L10.2536 8Z"
                    fill="#464E49" />
            </svg>
        </a>

        <div class="ml-6 flex items-center gap-6 text-[13px]">
            @foreach($funds as $fund)
            <div class="flex items-center gap-2">
                <button class="@if($fund->cik === $active) text-blue underline @endif" wire:click.prevent="setActive({{ $fund->cik }})">{{ $fund->name }}</button>

                <button>
                    <svg class="text-red" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
                        <path
                            d="M5 10C2.23857 10 0 7.7614 0 5C0 2.23857 2.23857 0 5 0C7.7614 0 10 2.23857 10 5C10 7.7614 7.7614 10 5 10ZM5 9C7.20915 9 9 7.20915 9 5C9 2.79086 7.20915 1 5 1C2.79086 1 1 2.79086 1 5C1 7.20915 2.79086 9 5 9ZM5 4.2929L6.4142 2.87868L7.1213 3.58578L5.7071 5L7.1213 6.4142L6.4142 7.1213L5 5.7071L3.58578 7.1213L2.87868 6.4142L4.2929 5L2.87868 3.58578L3.58578 2.87868L5 4.2929Z"
                            fill="#C22929" />
                    </svg>
                </button>
            </div>
            @endforeach

            <a href="{{ route('company.ownership', $company->ticker) }}" class="ml-2 text-red font-semibold" >
                Clear All
            </a>
        </div>
    </div>

    <div class="mt-6">
        <h1 class="font-bold text-xl">{{ $activeFund->name }}</h1>
        <div class="mt-2 flex items-center gap-2 text-xs">
            <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                CIK:
                <span class="text-blue font-semibold">{{ $activeFund->cik }}</span>
            </div>

            <div class="border rounded border-blue border-opacity-50 px-1.5 py-0.5">
                FORM TYPE:
                <span class="text-blue font-semibold">4</span>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <livewire:tabs :tabs="$tabs" :data="['fund' => $activeFund]">
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('overTimeMarketValue', renderOverTimeMarketValueChart)

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
                        pointHoverBackgroundColor: '#0E5FD9',
                        pointHoverBorderWidth: 4,
                        pointHoverBorderColor: '#fff',
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
                    responsive: true,
                    aspectRatio: 4,
                    onResize: function(chart, size) {
                        if (size.width < 768) {
                            chart.options.aspectRatio = 2;
                        } else {
                            chart.options.aspectRatio = 3;
                        }
                    },
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
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush