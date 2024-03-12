<div x-data="{
    chart: null,
    init() {
        this.initChart()
    },

    initChart() {
        let datasets = []

        const canvas = this.$el.querySelector('canvas');

        if (this.chart) {
            this.chart.destroy();
        }

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
                })
            })
        })

        console.log(datasets)

        this.chart = new Chart(canvas, {
            type: 'bar',
            data: {
                datasets,
            },
            options: {
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
    <canvas class="h-[500px] w-full">
    </canvas>
</div>
