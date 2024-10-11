<div x-data="{
    hide: false,
    printChart() {
        window.printChart(this.$el.querySelector('canvas'))
    }
}" @download-chart="Livewire.emit('modal.open', 'upgrade-account-modal')"
    @print-chart="printChart" @full-screen="fullScreen($el.querySelector('canvas').parentElement)">
    <div class="flex justify-end" x-show="hide" x-cloak @click="hide = false">
        <button class="bg-green-light flex items-center text-sm font-medium gap-3 pl-10 p-2"
            style="border-radius: 0 8px 2px 2px;">
            <span>Show Chart</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path
                    d="M10.3083 6.19514L7.72167 8.78378L5.135 6.19514C5.01045 6.07021 4.84135 6 4.665 6C4.48865 6 4.31955 6.07021 4.195 6.19514C3.935 6.45534 3.935 6.87566 4.195 7.13585L7.255 10.1982C7.515 10.4584 7.935 10.4584 8.195 10.1982L11.255 7.13585C11.515 6.87566 11.515 6.45534 11.255 6.19514C10.995 5.94161 10.5683 5.93494 10.3083 6.19514Z"
                    fill="#121A0F"></path>
            </svg>
        </button>
    </div>

    <div class="bg-white px-4 py-6 md:px-6 rounded-lg relative" x-show="!hide" x-transition>
        <div class="absolute top-2 right-2 xl:top-3 2xl:right-5">
            <x-dropdown placement="bottom-start" :shadow="true">
                <x-slot name="trigger">
                    <svg :class="open ? `rotate-90` : ''" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 21.998L15 21.998C20 21.998 22 19.998 22 14.998L22 8.99805C22 3.99805 20 1.99805 15 1.99805L9 1.99805C4 1.99805 2 3.99805 2 8.99805L2 14.998C2 19.998 4 21.998 9 21.998Z"
                            stroke="#121A0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="12" cy="8" r="1" fill="#121A0F" />
                        <circle cx="12" cy="12" r="1" fill="#121A0F" />
                        <circle cx="12" cy="16" r="1" fill="#121A0F" />
                    </svg>
                </x-slot>

                <x-chart-options></x-chart-options>
            </x-dropdown>
        </div>

        <div class="flex items-center gap-x-5">
            <div>
                <b class="font-extrabold">{{ $name }} ({{ $ticker }})</b><br>
                <small class="inline-block w-48 whitespace-nowrap text-sm {{ $percentage >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                    {{ $percentage }}% price return over {{ $chartPeriods[$currentChartPeriod] }}
                </small>
            </div>

            <div class="flex-1 flex justify-end xl:justify-center" x-data="{
                dateRange: $wire.entangle('dateRange'),
                currentChartPeriod: $wire.entangle('currentChartPeriod'),
                showDropdown: false,
                init() {
                    this.$watch('dateRange', value => {
                        this.showDropdown = false
                    })
            
                    this.$watch('currentChartPeriod', value => {
                        this.showDropdown = false
                    })
                },
            }">
                <div class="hidden xl:block">
                    @include('livewire.company-profile.overview-graph-filters')
                </div>

                <x-dropdown placement="bottom-end" class="block xl:hidden" x-model="showDropdown">
                    <x-slot name="trigger">
                        <div
                            class="p-2 mr-5 flex items-center gap-x-2 border border-[#ECE9F1] text-[#686868] text-sm rounded">
                            <span
                                class="capitalize whitespace-nowrap">{{ $chartPeriods[$currentChartPeriod] ?? 'N/A' }}</span>
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

        <div class="mt-3 place-items-center h-[300px]" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div class="mt-3 h-[300px]" wire:loading.remove>
            <canvas id="product-profile-chart"></canvas>
        </div>
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

        function initChart() {
            if (chart) chart.destroy();

            const canvas = document.getElementById("product-profile-chart");
            if (!canvas) return;

            let data = @this.chartData;

            const ctx = canvas.getContext("2d");
            const gradientBg = ctx.createLinearGradient(0, 0, 0, canvas.height * 2.5)
            gradientBg.addColorStop(0.8, 'rgba(19,176,91,0.18)')
            gradientBg.addColorStop(1, 'rgba(19,176,91,0.05)')

            const minPrice = Math.min(...data.dataset1.map(i => i.y))
            
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
                            yAxisID: 'y1',
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
                    maintainAspectRatio: false,
                    responsive: true,
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
                            external: window.chartJsPlugins.largeTooltip,
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
                            min: minPrice - 0.05 * minPrice,
                            ticks: {
                                crossAlign: "far",
                            }
                        },
                        x: {
                            offset: false,
                            grid: {
                                display: false,
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
                        y1: {
                            display: false,
                            position: "right",
                            type: "linear",
                            beginAtZero: true,
                            max: Math.max(...data.dataset2.map(i => i.y)) * 7
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', initChart);

        Livewire.on("companyChartReset", initChart);
    </script>
@endpushonce
