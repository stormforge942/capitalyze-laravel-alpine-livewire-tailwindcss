<div class="relative graph-wrapper-box w-full">
    @if($visible)
    <div class="graph-wrapper">
        <div class="graph-header">
            <div class="pr-3">
                <b class="title" wire:click="load()">Apple Inc. (AAPL)</b><br>
                <small class="text-blue-600">5.0% price return over 1yr</small>
            </div>
            <div class="select-graph-date-wrapper flex">
                <span class="text-blue-600 flex items-center">Date:</span>
                <ul class="items-center w-full flex">
                    <li class="w-full mr-2">
                        <label class="flex items-center pl-3">
                            <input wire:model="currentChartPeriod" value="3m" id="date-3m" type="radio" name="date-range" class="w-4 h-4 ">
                            <span class="w-full py-3 ml-2 ">3m</span>
                        </label>
                    </li>
                    <li class="w-full mr-2">
                        <label class="flex items-center pl-3">
                            <input wire:model="currentChartPeriod" value="6m" id="date-6m" type="radio" name="date-range" class="w-4 h-4 ">
                            <span class="w-full py-3 ml-2 ">6m</span>
                        </label>
                    </li>
                    <li class="w-full mr-2">
                        <label class="flex items-center pl-3">
                            <input wire:model="currentChartPeriod" value="1yr" id="date-1yr" type="radio" name="date-range" class="w-4 h-4 ">
                            <span class="w-full py-3 ml-2 ">1yr</span>
                        </label>
                    </li>
                    <li class="w-full mr-2">
                        <label class="flex items-center pl-3">
                            <input wire:model="currentChartPeriod" value="5yr" id="date-5yr" type="radio" name="date-range" class="w-4 h-4 ">
                            <span class="w-full py-3 ml-2 ">5yr</span>
                        </label>
                    </li>
                    <li class="w-full mr-2">
                        <label class="flex items-center pl-3">
                            <input id="date-custom" type="radio" name="date-range" class="w-4 h-4">
                            <span class="w-full py-3 ml-2 ">Custom</span>
                        </label>
                    </li>
                </ul>
                <div class="date-range-select-wrapper flex ml-2 graph-range-picker" wire:ignore>
                    <div class="from-wrapper py-2 px-3">
                        <div class="label">From</div>
                        <div class="value">{{\Carbon\Carbon::today()->modify('-1 year')->format('M d, Y')}}</div>
                        <input type="hidden" name="start" value="{{\Carbon\Carbon::today()->modify('-1 year')}}">
                    </div>
                    <div class="to-wrapper py-2 px-4">
                        <div class="label">To</div>
                        <div class="value">{{\Carbon\Carbon::today()->format('M d, Y')}}</div>
                        <input type="hidden" name="end" value="{{\Carbon\Carbon::today()}}">
                    </div>
                    <div class="calendar-icon-wrapper icon-wrapper px-4 flex items-center">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M19 3.81818H20C21.1 3.81818 22 4.63636 22 5.63636V20.1818C22 21.1818 21.1 22 20 22H4C2.9 22 2 21.1818 2 20.1818V5.63636C2 4.63636 2.9 3.81818 4 3.81818H5V2.90909C5 2.40909 5.45 2 6 2C6.55 2 7 2.40909 7 2.90909V3.81818H17V2.90909C17 2.40909 17.45 2 18 2C18.55 2 19 2.40909 19 2.90909V3.81818ZM5 20.1818H19C19.55 20.1818 20 19.7727 20 19.2727V8.36364H4V19.2727C4 19.7727 4.45 20.1818 5 20.1818Z" fill="#3561E7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full mt-3" wire:ignore>
            <canvas id="product-profile-chart" class="w-full"></canvas>
        </div>

    </div>
    @endif
        <button wire:click="toggleVisible" class="flex items-center justify-center rounded-bl rounded-tr bg-blue-50 text-sm px-3 py-1 absolute right-0 top-0">
            <span>Hide summary</span>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 ml-2">
                @if($visible)
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                @endif
            </svg>
        </button>

    @if(!$visible)
        <div style="margin-bottom: 2em"></div>
    @endif

</div>

@pushonce('scripts')
    <script>


        let chart;
        // Chart.Tooltip.positioners.custom = function(elements, eventPosition) {
        //     let tooltip = this;
        //     return {
        //         x: eventPosition.x,
        //         y: eventPosition.y
        //     };
        // }

        // Chart.Tooltip.positioners.bottom = function(items) {
        //     const pos = Chart.Tooltip.positioners.average(items);
        //
        //     // Happens when nothing is found
        //     if (pos === false) {
        //         return false;
        //     }
        //
        //     const chart = this.chart;
        //
        //     return {
        //         x: pos.x,
        //         y: chart.chartArea.bottom,
        //         xAlign: 'center',
        //         yAlign: 'bottom',
        //     };
        // };

        function initChart() {
            let data = @this.chartData;
            let canvas = document.getElementById("product-profile-chart");
            if (!canvas) return;
            let ctx = canvas.getContext('2d');
            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                plugins: [{
                    afterDraw: chart => {
                        if (chart.tooltip?._active?.length) {
                            let x = chart.tooltip._active[0].element.x;
                            let y = chart.tooltip._active[0].element.y;
                            let bottomBarY = chart.tooltip._active[1].element.y;
                            let ctx = chart.ctx;
                            ctx.save();
                            ctx.beginPath();
                            ctx.moveTo(x, y);
                            ctx.lineTo(x, bottomBarY);
                            ctx.lineWidth = 1;
                            ctx.strokeStyle = 'rgba(0, 0, 255, 0.4)';
                            ctx.setLineDash([5, 5])
                            ctx.stroke();
                            ctx.restore();
                        }
                    }
                }],
                maintainAspectRatio: true,
                aspectRatio: 3,
                type: 'bar',
                data: {
                    labels: data.label,
                    datasets: [{
                        data: data.dataset1,
                        label: "Price",
                        borderColor: "#3561E7",
                        type: 'line',
                        pointRadius: 0,
                        fill: false,
                        tension: 0.01
                    }, {
                        data: data.dataset2,
                        label: "Volume",
                        borderColor: "#13B05B",
                        borderWidth: Number.MAX_VALUE,
                        borderRadius: Number.MAX_VALUE,
                        fill: true,
                    }
                    ]
                },
                options: {

                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    title: {
                        display: false,
                    },
                    elements: {
                        line: {
                            tension: 0
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            // position : 'bottom',
                            backgroundColor: '#fff',
                            titleColor: '#3561E7',
                            titleFont: {
                                size: 15
                            },
                            bodyColor: "#3561E7",
                            bodyFont: {
                                size: 15
                            },
                            displayColors: false,
                            borderColor: '#F3F3F3',
                            borderWidth: 1,
                            callbacks: {
                                title: function (context) {
                                    return `Date: ${context[0].label}`;
                                },
                                label: function (context) {
                                    if (context.dataset.label == "Price") {
                                        return `Price: ${context.raw}`;
                                    } else if (context.dataset.label == "Volume") {
                                        return `Volume: ${context.raw * data.divider}`;
                                    }
                                }
                            },
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', initChart);

        Livewire.on("updateChart", initChart);
        window.addEventListener("resize", initChart);

        Livewire.on("companyChartReset", initChart);
    </script>
@endpushonce


