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

function highlightSelection(value, formatedValue, selector, document = window.document) {
    let selections = [];

    return setTimeout(() => {
        const regexExpressions = [value, formatedValue].map(item => new RegExp(`^${parseText(item)}$`))

        if (!regexExpressions.length) return;

        const values = [];

        if (typeof selector === "string") {
            values.push(...document.querySelectorAll(selector))
        } else {
            for (const s of selector) {
                values.push(...document.querySelectorAll(s))
            }
        }

        for (const value of values) {
            const text = parseText(value.innerText, true)
            const comparisonResult = regexExpressions.some(regex => regex.test(text))

            if (comparisonResult) {
                highlightElement(value)
                selections.push(value)
            }
        }

        scrollToFirstHighlightedElement(selections);
    }, [100]);
}

function highlightElement(el) {
    el = el.querySelector("span") || el.querySelector("font") || el

    el.style.backgroundColor = "yellow"
    el.classList.add('highlight-text')
}

function scrollToFirstHighlightedElement(selections) {
    return setTimeout(() => {
        const firstNode = selections.shift();

        if (!firstNode) return;

        const highlightedElement = firstNode.querySelector("span") || firstNode.querySelector("font") || firstNode;

        highlightedElement.scrollIntoView({behavior: "smooth", block: "center"});
    }, [100]);
}

window.reportTextHighlighter = {
    highlight: highlightSelection,
}
