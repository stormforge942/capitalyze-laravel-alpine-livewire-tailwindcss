<div x-data="{
    isReset: false,
    count: 0,
    reset() {
        if (this.count === Object.keys(dataGroupedByMetric).length) {
            this.isReset = false;
            this.count = 0;
        }

        this.count++;

        if (this.isReset) {
            return;
        }

        this.isReset = true;
        usedColors = {}
    }
}" class="space-y-3">
    <template x-for="(data, metric) in dataGroupedByMetric" :key="metric">
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
        
                Object.keys(data).forEach((company) => {
                    if (!metricAttributes[metric]?.show) {
                        return
                    }
        
                    let label = company + ' - ' + this.metricsMap[metric].title
        
                    const color = getColor('mm', label)
        
                    const type = metricAttributes[metric]?.type === 'line' ? 'line' : 'bar';
        
                    const isStacked = metricAttributes[metric]?.type === 'stacked-bar';
        
                    datasets.push({
                        label,
                        data: this.selectedDates.map((date) => {
                            return {
                                x: date,
                                y: data[company][date] || null
                            }
                        }).filter((item) => item.y != null),
                        backgroundColor: color,
                        borderColor: color,
                        type,
                        yAxisID: metricsMap[metric].yAxis || 'y',
                        shouldFormat: !['percent', 'ratio'].includes(metricsMap[metric].yAxis),
                        ...(isStacked ? { stack: this.metricsMap[metric].yAxis || 'y' } : {}),
                    })
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
                                    if (!showLabel || c.dataset.data[c.dataIndex].y === 0) {
                                        return false
                                    }
        
                                    return 'auto'
                                },
                                anchor: (ctx) => ctx.dataset.stack ? 'center' : 'end',
                                align: (ctx) => ctx.dataset.stack ? 'center' : 'end',
                                formatter: (v, ctx) => {
                                    return this.formatValue(v.y, ctx.dataset.shouldFormat)
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
                            y: {
                                grid: {
                                    display: false
                                },
                                position: 'right',
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
                                beginAtZero: true,
                                grid: {
                                    drawOnChartArea: false,
                                },
                            },
                            ratio: {
                                display: datasets.some(d => d.yAxisID === 'ratio'),
                                position: 'right',
                                type: 'linear',
                                beginAtZero: true,
                                grid: {
                                    drawOnChartArea: false,
                                },
                            },
                        }
                    }
                })
            }
        }" @update-chart.window="$nextTick(() => {reset(); initChart()})">
            <p class="font-bold text-blue text-md" x-text="metricsMap[metric].title"></p>

            <div class="mt-4 h-[400px]">
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>
    </template>
</div>
