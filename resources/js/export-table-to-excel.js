function initTableExport(container) {
    // the table should be the standalone table and not a table inside table
    const tables = [...container.querySelectorAll("table")].filter(
        (table) => table.parentElement.tagName !== "TD"
    )

    tables.forEach((table, idx) => {
        const wrapper = document.createElement("div")

        wrapper.style.paddingTop = "0.25rem"
        wrapper.style.paddingBottom = "0.25rem"
        wrapper.style.display = "flex"
        wrapper.style.justifyContent = "flex-end"

        const button = document.createElement("button")
        button.innerHTML = `Download <svg class="h-4 w-4" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3"></path>
      </svg>`

        button.style.display = "flex"
        button.style.alignItems = "center"
        button.style.fontSize = "12px"
        button.style.columnGap = "8px"
        button.style.fontWeight = "500"
        button.style.backgroundColor = "white"
        button.style.border = "1px solid #e5e7eb"
        button.style.padding = "0.25rem 0.5rem"
        button.style.borderRadius = "0.5rem"
        button.style.cursor = "pointer"

        button.addEventListener("click", () => {
            exportTableToExcel(table, idx + 1)
        })

        wrapper.appendChild(button)

        table.before(wrapper)
    })
}

window.initTableExport = initTableExport

function exportTableToExcel(table, idx) {
    const rows = table.querySelectorAll("tr")
    const data = []

    rows.forEach((row) => {
        const rowData = []
        row.querySelectorAll("td").forEach((cell) => {
            const colspan = cell.getAttribute("colspan")
            if (colspan) {
                for (let i = 0; i < parseInt(colspan - 1); i++) {
                    rowData.push("")
                }
            }

            // get cell text content but perform some cleanup like br to newline
            let content = new DOMParser().parseFromString(
                cell.innerHTML,
                "text/html"
            )

            content.querySelectorAll("br").forEach((br) => {
                br.replaceWith("\n")
            })

            content = content.body.innerText
                .replace(/,/g, ",")
                .replace(/"/g, '""')
                .trim()

            rowData.push(content)
        })

        data.push(rowData)
    })

    if (data.length) {
        // maintain same column length
        const maxColumns = Math.max(...data.map((row) => row.length))
        data.forEach((row) => {
            while (row.length < maxColumns) {
                row.push("")
            }
        })

        // remove empty columns or contains only currency symbols
        for (let i = 0; i < maxColumns; i++) {
            if (
                data.every((row) => ["$", "¥", "€", "£", ""].includes(row[i]))
            ) {
                data.forEach((row) => row.splice(i, 1))
                i--
            }
        }

        // if first column is empty for row, shift it to left
        data.forEach((row) => {
            if (!row[0]) {
                row.shift()
                row.push("")
            }
        })

        // remove firt and last row if it is empty
        if (data[0].every((cell) => cell === "")) {
            data.shift()
        }
        if (data[data.length - 1].every((cell) => cell === "")) {
            data.pop()
        }
    } else {
        data.push(["No data found"])
    }

    const csvContent = data
        .map((row) => row.map((cell) => `"${cell}"`).join(","))
        .join("\n")
    const blob = new Blob([csvContent], { type: "text/csv" })
    const url = URL.createObjectURL(blob)

    const a = document.createElement("a")
    a.href = url
    a.download = `table-${idx}.csv`
    a.click()
}
