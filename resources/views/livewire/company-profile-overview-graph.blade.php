<div class="main-graph-wrapper w-full" x-data="{ collapse: false ,showgraph:true}" >

    <div  :class="{ 'custom-dropdown-absolute-wrapper': !showgraph, 'custom-dropdown-absolute-wrapper abs-custom': showgraph }">
        <div class="relative custom-dropdown-absolute-wrapper-inner flex justify-end" x-data="{
            chartMenuOpen: false
        }">
            <div>
              <button type="button" @click="chartMenuOpen = !chartMenuOpen" class="custom-drop-down-button hide-mobile" id="menu-button" aria-expanded="true" aria-haspopup="true">

                <svg x-show="!chartMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="#121A0F" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                  </svg>

                <svg x-show="chartMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="#121A0F" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                  </svg>

              </button>
            </div>


            <div @click.away="chartMenuOpen = false" x-show="chartMenuOpen" class="absolute custom-drop-down right-0 z-10    bg-white  focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
              <div class="py-1" role="none">
                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
               <div class="links-wrapper mb-3">
                <a href="#" x-show="showgraph" @click="showgraph = !showgraph" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-0">Hide Chart</a>
                <a href="#" x-show="!showgraph" @click="showgraph = !showgraph" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-0">Show Chart</a>
                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-1">View In Full Screen</a>
                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-2">Print Chart</a>
               </div>
                <hr class="mb-3">
                <div class="links-wrapper">
                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-3"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                  </svg>
                    Download As PNG</a>
                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-4"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                  </svg>
                    Download As PNG</a>
                <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-5"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                  </svg>
                     Download As PNG</a>
                </div>
              </div>
            </div>
          </div>
    </div>
<div class="relative graph-wrapper-box w-full" >
    <div class="graph-wrapper">
        <div class="graph-header relative">
            <div class="pr-3" x-data="{percentage: '{{$persentage}}'}">
                <b class="title" wire:click="load()">{{ $name }}. ({{ $ticker }})</b><br>
                <small :class="percentage >= 0 ? 'text-blue-600' : 'text-red-600'">{{ $persentage }}% price return over
                    {{ $chartPeriods[$currentChartPeriod] }}</small>
            </div>
            <div >
                <div class="relative custom-dropdown-absolute-wrapper-inner mobile-show flex justify-end" x-data="{
                    openMobileGraph: false
                }">
                    <div>
                      <button  type="button" @click="openMobileGraph = !openMobileGraph" class="custom-drop-down-button-lg" id="menu-button" aria-expanded="true" aria-haspopup="true">
                        Select
                        <svg x-show="!openMobileGraph" xmlns="http://www.w3.org/2000/svg" fill="#121A0F" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                          </svg>



                          <svg x-show="openMobileGraph" xmlns="http://www.w3.org/2000/svg" fill="#121A0F" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                          </svg>


                      </button>
                    </div>


                    <div @click.away="openMobileGraph = false" x-show="openMobileGraph" class="absolute custom-drop-down right-0 z-10    bg-white  focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                      <div class="py-1" role="none">
                        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                       <div class="links-wrapper mb-3">

                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-1">View In Full Screen</a>
                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-2">Print Chart</a>
                       </div>
                        <hr class="mb-3">
                        <div class="links-wrapper">
                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-3"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                          </svg>
                            Download As PNG</a>
                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-4"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                          </svg>
                            Download As PNG</a>
                        <a href="#" class="menu_link" role="menuitem" tabindex="-1" id="menu-item-5"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                          </svg>
                             Download As PNG</a>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="select-graph-date-wrapper desktop-show ml-12 flex">
                <ul class="items-center w-full flex">
                    <li class="w-full mr-6">
                        <input wire:model="currentChartPeriod" value="3m" id="date-3m" type="radio"
                            name="date-range" name="radio-group" checked>
                        <label for="date-3m">3m</label>
                    </li>
                    <li class="w-full mr-6">
                        <input wire:model="currentChartPeriod" value="6m" id="date-6m" type="radio"
                            name="date-range" name="radio-group" checked>
                        <label for="date-6m">6m</label>
                    </li>
                    <li class="w-full mr-6">
                        <input wire:model="currentChartPeriod" value="YTD" id="date-1yr" type="radio"
                            name="date-range">
                        <label for="date-1yr">YTD</label>
                    </li>
                    <li class="w-full mr-6">
                        <input wire:model="currentChartPeriod" value="1yr" id="date-1yr2" type="radio"
                            name="date-range">
                        <label for="date-1yr2">1yr</label>
                    </li>
                    <li class="w-full mr-6">
                        <input wire:model="currentChartPeriod" value="5yr" id="date-5yr" type="radio"
                            name="date-range">
                        <label for="date-5yr">5yr</label>
                    </li>
                    <li class="w-full mr-6">
                        <input wire:model="currentChartPeriod" value="max" id="date-5yr2" type="radio"
                            name="date-range">
                        <label for="date-5yr2">MAX</label>
                    </li>
                </ul>
                <livewire:range-calendar />
            </div>

           </div>
        <div class="place-items-center h-96" wire:loading.grid>
            <span class="mx-auto simple-loader !text-green-dark"></span>
        </div>

        <div class="mt-3" wire:loading.remove x-show="showgraph" x-transition>
            <canvas id="product-profile-chart" class="w-full company-profile-overview-chart"></canvas>
        </div>
    </div>
    <div style="margin-bottom: 2em" x-show="collapse" x-cloak></div>
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
