<template x-for="(metrics, company) in data">
    <div x-data="{
        chart: null,
        init() {
            this.initChart();
        },
        initChart() {
            if(!this.$refs.canvas) {
                return;
            }

            const chartColors = @js(config('capitalyze.chartColors'))

            let datasets = [];
            let idx = 0;

            Object.keys(metrics).forEach((key) => {
                const data = metrics[key];
                const metric = this.metricsMap[key];

    
                datasets.push({
                    label: metric.title,
                    data: this.dates.map((date) => {
                        return {
                            x: date,
                            y: data[date] || null
                        }
                    }).filter((item) => item.y !== null),
                    type: metric.type || 'bar',
                    backgroundColor: chartColors[idx] || window.randomColor(),
                    borderColor: chartColors[idx] || window.randomColor(),
                })

                idx++;
            });

            // bring line chart to front
            datasets = datasets.sort((a, b) => {
                if (a.type === 'line') {
                    return -1;
                }
                return 1;
            });
    
            if (this.chart) {
                this.chart.destroy();
            }
    
            this.chart = new Chart(this.$refs.canvas, {
                type: 'bar',
                data: {
                    datasets,
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    elements: {
                        line: {
                            tension: 0.2
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
        <p class="font-bold text-blue text-md" x-text="company"></p>

        <div class="mt-4">
            <canvas class="h-[400px] w-full" x-ref="canvas"></canvas>
        </div>
    </div>
</template>
