<div class="bg-white px-8 py-10 rounded-lg relative" x-data="{ hide: false }">
    <div class="absolute top-3 right-5">
        <x-dropdown placement="bottom-start" :shadow="true">
            <x-slot name="trigger">
                <svg :class="open ? `rotate-90` : ''" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9 21.998L15 21.998C20 21.998 22 19.998 22 14.998L22 8.99805C22 3.99805 20 1.99805 15 1.99805L9 1.99805C4 1.99805 2 3.99805 2 8.99805L2 14.998C2 19.998 4 21.998 9 21.998Z"
                        stroke="#121A0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="12" cy="8" r="1" fill="#121A0F" />
                    <circle cx="12" cy="12" r="1" fill="#121A0F" />
                    <circle cx="12" cy="16" r="1" fill="#121A0F" />
                </svg>
            </x-slot>

            <div class="py-4 text-sm+ w-52">
                <div class="[&>*]:px-4 [&>*]:w-full [&>*]:p-2 [&>*]:text-left">
                    <button class="hover:bg-gray-100" @click="hide = !hide; dropdown.hide();"
                        x-text="hide ? 'Show Chart' : 'Hide Chart'"></button>
                    <button class="hover:bg-gray-100">View in Full Screen</button>
                    <button class="hover:bg-gray-100">Print Chart</button>
                </div>
                <hr class="my-4">
                <div class="[&>*]:px-4 [&>*]:w-full [&>*]:p-2">
                    <button class="hover:bg-gray-100 flex items-center gap-x-2">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.66927 6.66667H12.0026L8.0026 10.6667L4.0026 6.66667H7.33594V2H8.66927V6.66667ZM2.66927 12.6667H13.3359V8H14.6693V13.3333C14.6693 13.7015 14.3708 14 14.0026 14H2.0026C1.63442 14 1.33594 13.7015 1.33594 13.3333V8H2.66927V12.6667Z"
                                fill="#121A0F" />
                        </svg>

                        <span>Download as PDF</span>
                    </button>
                    <button class="hover:bg-gray-100 flex items-center gap-x-2">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.66927 6.66667H12.0026L8.0026 10.6667L4.0026 6.66667H7.33594V2H8.66927V6.66667ZM2.66927 12.6667H13.3359V8H14.6693V13.3333C14.6693 13.7015 14.3708 14 14.0026 14H2.0026C1.63442 14 1.33594 13.7015 1.33594 13.3333V8H2.66927V12.6667Z"
                                fill="#121A0F" />
                        </svg>

                        <span>Download as JPEG</span>
                    </button>
                    <button class="hover:bg-gray-100 flex items-center gap-x-2">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.66927 6.66667H12.0026L8.0026 10.6667L4.0026 6.66667H7.33594V2H8.66927V6.66667ZM2.66927 12.6667H13.3359V8H14.6693V13.3333C14.6693 13.7015 14.3708 14 14.0026 14H2.0026C1.63442 14 1.33594 13.7015 1.33594 13.3333V8H2.66927V12.6667Z"
                                fill="#121A0F" />
                        </svg>

                        <span>Download as PNG</span>
                    </button>
                </div>
            </div>
        </x-dropdown>
    </div>

    <div class="flex items-center gap-x-5">
        <div>
            <b class="font-extrabold">{{ $name }} ({{ $ticker }})</b><br>
            <small class="text-sm {{ $percentage >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                {{ $percentage }}% price return over {{ $chartPeriods[$currentChartPeriod] }}
            </small>
        </div>

        <div class="flex-1 flex justify-end xl:justify-center">
            <div class="hidden xl:block">
                @include('livewire.company-profile.overview-graph-filters')
            </div>

            <x-dropdown placement="bottom-end" class="block xl:hidden">
                <x-slot name="trigger">
                    <div class="p-2 flex items-center gap-x-2 border border-[#ECE9F1] text-[#686868] text-sm rounded">
                        <span class="capitalize">{{ $chartPeriods[$currentChartPeriod] ?? 'N/A' }}</span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.99479 9.33366L5.32812 6.66699H10.6615L7.99479 9.33366Z" fill="black" />
                        </svg>
                    </div>
                </x-slot>

                <div class="p-4">
                    @include('livewire.company-profile.overview-graph-filters')
                </div>
            </x-dropdown>
        </div>
    </div>

    <div class="place-items-center h-96" wire:loading.grid>
        <span class="mx-auto simple-loader !text-green-dark"></span>
    </div>

    <div class="mt-3" wire:loading.remove x-show="!hide" x-transition>
        <canvas id="product-profile-chart" class="w-full company-profile-overview-chart"></canvas>
    </div>
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
                tooltipEl.style.filter =
                    'drop-shadow(0px 10.732307434082031px 21.464614868164062px rgba(50, 50, 71, 0.06)) drop-shadow(0px 10.732307434082031px 10.732307434082031px rgba(50, 50, 71, 0.08))';
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
            const {
                chart,
                tooltip
            } = context;
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

            const {
                offsetLeft: positionX,
                offsetTop: positionY
            } = chart.canvas;

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
            let ctx = canvas.getContext("2d");
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
                maintainAspectRatio: false,
                aspectRatio: 3,
                responsive: true,
                type: 'bar',
                data: {
                    datasets: [{
                            data: data.dataset2,
                            label: "Volume",
                            borderColor: "#9D9D9D",
                            backgroundColor: 'rgba(255, 255, 255, 0)',
                            borderWidth: Number.MAX_VALUE,
                            borderRadius: 2,
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
                                title: function(context) {
                                    const inputDate = new Date(context[0].label);
                                    const month = inputDate.getMonth() + 1;
                                    const day = inputDate.getDate();
                                    const year = inputDate.getFullYear();
                                    return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                                },
                                label: function(context) {
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
                            min: data.y_axes_min,
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
                            ticks: {
                                source: 'data',
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

        window.addEventListener("resize", initChart);

        Livewire.on("companyChartReset", initChart);
    </script>
@endpushonce
