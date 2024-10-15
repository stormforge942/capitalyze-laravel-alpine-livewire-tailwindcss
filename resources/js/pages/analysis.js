import chartJsPlugins from "../chartjs-plugins"
import {
    formatCmpctNumber,
    formatNumber,
    roundDownToLowerSignificant,
    roundUpToHigherSignificant,
} from "../utils"

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

const dataLabelConfig = (config) => ({
    display: (c) => {
        if (config.showLabel === false) return false

        if (c.dataset.data[c.dataIndex].y === 0) {
            return false
        }

        return "auto"
    },
    anchor: "center",
    align: (ctx) => (ctx.dataset?.type !== "line" ? "center" : "end"),
    formatter: (v) => {
        return Number(v.y).toFixed(config.number.decimalPlaces) + "%"
    },
    font: {
        weight: 500,
        size: 12,
    },
    color: (ctx) => (ctx.dataset?.type !== "line" ? "#fff" : "#121A0F"),
})

const setScalesRange = (scale, scaleName, min, max) => {
    scale[scaleName].min = min;
    scale[scaleName].max = max;

    return scale;
}

const adjustSignificantValues = (values) => {
    return values.map(value => ({
        max: roundUpToHigherSignificant(value.max),
        min: value.min < 0
            ? roundUpToHigherSignificant(value.min)
            : roundDownToLowerSignificant(value.min)
    }));
}

const scales = (percentage = false, xOffset = true, reverseX) => ({
    y: {
        afterFit(scale) {
            scale.width = 50;
        },
        stacked: true,
        display: true,
        ticks: {
            callback: percentage ? (val) => val + "%" : formatCmpctNumber,
        },
        max: percentage ? 100 : null,
        min: percentage ? 0 : null,
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

    const yAxisRanges = {}

    let maxYValue = 0
    let minYValue = 0
    let minY1Value = 0
    let maxY1Value = 0

    datasets.forEach((dataset) => {
        if (dataset.type !== "line") {
            dataset.maxBarThickness = 150
        }

        if (dataset?.dataType !== 'percentage') {
            dataset.data.forEach(item => {
                if (!yAxisRanges[item.x]) {
                    yAxisRanges[item.x] = 0
                }

                yAxisRanges[item.x] += item.y;
            })
        }

        if (dataset?.dataType === 'percentage') {
            dataset.data.forEach(item => {
                minY1Value = Math.min(item.y, minY1Value);
                maxY1Value = Math.max(item.y, maxY1Value);
            })
        }
    })

    maxYValue = Math.max(...Object.values(yAxisRanges))

    const adjustedValues = adjustSignificantValues([
        { max: maxYValue, min: minYValue },
        { max: maxY1Value, min: minY1Value }
    ])

    minYValue = adjustedValues[0].min;
    maxYValue = adjustedValues[0].max;
    minY1Value = adjustedValues[1].min;
    maxY1Value = adjustedValues[1].max;

    return new Chart(ctx, {
        plugins: [
            chartJsPlugins.pointLine,
            window.ChartDataLabels,
            chartJsPlugins.htmlLegend,
            chartJsPlugins.addLogo
        ],
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
                legend: { display: false },
                htmlLegend: { container: config.legendsContainer },
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
                ...setScalesRange(scales(false, true, config.reverse), 'y', minYValue, maxYValue),
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
                    max: maxY1Value,
                    min: minY1Value
                },
            },
        },
    })
}

function renderCostStructureChart(canvas, datasets, config) {
    const ctx = canvas.getContext("2d")
    const yAxisRanges = {}

    let maxYValue = 0;
    let minYValue = 0;
    let maxY1Value = 0;
    let minY1Value = 0;

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

        if (dataset?.dataType !== 'percentage') {
            dataset.data.forEach(item => {
                if (!yAxisRanges[item.x]) {
                    yAxisRanges[item.x] = 0
                }

                yAxisRanges[item.x] += item.value
            })
        }

        if (dataset?.dataType === 'percentage') {
            dataset.data.forEach(item => {
                maxY1Value = Math.max(item.y, maxY1Value)
            })
        }
    })

    maxYValue = Math.max(...Object.values(yAxisRanges))

    const adjustedValues = adjustSignificantValues([
        {max: maxYValue, min: minYValue},
        {max: maxY1Value, min: minY1Value}
    ])

    minYValue = adjustedValues[0].min
    maxYValue = adjustedValues[0].max
    minY1Value = adjustedValues[1].min
    maxY1Value = adjustedValues[1].max

    return new Chart(ctx, {
        plugins: [
            window.ChartDataLabels,
            chartJsPlugins.pointLine,
            chartJsPlugins.htmlLegend,
            chartJsPlugins.addLogo
        ],
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
                legend: { display: false },
                htmlLegend: { container: config.legendsContainer },
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
                ...setScalesRange(scales(config.type === "percentage", true, config.reverse), 'y', minYValue, maxYValue),
                y1: {
                    afterFit(scale) {
                        scale.width = 50;
                    },
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
                    min: minY1Value,
                    max: maxY1Value
                },
            },
        },
    })
}

function renderFcfConversionChart(canvas, data, config) {
    const ctx = canvas.getContext("2d")

    let minY1Value = 0
    let maxY1Value = 0

    data.datasets.forEach((dataset) => {
        if (dataset.type !== "line") {
            dataset.maxBarThickness = 150
        }

        if (dataset?.dataType === 'value') {
            dataset.data.forEach(item => {
                minY1Value = Math.min(item.y, minY1Value)
                maxY1Value = Math.max(item.y, maxY1Value)
            })
        }
    })

    const adjustedValues = adjustSignificantValues([
        {max: maxY1Value, min: minY1Value}
    ])

    minY1Value = adjustedValues[0].min
    maxY1Value = adjustedValues[0].max

    return new Chart(ctx, {
        plugins: [
            window.ChartDataLabels,
            chartJsPlugins.pointLine,
            chartJsPlugins.htmlLegend,
            chartJsPlugins.addLogo
        ],
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
                legend: { display: false },
                htmlLegend: { container: config.legendsContainer },
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
                    afterFit(scale) {
                        scale.width = 40;
                    },
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
                    max: maxY1Value,
                    min: minY1Value
                },
            },
        },
    })
}

function renderCapitalStructureChart(canvas, datasets, config) {
    const ctx = canvas.getContext("2d")

    let maxYValue = 0
    let minYValue = 0
    let maxY1Value = 0
    let minY1Value = 0

    datasets.forEach((dataset) => {
        if (dataset?.dataType !== 'percentage') {
            dataset.data.forEach(item => {
                minYValue = Math.min(parseInt(item.y), minYValue)
                maxYValue = Math.max(parseInt(item.y), maxYValue)
            })
        }

        if (dataset?.dataType === 'percentage') {
            dataset.data.forEach(item => {
                maxY1Value = Math.max(item.y, maxY1Value)
                minY1Value = Math.min(item.y, minY1Value)
            })
        }
    })

    const adjustedValues = adjustSignificantValues([
        {max: maxYValue, min: minYValue},
        {max: maxY1Value, min: minY1Value}
    ])

    minYValue = adjustedValues[0].min
    maxYValue = adjustedValues[0].max
    minY1Value = adjustedValues[1].min
    maxY1Value = adjustedValues[1].max

    return new Chart(ctx, {
        plugins: [
            chartJsPlugins.pointLine,
            window.ChartDataLabels,
            chartJsPlugins.htmlLegend,
            chartJsPlugins.addLogo
        ],
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
                legend: { display: false },
                htmlLegend: { container: config.legendsContainer },
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
                    align: "end",
                    color: "#121A0F",
                },
            },
            scales: {
                ...setScalesRange(scales(false, false, config.reverse), 'y', minYValue, maxYValue),
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
                    max: maxY1Value,
                    min: minY1Value
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

    const yAxisRanges = {}

    let maxYValue = 0
    let minYValue = 0

    datasets.forEach((dataset) => {
        if (dataset.type !== "line") {
            dataset.maxBarThickness = 150
        }

        dataset.data.forEach(item => {
            if (!yAxisRanges[item.x]) {
                yAxisRanges[item.x] = 0
            }

            yAxisRanges[item.x] += item.value
        })
    })

    maxYValue = Math.max(...Object.values(yAxisRanges))
    maxYValue = roundUpToHigherSignificant(maxYValue)

    return new Chart(ctx, {
        plugins: [window.ChartDataLabels, chartJsPlugins.htmlLegend, chartJsPlugins.addLogo],
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
                legend: { display: false },
                htmlLegend: { container: config.legendsContainer },
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
            scales: setScalesRange(scales(false, true, config.reverse), 'y', minYValue, maxYValue),
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
        plugins: [window.ChartDataLabels, chartJsPlugins.htmlLegend, chartJsPlugins.addLogo],
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
                legend: { display: false },
                htmlLegend: { container: config.legendsContainer },
                datalabels: dataLabelConfig(config),
            },
            scales: scales(true, true, config.reverse),
        },
    })
}
