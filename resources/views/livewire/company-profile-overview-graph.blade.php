<div class="relative graph-wrapper-box w-full">
    @if($visible)
    <div class="graph-wrapper">
        <div class="graph-header">
            <div class="pr-3">
                <b class="title" wire:click="load()">Apple Inc. (AAPL)</b><br>
                <small class="text-blue-600">5.0% price return over 1yr</small>
            </div>
            <div class="select-graph-date-wrapper ml-12 flex">
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
                            <input wire:model="currentChartPeriod" value="YTD" id="date-1yr" type="radio" name="date-range" class="w-4 h-4 ">
                            <span class="w-full py-3 ml-2 ">YTD</span>
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
                            <input wire:model="currentChartPeriod" value="max" id="date-5yr" type="radio" name="date-range" class="w-4 h-4 ">
                            <span class="w-full py-3 ml-2 ">MAX</span>
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

        const getOrCreateTooltip = (chart) => {
            let tooltipEl = chart.canvas.parentNode.querySelector('div');

            if (!tooltipEl) {
                tooltipEl = document.createElement('div');
                tooltipEl.style.background = '#fff';
                tooltipEl.style.borderRadius = '25px';
                tooltipEl.style.color = 'black';
                tooltipEl.style.opacity = 1;
                tooltipEl.style.pointerEvents = 'none';
                tooltipEl.style.position = 'absolute';
                tooltipEl.style.transform = 'translate(-50%, 0)';
                tooltipEl.style.transition = 'all .1s ease';
                tooltipEl.style.minWidth = '230px';
                tooltipEl.style.filter = 'drop-shadow(0px 10.732307434082031px 21.464614868164062px rgba(50, 50, 71, 0.06)) drop-shadow(0px 10.732307434082031px 10.732307434082031px rgba(50, 50, 71, 0.08))';
                tooltipEl.classList.add('tooltip-caret')

                const table = document.createElement('table');
                table.style.margin = '0px';

                tooltipEl.appendChild(table);
                chart.canvas.parentNode.appendChild(tooltipEl);
            }

            return tooltipEl;
        };

        const externalTooltipHandler = (context) => {
            // Tooltip Element
            const {chart, tooltip} = context;
            const tooltipEl = getOrCreateTooltip(chart);

            // Hide if no tooltip
            if (tooltip.opacity === 0) {
                tooltipEl.style.opacity = 0;
                return;
            }

            // Set Text
            if (tooltip.body) {
                const titleLines = tooltip.title || [];
                const bodyLines = tooltip.body.map(b => b.lines);

                const tableHead = document.createElement('thead');

                tableHead.style.color = '#3561E7';
                tableHead.style.textAlign = 'left';
                tableHead.style.marginBottom = '8px';

                titleLines.forEach(title => {
                    const tr = document.createElement('tr');
                    tr.style.borderWidth = 0;

                    const th = document.createElement('th');
                    th.style.borderWidth = 0;
                    const text = document.createTextNode(title);

                    th.appendChild(text);
                    tr.appendChild(th);
                    tableHead.appendChild(tr);
                });

                const tableBody = document.createElement('tbody');
                bodyLines.reverse().forEach((body, i) => {
                    const [label, value] = body[0].split('|');

                    //label

                    const trLabel = document.createElement('tr');
                    trLabel.style.backgroundColor = 'inherit';
                    trLabel.style.borderWidth = '0';
                    trLabel.style.fontSize = '12px';
                    trLabel.style.fontWeight = '400';
                    trLabel.style.color = '#464E49';
                    trLabel.style.paddingBottom = '0px';
                    trLabel.style.marginBottom = '0px';


                    const tdLabel = document.createElement('td');
                    tdLabel.style.borderWidth = 0;

                    const textLabel = document.createTextNode(label);

                    tdLabel.appendChild(textLabel);
                    trLabel.appendChild(tdLabel);

                    tableBody.appendChild(trLabel);


                    //value
                    const tr = document.createElement('tr');
                    tr.style.backgroundColor = 'inherit';
                    tr.style.borderWidth = '0';
                    tr.style.fontSize = '16px';
                    tr.style.fontWeight = '700';
                    tr.style.color = '#464E49';

                    const td = document.createElement('td');
                    td.style.borderWidth = 0;

                    const text = document.createTextNode(value);

                    td.appendChild(text);
                    tr.appendChild(td);

                    tableBody.appendChild(tr);
                });

                const tableRoot = tooltipEl.querySelector('table');

                // Remove old children
                while (tableRoot.firstChild) {
                    tableRoot.firstChild.remove();
                }

                // Add new children
                tableRoot.appendChild(tableHead);
                tableRoot.appendChild(tableBody);
            }

            const {offsetLeft: positionX, offsetTop: positionY} = chart.canvas;

            // Display, position, and set styles for font
            tooltipEl.style.opacity = 1;
            tooltipEl.style.left = positionX + tooltip.caretX + 'px';
            tooltipEl.style.top = positionY + tooltip.caretY - 155 + 'px';
            tooltipEl.style.font = tooltip.options.bodyFont.string;
            tooltipEl.style.padding = 8 + 'px ' + 19 + 'px';
        };

        function initChart() {
            if (chart) chart.destroy();
            let data = @this.chartData;
            let canvas = document.getElementById("product-profile-chart");
            if (!canvas) return;
            let ctx = document.getElementById('product-profile-chart').getContext("2d");
            let gradientBg = ctx.createLinearGradient(0, 0, 0, canvas.height * 2.5)
            gradientBg.addColorStop(0.8, 'rgba(19,176,91,0.18)')
            gradientBg.addColorStop(1, 'rgba(19,176,91,0.05)')
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
                            ctx.lineTo(x, bottomBarY + 9);
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
                            tension: 0.5,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#52D3A2',
                            pointHoverBorderWidth: 4,
                            pointHoverBorderColor: '#fff',
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
                            bodyFont: {
                                size: 15
                            },
                            external: externalTooltipHandler,
                            enabled: false,
                            position: 'nearest',
                            callbacks: {
                                title: function (context) {
                                    const inputDate = new Date(context[0].label);
                                    const month = inputDate.getMonth() + 1;
                                    const day = inputDate.getDate();
                                    const year = inputDate.getFullYear();
                                    return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                                },
                                label: function (context) {
                                    if (context.dataset.label == "Price") {
                                        return `Price|${context.raw.y}`;
                                    } else if (context.dataset.label == "Volume") {
                                        return `Volume|${context.raw.source}`;
                                    }
                                }
                            },
                        }
                    },
                    scales: {
                        y: {
                            max: data.y_axes_max,
                        },
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
                                labelOffset: data.quantity > 20 ? 5 : data.quantity < 5 ? 150 : 30
                            },
                            align: 'center',
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


