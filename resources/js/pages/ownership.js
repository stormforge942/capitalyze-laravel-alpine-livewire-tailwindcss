import chartJsPlugins from "../chartjs-plugins"
import { formatCmpctNumber } from "../utils"

export function updateQueryParam(key, value) {
    const url = new URL(window.location.href)

    if (value) {
        url.searchParams.set(key, value)
    } else {
        url.searchParams.delete(key)
    }

    window.history.replaceState({}, "", url)
}

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
                pointLine: {
                    color: "#C22929",
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
                            return context[0].label
                        },
                        label: function (context) {
                            return `${context.dataset.label}|${context.raw}`
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

window.updateQueryParam = updateQueryParam

window.ownership = {
    initFundHistoryChart,
}
