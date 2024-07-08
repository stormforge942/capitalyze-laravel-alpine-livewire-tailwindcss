<div>
    <h2 class="text-md font-semibold">Summary of selected Favorites</h2>

    <div class="mt-2.5 bg-white rounded-lg py-4 px-6">
        <div>
            <div class="flex items-center gap-x-8">
                <button>
                    13F Filers
                </button>

                <button>
                    N-PORT Filers
                </button>
            </div>
        </div>

        <x-tabs class="mt-5" :tabs="['Top Buys', 'Top Sells', 'New Buys', 'Top Holdings']">
            <div>
                @foreach (['topBuy', 'topSell'] as $idx => $dataLabel)
                    <div x-show="active === {{ $idx }}" x-data="{
                        data: @js($topBuys),
                        activeRow: 0,
                        period: '1yr',
                        chart: {
                            loading: false,
                            initial: true,
                            data: [],
                        },
                        updateActiveRow(idx) {
                            this.activeRow = idx;
                            this.$nextTick(() => {
                                this.makeChart();
                            });
                        },
                        makeChart() {
                            this.chart.loading = true;
                            this.chart.data = [];
                    
                            return window.http(`/company/${this.activeRowData.symbol}/eod_prices`)
                                .then(res => res.json())
                                .then(data => {
                                    this.chart.data = data.map(item => ({
                                        x: item.date,
                                        y: Number(item.adj_close),
                                        periods: item.periods,
                                        formatted_value: item.formatted_value,
                                    }));
                    
                                    this.renderChart();
                                })
                                .finally(() => {
                                    this.chart.initial = false;
                                    this.chart.loading = false;
                                })
                        },
                        renderChart() {
                            const data = this.chart.data.filter(item => item.periods.includes(this.period))
                    
                            if (window.chart_{{ $dataLabel }}) {
                                window.chart_{{ $dataLabel }}.data.datasets[0].data = JSON.parse(JSON.stringify(data));
                                window.chart_{{ $dataLabel }}.update();
                                return;
                            }
                    
                            const canvas = document.getElementById('tbs-{{ $dataLabel }}');
                            if (!canvas) return;
                    
                            const ctx = canvas.getContext('2d');
                    
                            const gradientBg = ctx.createLinearGradient(0, 0, 0, canvas.height * 2.5)
                            gradientBg.addColorStop(0, 'rgba(19,176,91, 0.18)')
                            gradientBg.addColorStop(1, 'rgba(19,176,91, 0)')
                    
                            window.chart_{{ $dataLabel }} = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    datasets: [{
                                        label: 'Price',
                                        data,
                                        borderColor: '#52D3A2',
                                        backgroundColor: gradientBg,
                                        fill: true,
                                        tension: 0.4,
                                        pointRadius: 0,
                                        pointHoverRadius: 6,
                                        pointHoverBackgroundColor: '#52D3A2',
                                        pointHoverBorderWidth: 4,
                                        pointHoverBorderColor: '#fff',
                                    }]
                                },
                                options: {
                                    maintainAspectRatio: false,
                                    responsive: true,
                                    interaction: {
                                        intersect: false,
                                        mode: 'index',
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        annotation: false,
                                        addLogo: false,
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
                                                    return `Price|${context.raw.formatted_value}`;
                                                }
                                            },
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: {
                                                display: false
                                            },
                                            ticks: {
                                                maxTicksLimit: 6,
                                            },
                                            type: 'time',
                                        },
                                        y: {
                                            display: false
                                        }
                                    }
                                }
                            });
                        }
                    }">
                        <template x-for="(item, idx) in data" :key="idx">
                            <div class="px-2 grid grid-cols-[repeat(5,1fr)] gap-x-2 cursor-pointer transition-all rounded"
                                @click.prevent="updateActiveRow(idx)"
                                :class="activeRow == idx ? 'bg-green-light4' : 'hover:bg-gray-100'">
                                <div class="py-1 text-dark-light2" x-text="item.fund_name">
                                </div>
                                <div class="py-1" x-text="item.name_of_issuer">
                                </div>
                                <div class="py-1 text-right font-medium">
                                    <span :class="item.change < 0 ? 'text-red' : ''"
                                        x-text="item.change < 0 ? `(${item.formatted_value})` : item.formatted_value"
                                        :data-tooltip-content="item.change"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                @endforeach
            </div>
        </x-tabs>
    </div>
</div>
