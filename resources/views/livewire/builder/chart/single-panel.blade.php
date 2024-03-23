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
            plugins: [],
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
                            title: (context) => context[0].label,
                            label: (context) => {
                                let y = context.raw.y

                                return `${context.dataset.label}|${y}`
                            },
                        },
                    },
                    legend: {
                        display: false,
                    },
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        type: 'timeseries',
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        beginAtZero: false,
                        ticks: {
                            callback: window.formatCmpctNumber
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
