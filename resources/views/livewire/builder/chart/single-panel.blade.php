<div x-data="{
    chart: null,
    init() {
        this.initChart()
    },

    initChart() {
        if (!this.$refs.canvas) {
            return
        }

        let datasets = []

        if (this.chart) {
            try {
                this.chart.destroy();
            } catch (e) {
                console.error(e);
            }
        }

        const chartColors = @js(config('capitalyze.chartColors'))

        let idx = 0
        Object.entries(this.data).forEach(([company, metrics]) => {
            Object.entries(metrics).forEach(([metric, timeline]) => {
                let label = company + '-' + this.metricsMap[metric].title

                datasets.push({
                    label,
                    data: this.dates.map(date => {
                        return {
                            x: date,
                            y: timeline[date] || null
                        }
                    }).filter((item) => item.y !== null),
                    backgroundColor: chartColors[idx++] || window.randomColor(),
                })
            })
        })

        const ctx = this.$refs.canvas.getContext('2d')

        this.chart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets,
            },
            plugins: [
                window.ChartDataLabels
            ],
            options: {
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
                                let y = formatValue(context.raw.y)

                                return `${context.dataset.label}|${y}`
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
                        formatter: (v) => {
                            return this.formatValue(v.y)
                        },
                        clip: false,
                        font: {
                            weight: 500,
                            size: 12,
                        },
                        color: (ctx) => '#121A0F',
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
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
                        beginAtZero: true,
                        ticks: {
                            callback: window.formatCmpctNumber,
                            padding: 10,
                        }
                    }
                }
            }
        })
    }
}" @update-chart.window="$nextTick(() => initChart())">
    <canvas class="h-[500px] w-full" x-ref="canvas">
    </canvas>
</div>
