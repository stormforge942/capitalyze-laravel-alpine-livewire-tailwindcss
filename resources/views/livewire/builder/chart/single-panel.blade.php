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

        usedColors = {};

        let datasets = []
        const axes = {}

        function addAxis(axis, metric, isExtra = false) {
            const axisMap = {
                y: {
                    grid: {
                        display: false
                    },
                    position: 'right',
                    beginAtZero: true,
                    ticks: {
                        callback: window.formatCmpctNumber,
                    }
                },
                percent: {
                    ticks: {
                        callback: (val) => val + '%',
                    },
                    display: true,
                    position: 'right',
                    type: 'linear',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false,
                    },
                },
                ratio: {
                    display: true,
                    position: 'right',
                    type: 'linear',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false,
                    },
                },
            }

            let value = axisMap[axis]

            if (isExtra) {
                axis = axis + '-' + metric
            }

            axes[axis] = value

            return axis
        }

        Object.entries(this.data).forEach(([company, metrics]) => {
            Object.entries(metrics).forEach(([metric, timeline]) => {
                if (!metricAttributes[metric]?.show) {
                    return
                }

                let label = company + ' - ' + this.metricsMap[metric].title

                const color = getColor(label)

                const type = metricAttributes[metric]?.type === 'line' ? 'line' : 'bar';

                const isStacked = metricAttributes[metric]?.type === 'stacked-bar';

                const yAxisID = addAxis(this.metricsMap[metric].yAxis || 'y', metric, metricAttributes[metric]?.sAxis);

                datasets.push({
                    label,
                    data: this.selectedDates.map(date => {
                        return {
                            x: date,
                            y: timeline[date] || null
                        }
                    }).filter((item) => item.y != null),
                    backgroundColor: color,
                    borderColor: color,
                    type,
                    yAxisID,
                    shouldFormat: !['ratio', 'percent'].includes(this.metricsMap[metric].yAxis),
                    ...(isStacked ? { stack: yAxisID } : {}),
                })
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
                            title: (ctx) => this.formatDate(ctx[0].raw.x),
                            label: (ctx) => {
                                const y = formatValue(ctx.raw.y, ctx.dataset.shouldFormat)

                                return `${ctx.dataset.label}|${y}`
                            },
                        },
                    },
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        display: (c) => {
                            if (!this.showLabel || c.dataset.data[c.dataIndex].y === 0) {
                                return false
                            }

                            return 'auto'
                        },
                        anchor: (ctx) => ctx.dataset.stack ? 'center' : 'end',
                        align: (ctx) => ctx.dataset.stack ? 'center' : 'end',
                        formatter: (v, ctx) => {
                            return formatValue(v.y, ctx.dataset.shouldFormat)
                        },
                        clip: false,
                        font: {
                            weight: 500,
                            size: 12,
                        },
                        color: (ctx) => ctx.dataset.stack ? '#fff' : '#121A0F',
                    },
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
                    ...axes,
                }
            }
        })
    }
}" @update-chart.window="$nextTick(() => initChart())" class="h-[400px]">
    <canvas x-ref="canvas">
    </canvas>
</div>
