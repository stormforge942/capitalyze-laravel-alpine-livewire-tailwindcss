// update this with the actual metrics used in screener & chart/table builder
const metrics = []

// update this with actual mapping give by backend (need to be in key value pair)
const mapping = []

let notFound = []

metrics.forEach(i => {
    const childrens = !i.has_children ? [i.items] : Object.values(i.items)

    childrens.forEach(group => {
        for (const key in group) {
            const title = key.split("||")[1]

            group[key].mapping = {}

            if (mapping[title]) {
                group[key].mapping.self = mapping[title]
                delete mapping[title]
            } else {
                if (!title) {
                    console.log(key)
                }
                notFound.push(title)
            }

            if (mapping[title + '||% Change YoY']) {
                group[key].mapping.yoy = mapping[title + '||% Change YoY']
                delete mapping[title + '||% Change YoY']
            }
        }
    })
})

console.log({
    mapped: metrics,
    notMapped: mapping,
    notFound
})