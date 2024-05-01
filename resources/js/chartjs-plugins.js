import logoSvgFile from "../img/svg/logo.svg"
const logoImg = new Image();
logoImg.src = logoSvgFile
const chartJsPlugins = {
    pointLine: {
        id: "pointLine",
        afterDraw: (chart, _, options) => {
            if (chart.tooltip?._active?.length) {
                let x = chart.tooltip._active[0].element.x
                // find max y
                let y = chart.tooltip._active
                    .filter(
                        (el) => el.element.constructor.name === "PointElement"
                    )
                    .sort((a, b) => a.element.y - b.element.y)[0]

                if (!y) {
                    return
                }

                y = y.element.y

                let yAxis = chart.scales.y
                let ctx = chart.ctx
                ctx.save()
                ctx.beginPath()
                ctx.moveTo(x, yAxis.bottom)
                ctx.lineTo(x, y)
                ctx.lineWidth = 1
                ctx.strokeStyle = options.color || "#121A0F"
                ctx.setLineDash([5, 5])
                ctx.stroke()
                ctx.restore()
            }
        },
    },
    makeLinearGradientBackgroundColor: (colors) => {
        return (context) => {
            if (!context.chart.chartArea) {
                return
            }

            const { top, bottom } = context.chart.chartArea

            const gradient = context.chart.ctx.createLinearGradient(
                0,
                top,
                0,
                bottom
            )

            colors.forEach(([offset, color]) => {
                gradient.addColorStop(offset, color)
            })

            return gradient
        }
    },
    largeTooltip(context) {
        // Tooltip Element
        const { chart, tooltip } = context
        const tooltipEl = getOrCreateTooltip(chart)

        // Hide if no tooltip
        if (tooltip.opacity === 0) {
            tooltipEl.style.opacity = 0
            return
        }

        // Set Text
        if (tooltip.body) {
            const titleLines = tooltip.title || []
            const bodyLines = tooltip.body.map((b) => b.lines)

            const tableHead = document.createElement("thead")

            tableHead.style.color = "#3561E7"
            tableHead.style.textAlign = "left"
            tableHead.style.marginBottom = "8px"

            titleLines.forEach((title) => {
                const tr = document.createElement("tr")
                tr.style.borderWidth = 0

                const th = document.createElement("th")
                th.style.borderWidth = 0
                const text = document.createTextNode(title)

                th.appendChild(text)
                tr.appendChild(th)
                tableHead.appendChild(tr)
            })

            const tableBody = document.createElement("tbody")
            bodyLines.reverse().forEach((body) => {
                let [label, value] = body[0].split(
                    tooltip.options.delimiter || "|"
                )

                // format number if possible
                if (!Number.isNaN(Number(value))) {
                    const afterDot = (value.split(".")[1] || "").length

                    value = Intl.NumberFormat("en-US", {
                        minimumFractionDigits: afterDot,
                        maximumFractionDigits: afterDot,
                    }).format(value)
                }

                //label
                const trLabel = document.createElement("tr")
                trLabel.style.backgroundColor = "inherit"
                trLabel.style.borderWidth = "0"
                trLabel.style.fontSize = "12px"
                trLabel.style.fontWeight = "400"
                trLabel.style.color = "#464E49"
                trLabel.style.paddingBottom = "0px"
                trLabel.style.marginBottom = "0px"

                const tdLabel = document.createElement("td")
                tdLabel.style.borderWidth = 0

                const textLabel = document.createTextNode(label)

                tdLabel.appendChild(textLabel)
                trLabel.appendChild(tdLabel)

                tableBody.appendChild(trLabel)

                //value
                const tr = document.createElement("tr")
                tr.style.backgroundColor = "inherit"
                tr.style.borderWidth = "0"
                tr.style.fontSize = "16px"
                tr.style.fontWeight = "700"
                tr.style.color = "#464E49"

                const td = document.createElement("td")
                td.style.borderWidth = 0

                const text = document.createTextNode(value)

                td.appendChild(text)
                tr.appendChild(td)

                tableBody.appendChild(tr)
            })

            const tableRoot = tooltipEl.querySelector("table")

            if (!tableRoot) {
                return
            }

            // Remove old children
            while (tableRoot.firstChild) {
                tableRoot.firstChild.remove()
            }

            // Add new children
            tableRoot.appendChild(tableHead)
            tableRoot.appendChild(tableBody)
        }

        const { offsetLeft: positionX, offsetTop: positionY } = chart.canvas

        // Display, position, and set styles for font
        tooltipEl.style.opacity = 1
        tooltipEl.style.zIndex = 9999
        tooltipEl.style.left = positionX + tooltip.caretX + "px"
        tooltipEl.style.top = positionY + tooltip.caretY - 155 + "px"
        tooltipEl.style.font = tooltip.options.bodyFont.string
        tooltipEl.style.padding = 8 + "px " + 19 + "px"
    },
    htmlLegend: {
        id: "htmlLegend",
        afterUpdate(chart, _, options) {
            if (!options.container) return

            const ul = options.container

            ul.style.display = "flex"
            ul.style.alignItems = "center"
            ul.style.flexWrap = "wrap"
            ul.style.columnGap = "16px"
            ul.style.rowGap = "4px"
            ul.style.fontSize = "12px"

            // Remove old legend items
            ul.innerHTML = ""

            // Reuse the built-in legendItems generator
            const items =
                chart.options.plugins.legend.labels.generateLabels(chart)

            items.forEach((item) => {
                const li = document.createElement("div")
                li.style.alignItems = "center"
                if (options.enableClick != false) {
                    li.style.cursor = "pointer"
                }
                li.style.display = "inline-flex"
                li.style.flexDirection = "row"

                if (options.enableClick != false) {
                    li.onclick = () => {
                        const { type } = chart.config
                        if (type === "pie" || type === "doughnut") {
                            // Pie and doughnut charts only have a single dataset and visibility is per item
                            chart.toggleDataVisibility(item.index)
                        } else {
                            chart.setDatasetVisibility(
                                item.datasetIndex,
                                !chart.isDatasetVisible(item.datasetIndex)
                            )
                        }
                        chart.update()
                    }
                }

                // Color box
                const boxSpan = document.createElement("span")
                boxSpan.style.background = item.fillStyle
                boxSpan.style.borderColor = item.strokeStyle
                boxSpan.style.borderWidth = item.lineWidth + "px"
                if (options.rounded) {
                    boxSpan.style.borderRadius = "50%"
                } else {
                    boxSpan.style.borderRadius = "1px"
                }
                boxSpan.style.display = "inline-block"
                boxSpan.style.flexShrink = 0
                boxSpan.style.height = "16px"
                boxSpan.style.marginRight = "8px"
                boxSpan.style.width = "16px"

                // Text
                const textContainer = document.createElement("p")
                textContainer.style.color = item.fontColor
                textContainer.style.margin = 0
                textContainer.style.padding = 0
                textContainer.style.textDecoration = item.hidden
                    ? "line-through"
                    : ""

                const text = document.createTextNode(item.text)
                textContainer.appendChild(text)

                li.appendChild(boxSpan)
                li.appendChild(textContainer)
                ul.appendChild(li)
            })
        },
    },
    beforeDraw: {
        id: "appendLogoBelowChart",
        beforeInit(chart) {
            const desiredPaddingBottom = 20;
            chart.options.layout.padding.bottom = desiredPaddingBottom
        },
        beforeDraw: (chart, args, options) => {
            const { ctx } = chart

            ctx.save();
            const logoHeight = 16, logoWidth = 80;
            if (logoImg.complete) {
                ctx.drawImage(logoImg, ctx.canvas.offsetWidth - logoWidth, ctx.canvas.offsetHeight - logoHeight, logoWidth, logoHeight)
            }
            else {
                logoImg.onload = () => chart.draw();
            }
            ctx.restore();

        }
    }
}
window.chartJsPlugins = chartJsPlugins

export default chartJsPlugins

function getOrCreateTooltip(chart) {
    let tooltipEl = chart.canvas.parentNode.querySelector("div")

    if (!tooltipEl) {
        tooltipEl = document.createElement("div")
        tooltipEl.style.background = "#fff"
        tooltipEl.style.borderRadius = "25px"
        tooltipEl.style.color = "black"
        tooltipEl.style.opacity = 1
        tooltipEl.style.pointerEvents = "none"
        tooltipEl.style.position = "absolute"
        tooltipEl.style.transform = "translate(-50%, 0)"
        tooltipEl.style.transition = "all .1s ease"
        tooltipEl.style.minWidth = "230px"
        tooltipEl.style.filter =
            "drop-shadow(0px 10.7px 21.5px rgba(50, 50, 71, 0.06)) drop-shadow(0px 10.7px 10.7px rgba(50, 50, 71, 0.08))"
        tooltipEl.classList.add("tooltip-caret")

        const table = document.createElement("table")
        table.style.margin = "0px"

        tooltipEl.appendChild(table)
        chart.canvas.parentNode.appendChild(tooltipEl)
    }

    return tooltipEl
}
