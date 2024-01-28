import chartJsPlugins, { formatCmpctNumber } from "../chartjs-plugins"

const tooltipConfig = {
    bodyFont: {
        size: 15,
    },
    external: chartJsPlugins.largeTooltip,
    enabled: false,
    position: "nearest",
    callbacks: {
        title: (context) => context[0].label,
        label: (context) => `${context.dataset.label}|${context.raw.y}`,
    },
}

const legendConfig = (show) => ({
    display: show,
    position: "bottom",
    align: "start",
    labels: {
        boxWidth: 12,
        boxHeight: 12,
    },
})

const dataLabelConfig = (formatter = null) => ({
    display: (ctx) => ctx.dataset?.type !== "line",
    anchor: "center",
    align: "center",
    formatter:
        formatter ||
        ((v) => {
            return Number(v.y).toFixed(2 ?? 0) + "%"
        }),
    font: {
        weight: 500,
        size: 12,
    },
})

const scales = (percentage = false, xOffset = true, reverseX) => ({
    y: {
        stacked: true,
        display: true,
        ticks: {
            callback: percentage ? (val) => val + "%" : formatCmpctNumber,
        },
    },
    x: {
        stacked: true,
        offset: xOffset,
        grid: {
            display: true,
        },
        align: "center",
        reverse: reverseX,
    },
})

function renderBasicChart(canvas, datasets, config) {
    if (config.type === "percentage") {
        datasets.forEach((dataset) => {
            dataset.data.map((value) => {
                value.y = value.percent
                return value
            })
        })

        return percentageBarChart(canvas, datasets, config)
    }

    datasets.forEach((dataset) => {
        dataset.data.map((value) => {
            value.y = value.value || value.y || 0
            return value
        })
    })

    return basicBarChart(canvas, datasets, config)
}

function renderSourcesAndUsesChart(canvas, datasets, config) {
    if (config.type === "percentage") {
        datasets.forEach((dataset) => {
            dataset.data.map((value) => {
                value.y = value.percent
                return value
            })
        })

        return percentageBarChart(canvas, datasets, config)
    }

    datasets.forEach((dataset) => {
        dataset.data.map((value) => {
            value.y = value.value || value.y || 0
            return value
        })
    })

    return basicBarChart(canvas, datasets, config)
}

function renderRevenueByEmployeeChart(canvas, datasets, config) {
    const ctx = canvas.getContext("2d")

    return new Chart(ctx, {
        plugins: [chartJsPlugins.pointLine],
        maintainAspectRatio: false,
        aspectRatio: 3,
        responsive: true,
        type: "bar",
        data: {
            datasets,
        },
        options: {
            interaction: {
                intersect: false,
                mode: "index",
            },
            title: {
                display: false,
            },
            plugins: {
                tooltip: tooltipConfig,
                legend: legendConfig(config.showLabel),
                pointLine: {
                    color: "#C22929",
                },
            },
            scales: {
                ...scales(false, true, config.reverse),
                y1: {
                    ticks: {
                        callback: (val) => val + "%",
                    },
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
}

function renderCostStructureChart(canvas, datasets, config) {
    const ctx = canvas.getContext("2d")

    datasets.forEach((dataset) => {
        dataset.data.map((value) => {
            if (dataset.yAxisID === "y1") {
                return value
            }

            value.y =
                (config.type === "percentage" ? value.percent : value.value) ||
                0
            return value
        })
    })

    return new Chart(ctx, {
        plugins: [window.ChartDataLabels, chartJsPlugins.pointLine],
        maintainAspectRatio: false,
        aspectRatio: 3,
        responsive: true,
        type: "bar",
        data: {
            datasets,
        },
        options: {
            interaction: {
                intersect: false,
                mode: "index",
            },
            title: {
                display: false,
            },
            plugins: {
                tooltip: tooltipConfig,
                legend: legendConfig(config.showLabel),
                datalabels: dataLabelConfig((v) => {
                    if (config.type === "percentage") {
                        return Number(v.y).toFixed(2 ?? 0) + "%"
                    }

                    return formatCmpctNumber(v.y)
                }),
                pointLine: {
                    color: "#ccc",
                },
            },
            scales: {
                ...scales(config.type === "percentage", true, config.reverse),
                y1: {
                    display: true,
                    ticks: {
                        callback: (val) => val + "%",
                    },
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
}

function renderFcfConversionChart(canvas, data, config) {
    const ctx = canvas.getContext("2d")

    return new Chart(ctx, {
        plugins: [window.ChartDataLabels, chartJsPlugins.pointLine],
        maintainAspectRatio: false,
        aspectRatio: 3,
        responsive: true,
        type: "bar",
        data: {
            datasets: data.datasets,
        },
        options: {
            interaction: {
                intersect: false,
                mode: "index",
            },
            title: {
                display: false,
            },
            plugins: {
                annotation: {
                    clip: false,
                    annotations: {
                        average: {
                            type: "line",
                            scaleID: "y",
                            value: data.avgFcf,
                            borderColor: "#828C85",
                            borderWidth: 2,
                            borderDash: [10, 10],
                            display: (ctx) => {
                                const chart = Object.getPrototypeOf(ctx)?.chart

                                if (!chart) return true

                                return !chart.legend.legendItems.find(
                                    (item) => item.text === "Free Cashflow $"
                                )?.hidden
                            },
                            label: {
                                display: true,
                                backgroundColor: "rgba(0,0,0,1)",
                                position: "end",
                                xAdjust: 10,
                                content: data.avgFcf.toFixed(2) + "%",
                                color: "#fff",
                            },
                        },
                    },
                },
                tooltip: tooltipConfig,
                legend: legendConfig(config.showLabel),
                datalabels: {
                    ...dataLabelConfig(),
                    formatter: (v, ctx) => {
                        if (ctx.dataset.label === "Free Cashflow $") {
                            return "$" + formatCmpctNumber(v.y)
                        }

                        return Number(v.y).toFixed(2 ?? 0) + "%"
                    },
                },
                pointLine: {
                    color: "#ffff",
                },
            },
            scales: {
                ...scales(true, true, config.reverse),
                y1: {
                    display: true,
                    ticks: {
                        callback: formatCmpctNumber,
                    },
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
}

function renderCapitalStructureChart(canvas, datasets, config) {
    const ctx = canvas.getContext("2d")

    return new Chart(ctx, {
        plugins: [chartJsPlugins.pointLine],
        maintainAspectRatio: false,
        aspectRatio: 3,
        responsive: true,
        type: "line",
        data: {
            datasets,
        },
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
                tooltip: tooltipConfig,
                legend: legendConfig(config.showLabel),
                pointLine: {
                    color: "#121A0F",
                },
            },
            scales: {
                ...scales(false, false, config.reverse),
                y1: {
                    ticks: {
                        callback: (val) => val + "%",
                    },
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
}

window.analysisPage = {
    renderBasicChart,
    renderRevenueByEmployeeChart,
    renderCostStructureChart,
    renderFcfConversionChart,
    renderCapitalStructureChart,
    renderSourcesAndUsesChart,
}

function basicBarChart(canvas, datasets, config) {
    const ctx = canvas.getContext("2d")

    return new Chart(ctx, {
        plugins: [],
        maintainAspectRatio: false,
        aspectRatio: 3,
        responsive: true,
        type: "bar",
        data: {
            datasets,
        },
        options: {
            interaction: {
                intersect: false,
                mode: "index",
            },
            title: {
                display: false,
            },
            plugins: {
                tooltip: tooltipConfig,
                legend: legendConfig(config.showLabel),
                ...(!config.lastIsAverage
                    ? {}
                    : {
                          annotation: {
                              annotations: {
                                  averageBar: {
                                      type: "box",
                                      backgroundColor: "rgba(0, 0, 0, 0)",
                                      borderWidth: 1,
                                      borderDash: [5, 5],
                                      xMax: datasets[0].data.length - 0.55,
                                      xMin: datasets[0].data.length - 1.45,
                                  },
                              },
                          },
                      }),
            },
            scales: scales(false, true, config.reverse),
        },
    })
}

function percentageBarChart(canvas, datasets, config = {}) {
    const ctx = canvas.getContext("2d")

    return new Chart(ctx, {
        plugins: [window.ChartDataLabels],
        maintainAspectRatio: false,
        aspectRatio: 3,
        responsive: true,
        type: "bar",
        data: {
            datasets,
        },
        options: {
            interaction: {
                intersect: false,
                mode: "index",
            },
            title: {
                display: false,
            },
            plugins: {
                tooltip: tooltipConfig,
                legend: legendConfig(config.showLabel),
                datalabels: dataLabelConfig(),
            },
            scales: scales(true, true, config.reverse),
        },
    })
}
