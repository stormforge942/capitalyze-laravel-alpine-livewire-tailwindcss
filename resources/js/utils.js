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

export function formatNumber(number, options = {}) {
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

export function randomColor() {
    let color =
        "#" +
        Math.floor(Math.random() * 16777215)
            .toString(16)
            .padStart(6, "0")
    let r = parseInt(color.substr(1, 2), 16)
    let g = parseInt(color.substr(3, 2), 16)
    let b = parseInt(color.substr(5, 2), 16)
    let luminance = r * 0.299 + g * 0.587 + b * 0.114
    if (luminance > 150) {
        return randomColor()
    }

    return color
}

export function http(url, options = {}) {
    return fetch(url, {
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            ...options.headers,
        },
        method: options.method || "GET",
        body: options.body
            ? JSON.stringify({
                  _token: document.querySelector(`meta[name='csrf-token']`)
                      .content,
                  ...options.body,
              })
            : undefined,
    })
}

export function niceNumber(value) {
    if (isNaN(value)) return value

    if (value < 0) {
        return "-" + this.niceNumber(-1 * value)
    }

    let suffix = ""

    if (value > 1000000000000) {
        value = value / 1000000000000
        suffix = "T"
    } else if (value > 1000000000) {
        value = value / 1000000000
        suffix = "B"
    } else if (value > 1000000) {
        value = value / 1000000
        suffix = "M"
    } else if (value > 1000) {
        value = value / 1000
        suffix = "K"
    }

    return (
        Intl.NumberFormat("en-US", {
            minimumFractionDigits: 0,
            maximumFractionDigits: 3,
        }).format(value) + (suffix ? " " + suffix : "")
    )
}

window.updateUserSettings = updateUserSettings
window.formatCmpctNumber = formatCmpctNumber
window.formatNumber = formatNumber
window.hex2rgb = hex2rgb
window.printChart = printChart
window.fullScreen = fullScreen
window.randomColor = randomColor
window.http = http
window.niceNumber = niceNumber
