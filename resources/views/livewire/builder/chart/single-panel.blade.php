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
                            title: (context) => {
                                if (this.period == 'annual') {
                                    return context[0].raw.x.split('-')[0]
                                }

                                let title = new Intl.DateTimeFormat('en-US', {
                                    month: 'short',
                                    year: 'numeric'
                                }).format(new Date(context[0].raw.x))

                                const [month, year] = title.split(' ')

                                const quarter = {
                                    'Jan': 'Q1',
                                    'Apr': 'Q2',
                                    'Jul': 'Q3',
                                    'Oct': 'Q4',
                                } [month]

                                return `${quarter} ${year}`
                            },
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
                            unit: this.period === 'annual' ? 'year' : 'quarter',
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
