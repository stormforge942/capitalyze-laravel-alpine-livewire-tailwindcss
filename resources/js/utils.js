export function updateUserSettings(settings) {
    fetch("/settings", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify({
            _token: document.querySelector('meta[name="csrf-token"]').content,
            ...settings,
        }),
    })
}

export function formatCmpctNumber(number, options = {}) {
    if (isNaN(Number(number))) return number

    options = {
        notation: "compact",
        compactDisplay: "short",
        ...options,
    }

    const usformatter = Intl.NumberFormat("en-US", options)
    return usformatter.format(number)
}

export function formatNumber(number, options) {
    if (isNaN(Number(number))) return number

    const divideBy = options.unit
        ? {
              Thousands: 1000,
              Millions: 1000000,
              Billions: 1000000000,
          }[options.unit] || 1
        : 1

    return Intl.NumberFormat("en-US", {
        minimumFractionDigits: options.decimalPlaces,
        maximumFractionDigits: options.decimalPlaces,
    }).format(number / divideBy)
}

export function hex2rgb(hex, alpha = 1) {
    const [r, g, b] = hex.match(/\w\w/g).map((x) => parseInt(x, 16))
    return `rgba(${r},${g},${b},${alpha})`
}

export function printChart(canvas) {
    let win = window.open()
    win.document.write(
        `<br><img src="${canvas.toDataURL()}" style="object-fit: contain; width: 100%;"/>`
    )
    setTimeout(() => {
        win.print()
        win.close()
    })
}

export function fullScreen(el) {
    el.requestFullscreen()
}

window.updateUserSettings = updateUserSettings
window.formatCmpctNumber = formatCmpctNumber
window.formatNumber = formatNumber
window.hex2rgb = hex2rgb
window.printChart = printChart
window.fullScreen = fullScreen
