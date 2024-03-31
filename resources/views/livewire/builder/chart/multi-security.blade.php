<div @update-chart.window="usedColors = {}">
    <template x-for="(metrics, company) in data">
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
        
                let datasets = [];
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
        
                Object.keys(metrics).forEach((key) => {
                    if (!metricAttributes[key]?.show) {
                        return;
                    }
        
                    const data = metrics[key];
                    const metric = this.metricsMap[key];
        
                    const label = company + '-' + metric.title
        
                    const color = getColor('ms', label)
        
                    const type = metricAttributes[key]?.type === 'line' ? 'line' : 'bar';
        
                    const isStacked = metricAttributes[key]?.type === 'stacked-bar';
        
                    datasets.push({
                        label: metric.title,
                        data: this.selectedDates.map((date) => {
                            return {
                                x: date,
                                y: data[date] || null
                            }
                        }).filter((item) => item.y != null),
                        backgroundColor: color,
                        borderColor: color,
                        type,
                        yAxisID: addAxis(this.metricsMap[key].yAxis || 'y', key, metricAttributes[key]?.sAxis),
                        shouldFormat: !metric.yAxis,
                        ...(isStacked ? { stack: this.metricsMap[key].yAxis || 'y' } : {}),
                    })
                });
        
                // bring line chart to front
                datasets = datasets.sort((a, b) => {
                    if (a.type === 'line') {
                        return -1;
                    }
                    return 1;
                });
        
                datasets = datasets.filter(d => d.data.length)
        
                this.chart = new Chart(this.$refs.canvas, {
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
                                    if (!showLabel || c.dataset.data[c.dataIndex].y === 0) {
                                        return false
                                    }
        
                                    return 'auto'
                                },
                                anchor: (ctx) => ctx.dataset.stack ? 'center' : 'end',
                                align: (ctx) => ctx.dataset.stack ? 'center' : 'end',
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
                            ...axes
                        }
                    }
                })
            }
        }" @update-chart.window="$nextTick(() => initChart())">
            <p class="font-bold text-blue text-md" x-text="company"></p>

            <div class="mt-4">
                <canvas class="h-[400px] w-full" x-ref="canvas"></canvas>
            </div>
        </div>
    </template>
</div>
