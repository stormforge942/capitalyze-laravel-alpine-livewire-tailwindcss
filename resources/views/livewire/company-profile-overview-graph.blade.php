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
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M19 3.81818H20C21.1 3.81818 22 4.63636 22 5.63636V20.1818C22 21.1818 21.1 22 20 22H4C2.9 22 2 21.1818 2 20.1818V5.63636C2 4.63636 2.9 3.81818 4 3.81818H5V2.90909C5 2.40909 5.45 2 6 2C6.55 2 7 2.40909 7 2.90909V3.81818H17V2.90909C17 2.40909 17.45 2 18 2C18.55 2 19 2.40909 19 2.90909V3.81818ZM5 20.1818H19C19.55 20.1818 20 19.7727 20 19.2727V8.36364H4V19.2727C4 19.7727 4.45 20.1818 5 20.1818Z" fill="#52D3A2"/>
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

        function initChart() {
            if (chart) chart.destroy();
            let data = @this.chartData;
            let canvas = document.getElementById("product-profile-chart");
            if (!canvas) return;
            let ctx = document.getElementById('product-profile-chart').getContext("2d");
            let gradientBg = ctx.createLinearGradient(0, 0, 0, canvas.height * 3)
            gradientBg.addColorStop(0.8, 'rgba(19,176,91,0.18)')
            gradientBg.addColorStop(1, 'rgba(19,176,91,0.02)')
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
                            ctx.strokeStyle = '#13B05BDE';
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
                    // labels: data.labels,
                    datasets: [
                        {
                            data: data.dataset2,
                            label: "Volume",
                            borderColor: "#9D9D9D",
                            backgroundColor: 'rgba(255, 255, 255, 0)',
                            borderWidth: Number.MAX_VALUE,
                            fill: true,
                        },
                        {
                            data: data.dataset1,
                            label: "Price",
                            borderColor: "#52D3A2",
                            backgroundColor: gradientBg,
                            type: 'line',
                            pointRadius: 0,
                            fill: true,
                            tension: 0.5
                        },
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
                            titleColor: '#52D3A2',
                            titleFont: {
                                size: 15
                            },
                            bodyColor: "#52D3A2",
                            bodyFont: {
                                size: 15
                            },
                            displayColors: false,
                            borderColor: '#F3F3F3',
                            borderWidth: 1,
                            callbacks: {
                                title: function (context) {
                                    const inputDate = new Date(context[0].label);
                                    const month = inputDate.getMonth() + 1;
                                    const day = inputDate.getDate();
                                    const year = inputDate.getFullYear();
                                    return `${month.toString().padStart(2, '0')}/${day.toString().padStart(2, '0')}/${year}`;
                                },
                                label: function (context) {
                                    if (context.dataset.label == "Price") {
                                        return `Price: ${context.raw.y}`;
                                    } else if (context.dataset.label == "Volume") {
                                        return `Volume: ${Math.round(context.raw.y * data.divider)}`;
                                    }
                                }
                            },
                        }
                    },
                    scales: {
                        x: {
                            offset: false,
                            grid: {
                                display: false
                            },
                            type: 'timeseries',
                            time: {
                                unit: data.unit,
                            },
                            ticks:{
                                source:'data',
                                maxTicksLimit: data.quantity,
                            },
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


