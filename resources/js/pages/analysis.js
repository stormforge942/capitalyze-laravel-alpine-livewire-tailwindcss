import chartJsPlugins, {
    formatCmpctNumber,
    formatNumber,
} from "../chartjs-plugins"

const tooltipConfig = (config) => ({
    bodyFont: {
        size: 15,
    },
    external: chartJsPlugins.largeTooltip,
    enabled: false,
    position: "nearest",
    callbacks: {
        title: (context) => context[0].label,
        label: (context) => {
            let y = context.raw.y

            if (
                (config.type !== "percentage" &&
                    context?.dataset?.dataType !== "percentage") ||
                context?.dataset?.dataType === "value"
            ) {
                y = String(formatNumber(y, config.number))
            }

            return `${context.dataset.label}|${y}`
        },
    },
})

const legendConfig = () => ({
    display: true,
    position: "bottom",
    align: "start",
    labels: {
        boxWidth: 12,
        boxHeight: 12,
    },
})

const dataLabelConfig = (config) => ({
    display: (c) => {
        if (config.showLabel === false) return false

        if (c.dataset.data[c.dataIndex].y === 0) {
            return false
        }

        return "auto"
    },
    anchor: "center",
    align: "center",
    formatter: (v) => {
        return Number(v.y).toFixed(config.number.decimalPlaces) + "%"
    },
    font: {
        weight: 500,
        size: 12,
    },
    color: (ctx) => (ctx.dataset?.type !== "line" ? "#fff" : "#121A0F"),
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

    datasets.forEach((dataset) => {
        if (dataset.type !== "line") {
            dataset.maxBarThickness = 150
        }
    })

    return new Chart(ctx, {
        plugins: [chartJsPlugins.pointLine, window.ChartDataLabels],
        type: "bar",
        data: {
            datasets,
        },
        options: {
            animation: {
                duration: 0,
            },
            maintainAspectRatio: false,
            responsive: true,
            interaction: {
                intersect: false,
                mode: "index",
                axis: "xy",
            },
            title: {
                display: false,
            },
            plugins: {
                tooltip: tooltipConfig(config),
                legend: legendConfig(),
                pointLine: {
                    color: "#C22929",
                },
                datalabels: {
                    ...dataLabelConfig(config),
                    formatter: (v, ctx) => {
                        if (ctx.dataset.type === "line") {
                            return (
                                Number(v.y).toFixed(
                                    config.number.decimalPlaces
                                ) + "%"
                            )
                        }

                        return formatNumber(v.y, config.number)
                    },
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

            if (dataset.type !== "line") {
                dataset.maxBarThickness = 150
            }

            return value
        })
    })

    return new Chart(ctx, {
        plugins: [window.ChartDataLabels, chartJsPlugins.pointLine],
        type: "bar",
        data: {
            datasets,
        },
        options: {
            animation: {
                duration: 0,
            },
            maintainAspectRatio: false,
            responsive: true,
            interaction: {
                intersect: false,
                mode: "index",
                axis: "xy",
            },
            title: {
                display: false,
            },
            plugins: {
                tooltip: tooltipConfig(config),
                legend: legendConfig(),
                datalabels: {
                    ...dataLabelConfig(config),
                    formatter: (v, ctx) => {
                        if (
                            config.type === "percentage" ||
                            ctx.dataset.type === "line"
                        ) {
                            return (
                                Number(v.y).toFixed(
                                    config.number.decimalPlaces
                                ) + "%"
                            )
                        }

                        return formatNumber(v.y, config.number)
                    },
                },
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

    data.datasets.forEach((dataset) => {
        if (dataset.type !== "line") {
            dataset.maxBarThickness = 150
        }
    })

    return new Chart(ctx, {
        plugins: [window.ChartDataLabels, chartJsPlugins.pointLine],
        type: "bar",
        data: {
            datasets: data.datasets,
        },
        options: {
            animation: {
                duration: 0,
            },
            maintainAspectRatio: false,
            responsive: true,
            interaction: {
                intersect: false,
                mode: "index",
                axis: "xy",
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
                                content:
                                    data.avgFcf.toFixed(
                                        config.number.decimalPlaces
                                    ) + "%",
                                color: "#fff",
                            },
                        },
                    },
                },
                tooltip: tooltipConfig(config),
                legend: legendConfig(),
                datalabels: {
                    ...dataLabelConfig(config),
                    formatter: (v, ctx) => {
                        return ctx.dataset.type === "line"
                            ? formatNumber(v.y, config.number)
                            : Number(v.y).toFixed(config.number.decimalPlaces) +
                                  "%"
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
        plugins: [chartJsPlugins.pointLine, window.ChartDataLabels],
        type: "line",
        data: {
            datasets,
        },
        options: {
            animation: {
                duration: 0,
            },
            maintainAspectRatio: false,
            responsive: true,
            interaction: {
                intersect: false,
                mode: "index",
                axis: "xy",
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
                tooltip: tooltipConfig(config),
                legend: legendConfig(),
                pointLine: {
                    color: "#121A0F",
                },
                datalabels: {
                    ...dataLabelConfig(config),
                    formatter: (v, ctx) => {
                        if (ctx.dataset.label === "Net Debt / Capital") {
                            return (
                                Number(v.y).toFixed(
                                    config.number.decimalPlaces
                                ) + "%"
                            )
                        }

                        return formatNumber(v.y, config.number)
                    },
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

    datasets.forEach((dataset) => {
        if (dataset.type !== "line") {
            dataset.maxBarThickness = 150
        }
    })

    return new Chart(ctx, {
        plugins: [window.ChartDataLabels],
        type: "bar",
        data: {
            datasets,
        },
        options: {
            animation: {
                duration: 0,
            },
            maintainAspectRatio: false,
            responsive: true,
            interaction: {
                intersect: false,
                mode: "index",
                axis: "xy",
            },
            title: {
                display: false,
            },
            plugins: {
                tooltip: tooltipConfig(config),
                datalabels: {
                    ...dataLabelConfig(config),
                    formatter: (v) => formatNumber(v.y, config.number),
                },
                legend: legendConfig(),
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

    datasets.forEach((dataset) => {
        if (dataset.type !== "line") {
            dataset.maxBarThickness = 150
        }
    })

    return new Chart(ctx, {
        plugins: [window.ChartDataLabels],
        type: "bar",
        data: {
            datasets,
        },
        options: {
            animation: {
                duration: 0,
            },
            maintainAspectRatio: false,
            responsive: true,
            interaction: {
                intersect: false,
                mode: "index",
                axis: "xy",
            },
            title: {
                display: false,
            },
            plugins: {
                tooltip: tooltipConfig(config),
                legend: legendConfig(),
                datalabels: dataLabelConfig(config),
            },
            scales: scales(true, true, config.reverse),
        },
    })
}
