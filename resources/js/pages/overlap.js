import chartJsPlugins from "../chartjs-plugins"

function renderOverviewChart(canvas, data) {
    const ctx = canvas.getContext("2d");
    const gradientBg = ctx.createLinearGradient(0, 0, 0, canvas.height * 2.5)
    gradientBg.addColorStop(0.8, 'rgba(19,176,91,0.18)')
    gradientBg.addColorStop(1, 'rgba(19,176,91,0.05)')

    const minPrice = Math.min(...data.dataset1.map(i => i.y))
    
    return new Chart(ctx, {
        plugins: [{
            afterDraw: chart => {
                if (chart.tooltip?._active?.length) {
                    let x = chart.tooltip._active[0].element.x;
                    let y = chart.tooltip._active[0].element.y;
                    let bottomBarY = chart.tooltip._active[1].element.y;
                    let ctx = chart.ctx;
                    ctx.save();
                    ctx.beginPath();
                    ctx.moveTo(x, y);
                    ctx.lineTo(x, bottomBarY + 9);
                    ctx.lineWidth = 1;
                    ctx.strokeStyle = '#13B05BDE';
                    ctx.setLineDash([5, 5])
                    ctx.stroke();
                    ctx.restore();
                }
            }
        }],
        type: 'bar',
        data: {
            datasets: [{
                    data: data.dataset2,
                    label: "Volume",
                    borderColor: "#9D9D9D",
                    backgroundColor: 'rgba(255, 255, 255, 0)',
                    borderWidth: Number.MAX_VALUE,
                    borderRadius: 2,
                    fill: true,
                    yAxisID: 'y1',
                },
                {
                    data: data.dataset1,
                    label: "Price",
                    borderColor: "#52D3A2",
                    backgroundColor: gradientBg,
                    type: 'line',
                    pointRadius: 0,
                    fill: true,
                    tension: 0.5,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#52D3A2',
                    pointHoverBorderWidth: 4,
                    pointHoverBorderColor: '#fff',
                },
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                    tension: 0
                }
            },
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    bodyFont: {
                        size: 15
                    },
                    external: chartJsPlugins.largeTooltip,
                    enabled: false,
                    position: 'nearest',
                    callbacks: {
                        title: function(context) {
                            const inputDate = new Date(context[0].label);
                            const month = inputDate.getMonth() + 1;
                            const day = inputDate.getDate();
                            const year = inputDate.getFullYear();
                            return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                        },
                        label: function(context) {
                            if (context.dataset.label == "Price") {
                                return `Price|${context.raw.y}`;
                            } else if (context.dataset.label == "Volume") {
                                return `Volume|${context.raw.source}`;
                            }
                        }
                    },
                }
            },
            scales: {
                y: {
                    min: minPrice - 0.05 * minPrice,
                },
                x: {
                    offset: false,
                    grid: {
                        display: false,
                    },
                    type: 'timeseries',
                    time: {
                        unit: data.unit,
                    },
                    ticks: {
                        source: 'data',
                        maxTicksLimit: data.quantity,
                        labelOffset: data.quantity > 20 ? 5 : data.quantity < 5 ? 150 : 30
                    },
                    align: 'center',
                },
                y1: {
                    display: false,
                    position: "right",
                    type: "linear",
                    beginAtZero: true,
                    max: Math.max(...data.dataset2.map(i => i.y)) * 7
                }
            }
        }
    });
}

function formatNumber(num) {
    num = parseFloat(num);
    return parseFloat(num.toFixed(1));
}

function truncateText(ctx, text, maxWidth) {
    let truncatedText = text;
    let width = ctx.measureText(truncatedText).width;

    // Truncate and add ellipsis until it fits
    while (width > maxWidth) {
        truncatedText = truncatedText.slice(0, -1);
        width = ctx.measureText(truncatedText + '...').width;
    }
    
    return truncatedText + (text.length > truncatedText.length ? '...' : '');
}

function renderPurchaseChart(canvas, data, chartOptions) {
    const ctx = canvas.getContext("2d");
    const scale = window.devicePixelRatio || 1;
    const width = Math.floor(canvas.width / scale);
    const height = Math.floor(canvas.height / scale);

    ctx.setTransform(scale, 0, 0, scale, 0, 0);

    const lineHeight = height / 2;
    const circleRadius = chartOptions.circleRadius;
    const rectWidth = chartOptions.rectWidth;

    ctx.clearRect(0, 0, width, height);

    // Draw background line and rectangle

    ctx.strokeStyle = "#000000";

    ctx.beginPath();
    ctx.moveTo(rectWidth, lineHeight);
    ctx.lineTo(width - rectWidth, lineHeight);
    ctx.lineWidth = 5;
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(rectWidth - rectWidth, lineHeight);
    ctx.lineTo(rectWidth, lineHeight - rectWidth);
    ctx.lineTo(rectWidth + rectWidth, lineHeight);
    ctx.lineTo(rectWidth, lineHeight + rectWidth);
    ctx.lineWidth = 0;
    ctx.closePath();

    ctx.fillStyle = "#000000";
    ctx.fill();

    ctx.beginPath();
    ctx.moveTo(width - rectWidth - rectWidth, lineHeight);
    ctx.lineTo(width - rectWidth, lineHeight - rectWidth);
    ctx.lineTo(width - rectWidth + rectWidth, lineHeight);
    ctx.lineTo(width - rectWidth, lineHeight + rectWidth);
    ctx.lineWidth = 0;
    ctx.closePath();

    ctx.fillStyle = "#000000";
    ctx.fill();

    // Draw items
    data.forEach(item => {
        // Draw circle
        ctx.beginPath();
        ctx.arc(item.x, lineHeight, circleRadius, 0, Math.PI * 2);
        ctx.fillStyle = item.current ? "#376bfb" : "#e4f2e7";
        ctx.fill();
        ctx.strokeStyle = item.current ? "#376bfb" : "#16a64d";
        ctx.lineWidth = 3;
        ctx.stroke();

        ctx.fillStyle = item.current ? "#fff" : "#000";
        ctx.font = `bold ${chartOptions.fontSize}px Arial`;
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.fillText('$' + formatNumber(item.price), item.x, lineHeight);

        ctx.fillStyle = "#fff";
        ctx.fillRect(item.x - circleRadius * 3, lineHeight + circleRadius + 7, circleRadius * 6, 35);

        ctx.fillStyle = "#000";
        ctx.textBaseline = "top";
        ctx.fillText(truncateText(ctx, item.name, circleRadius * 6), item.x, lineHeight + circleRadius + 10);

        ctx.font = `${chartOptions.fontSize}px Arial`;
        ctx.fillStyle = item.current ? "#376bfb" : "#000"; // Text color for label
        ctx.fillText(item.current ? "Current Stock Price" : "Average Price Paid", item.x, lineHeight + circleRadius + 25);
    });
}

function renderInvestorChart(canvas, data) {
    const ctx = canvas.getContext("2d")

    data.datasets.forEach((dataset) => {
        if (dataset.type !== "line") {
            dataset.maxBarThickness = 150
        }
    })

    const chart = new Chart(ctx, {
        plugins: [chartJsPlugins.pointLine],
        type: "bar",
        data,
        options: {
            maintainAspectRatio: false,
            responsive: true,
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

    return chart;
}

window.investorFundPage = {
    renderOverviewChart,
    renderPurchaseChart,
    renderInvestorChart,
}