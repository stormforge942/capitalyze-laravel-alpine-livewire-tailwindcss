<template x-for="(data, metric) in dataGroupedByMetric">
    <div x-data="{
        chart: null,
        init() {
            this.initChart();
        },
        initChart() {
            if (!this.$refs.canvas) {
                return;
            }
    
            if (this.chart) {
                this.chart.destroy();
            }
    
            const chartColors = @js(config('capitalyze.chartColors'))
    
            let idx = 0;
    
            let datasets = [];
    
            Object.keys(data).forEach((company) => {
                let label = company + '-' + this.metricsMap[metric].title
                metricsColor[label] = chartColors[idx] || window.randomColor()

                datasets.push({
                    label: company + ' ' + this.metricsMap[metric].title,
                    data: this.selectedDates.map((date) => {
                        return {
                            x: date,
                            y: data[company][date] || null
                        }
                    }).filter((item) => item.y != null),
                    backgroundColor: metricsColor[label],
                    backgroundColor: metricsColor[label],
                    borderColor: metricsColor[label],
                    type: metricAttributes[metric]?.type || 'bar',
                    yAxisID: metricsMap[metric].yAxis || 'y',
                    shouldFormat: !metricsMap[metric].yAxis,
                })
    
                idx++;
            });
    
            datasets = datasets.filter(d => d.data.length)
    
            this.chart = new Chart(this.$refs.canvas, {
                type: 'bar',
                data: {
                    datasets,
                },
                plugins: [
                    window.ChartDataLabels,
                    chartJsPlugins.htmlLegend,
                ],
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    layout: {
                        padding: {
                            top: 25,
                        }
                    },
                    animation: {
                        duration: 0,
                    },
                    elements: {
                        line: {
                            tension: 0.2
                        }
                    },
                    plugins: {
                        tooltip: {
                            bodyFont: {
                                size: 15,
                            },
                            external: chartJsPlugins.largeTooltip,
                            enabled: false,
                            position: 'nearest',
                            callbacks: {
                                title: (context) => this.formatDate(context[0].raw.x),
                                label: (ctx) => {
                                    let y = this.formatValue(ctx.raw.y, ctx.dataset.shouldFormat)
    
                                    return `${ctx.dataset.label}|${y}`
                                },
                            },
                        },
                        legend: {
                            display: false,
                        },
                        datalabels: {
                            display: (c) => {
                                if (c.dataset.data[c.dataIndex].y === 0) {
                                    return false
                                }
    
                                return 'auto'
                            },
                            anchor: 'end',
                            align: 'top',
                            formatter: (v, ctx) => {
                                return this.formatValue(v.y, ctx.dataset.shouldFormat)
                            },
                            clip: false,
                            font: {
                                weight: 500,
                                size: 12,
                            },
                            color: (ctx) => '#121A0F',
                        },
                        htmlLegend: {
                            container: document.querySelector('.chart-legends'),
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            type: 'timeseries',
                            time: {
                                unit: this.filters.period === 'annual' ? 'year' : 'quarter',
                            },
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            display: datasets.some(d => d.yAxisID === 'y'),
                            beginAtZero: true,
                            ticks: {
                                callback: window.formatCmpctNumber,
                                padding: 10,
                            }
                        },
                        percent: {
                            ticks: {
                                callback: (val) => val + '%',
                            },
                            display: datasets.some(d => d.yAxisID === 'percent'),
                            position: 'right',
                            type: 'linear',
                            beginAtZero: false,
                            grid: {
                                drawOnChartArea: false,
                            },
                        },
                        ratio: {
                            display: datasets.some(d => d.yAxisID === 'ratio'),
                            position: 'right',
                            type: 'linear',
                            beginAtZero: false,
                            grid: {
                                drawOnChartArea: false,
                            },
                        },
                    }
                }
            })
        }
    }" @update-chart.window="$nextTick(() => initChart())">
        <p class="font-bold text-blue text-md" x-text="metricsMap[metric].title"></p>

        <div class="mt-4">
            <canvas class="h-[400px] w-full" x-ref="canvas"></canvas>
        </div>
    </div>
</template>
