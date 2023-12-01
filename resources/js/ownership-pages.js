import chartJsPlugins, { formatCmpctNumber } from "./chartjs-plugins"

export function initFundHistoryChart(canvas, data) {
    const ctx = canvas.getContext("2d")

    const chart = new Chart(ctx, {
        plugins: [chartJsPlugins.pointLine],
        maintainAspectRatio: false,
        aspectRatio: 2,
        responsive: true,
        type: "bar",
        data,
        options: {
            interaction: {
                intersect: false,
                mode: "index",
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                    tension: 0,
                },
            },
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    bodyFont: {
                        size: 15,
                    },
                    external: window.chartJsPlugins.largeTooltip,
                    enabled: false,
                    position: "nearest",
                    callbacks: {
                        title: function (context) {
                            const inputDate = new Date(context[0].label)
                            const month = inputDate.getMonth() + 1
                            const day = inputDate.getDate()
                            const year = inputDate.getFullYear()
                            return `${year}-${month
                                .toString()
                                .padStart(2, "0")}-${day
                                .toString()
                                .padStart(2, "0")}`
                        },
                        label: function (context) {
                            return `${context.dataset.label}|${
                                context.raw || "N/A"
                            }`
                        },
                    },
                },
            },
            scales: {
                y: {
                    stacked: true,
                    display: true,
                    ticks: {
                        callback: (val) => {
                            return formatCmpctNumber(val)
                        },
                    },
                },
                x: {
                    stacked: true,
                    offset: true,
                    grid: {
                        display: false,
                    },
                    type: "timeseries",
                    align: "center",
                },
                y1: {
                    stacked: true,
                    display: true,
                    position: "right",
                    type: "linear",
                    beginAtZero: false,
                    grid: {
                        drawOnChartArea: false,
                    },
                },
            },
        },
    })

    return chart
}

window.initFundHistoryChart = initFundHistoryChart
