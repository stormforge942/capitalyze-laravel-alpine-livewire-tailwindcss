<div x-data="{
    chart: null,
    init() {
        this.initChart()
    },

    initChart() {
        if (!this.$refs.canvas) {
            return
        }

        if (this.chart) {
            this.chart.destroy();
        }

        const chartColors = @js(config('capitalyze.chartColors'))

        let idx = 0

        let datasets = []

        Object.entries(this.data).forEach(([company, metrics]) => {
            Object.entries(metrics).forEach(([metric, timeline]) => {
                if (!metricAttributes[metric]?.show) {
                    return
                }

                let label = company + '-' + this.metricsMap[metric].title
                metricsColor.sp[label] = metricsColor.sp[label] || chartColors[idx] || window.randomColor()

                datasets.push({
                    label,
                    data: this.selectedDates.map(date => {
                        return {
                            x: date,
                            y: timeline[date] || null
                        }
                    }).filter((item) => item.y != null),
                    backgroundColor: metricsColor.sp[label],
                    borderColor: metricsColor.sp[label],
                    type: metricAttributes[metric]?.type || 'bar',
                    yAxisID: this.metricsMap[metric].yAxis || 'y',
                    shouldFormat: !this.metricsMap[metric].yAxis,
                })

                idx++
            })
        })

        // bring line chart to front
        datasets = datasets.sort((a, b) => {
            if (a.type === 'line') {
                return -1;
            }
            return 1;
        });

        datasets = datasets.filter(d => d.data.length)

        const ctx = this.$refs.canvas.getContext('2d')

        this.chart = new Chart(ctx, {
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
                            label: (context) => {
                                let y = context.dataset.shouldFormat ? formatValue(context.raw.y) : Number(context.raw.y).toFixed(this.filters.decimalPlaces)

                                return `${context.dataset.label}|${y}`
                            },
                        },
                    },
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        display: (c) => {
                            if (!this.showLabel) {
                                return false
                            }

                            if (c.dataset.data[c.dataIndex].y === 0) {
                                return false
                            }

                            return 'auto'
                        },
                        anchor: 'end',
                        align: 'top',
                        formatter: (v, ctx) => {
                            if (ctx.dataset.shouldFormat) {
                                return this.formatValue(v.y)
                            }

                            return Number(v.y).toFixed(this.filters.decimalPlaces)
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
                        enableClick: false,
                        rounded: true,
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
                        beginAtZero: false,
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
    <canvas class="h-[500px] w-full" x-ref="canvas">
    </canvas>
</div>
