import chartJsPlugins, { formatCmpctNumber } from "../chartjs-plugins"

function renderBaseChart(canvas, datasets, config) {
    let ctx = canvas.getContext("2d")

    if (!config.isRBE) {
        datasets.forEach((dataset) => {
            dataset.data = dataset.data.map((value) => {
                value.y =
                    config.type == "percentage" ? value.percent : value.value
                return value
            })
        })
    }

    console.log(datasets)

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
            elements: {
                line: {
                    tension: 0,
                },
            },
            plugins: {
                datalabels: {
                    display: config.type == "percentage" ? true : false,
                    anchor: "center",
                    align: "center",
                    formatter: (v) => Number(v.y).toFixed(2 ?? 0) + "%",
                    font: {
                        weight: 500,
                        size: 12,
                    },
                },
                tooltip: {
                    bodyFont: {
                        size: 15,
                    },
                    external: chartJsPlugins.largeTooltip,
                    enabled: false,
                    position: "nearest",
                    callbacks: {
                        title: function (context) {
                            const InputDate = new Date(context[0].label)
                            const Month = InputDate.getMonth() + 1
                            const Day = InputDate.getDate()
                            const Year = InputDate.getFullYear()
                            return (
                                Year +
                                "-" +
                                Month.toString().padStart(2, "0") +
                                "-" +
                                Day.toString().padStart(2, "0")
                            )
                        },
                        label: function (context) {
                            return `${context.dataset.label}|${context.raw.y}`
                        },
                    },
                },
                legend: {
                    display: config.showLabel || false,
                    position: "bottom",
                    labels: {
                        boxWidth: 16,
                        boxHeight: 16,
                    },
                },
                pointLine: {
                    color: "#13B05BDE",
                },
            },
            scales: {
                y: {
                    stacked: true,
                    display: true,
                    ticks: {
                        callback: (val) => {
                            if (config.type == "percentage")
                                return val + "%"

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
                ...(config.isRBE
                    ? {
                          y1: {
                              stacked: true,
                              ticks: {
                                  callback: (val) => {
                                      return formatCmpctNumber(val)
                                  },
                              },
                              display: true,
                              position: "right",
                              type: "linear",
                              beginAtZero: false,
                              grid: {
                                  drawOnChartArea: false,
                              },
                          },
                      }
                    : {}),
            },
        },
    })
}

function renderCapitalStructureChart(canvas, datasets, config) {
    let ctx = canvas.getContext("2d")

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
            elements: {
                line: {
                    tension: 0,
                },
            },
            plugins: {
                tooltip: {
                    bodyFont: {
                        size: 15,
                    },
                    external: chartJsPlugins.largeTooltip,
                    enabled: false,
                    position: "nearest",
                    callbacks: {
                        title: function (context) {
                            const InputDate = new Date(context[0].label)
                            const Month = InputDate.getMonth() + 1
                            const Day = InputDate.getDate()
                            const Year = InputDate.getFullYear()
                            return (
                                Year +
                                "-" +
                                Month.toString().padStart(2, "0") +
                                "-" +
                                Day.toString().padStart(2, "0")
                            )
                        },
                        label: function (context) {
                            return `${context.dataset.label}|${context.raw.y}`
                        },
                    },
                },
                legend: {
                    display: config.showLabel || false,
                    position: "bottom",
                    labels: {
                        boxWidth: 16,
                        boxHeight: 16,
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
                    ticks: {
                        callback: (val) => {
                            return formatCmpctNumber(val)
                        },
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
    renderBaseChart,
    renderCapitalStructureChart,
}
