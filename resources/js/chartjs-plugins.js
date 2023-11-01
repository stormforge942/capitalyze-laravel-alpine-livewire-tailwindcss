window.chartJsPlugins = {
    pointLine: {
        id: "pointLine",
        afterDraw: (chart, _, options) => {
            if (chart.tooltip?._active?.length) {
                let x = chart.tooltip._active[0].element.x
                let y = chart.tooltip._active[0].element.y
                let yAxis = chart.scales.y
                let ctx = chart.ctx
                ctx.save()
                ctx.beginPath()
                ctx.moveTo(x, yAxis.bottom)
                ctx.lineTo(x, y)
                ctx.lineWidth = 1
                ctx.strokeStyle = options.color || "#000"
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
}
