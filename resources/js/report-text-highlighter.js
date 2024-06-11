function parseText(value, shouldBeNumber = false) {
    let term = String(value)
        .replaceAll(",", "")
        .replaceAll(".", "")
        .trim()
        .replace(/^\$/, "") // remove dollar sign from start
        .replace(/^¥/, "") // remove yen sign from start
        .replace(/^\(/, "") // remove ( from start
        .replace(/^-/, "") // remove negative number
        .replace(/¥$/, "") // remove yen sign from end
        .replace(/\$$/, "") // remove dollar sign from end
        .replace(/\)$/, "") // remove ) from end
        .trim()

    if (isNaN(Number(term))) {
        if (shouldBeNumber) {
            return null
        }

        term = value
    }

    return term?.replace(/0+$/, "") || ""
}

function highlightSelection(value, selector, document = window.document) {
    return setTimeout(() => {
        const search = parseText(value)

        if (!search.length) return;

        const values = document.querySelectorAll(selector)

        // regular expression to match the search term with any number of trailing zeros
        const regex = new RegExp(`^${search}0*$`)

        for (const value of values) {
            if (value.innerText == search) {
                highlightElement(value)
                continue
            }

            let text = parseText(value.innerText, true)

            if (text && (text === search || regex.test())) {
                highlightElement(value)
            }
        }
    }, [100])
}

function highlightElement(el) {
    el = el.querySelector("span") || el.querySelector("font") || el

    el.style.backgroundColor = "yellow"
}

window.reportTextHighlighter = {
    highlight: highlightSelection,
}
