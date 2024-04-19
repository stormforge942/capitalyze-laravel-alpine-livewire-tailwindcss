class UrlWindow {
    constructor(numberOfPages, currentPage) {
        this.numberOfPages = numberOfPages
        this.currentPage = currentPage
    }

    get() {
        let onEachSide = 3

        if (this.numberOfPages < onEachSide * 2 + 8) {
            return this.getSmallSlider()
        }

        return this.getUrlSlider(onEachSide)
    }

    getSmallSlider() {
        return {
            first: this.getUrlRange(1, this.numberOfPages),
            slider: null,
            last: null,
        }
    }

    getUrlSlider(onEachSide) {
        let window = onEachSide + 4

        if (!this.hasPages()) {
            return { first: null, slider: null, last: null }
        }

        if (this.currentPage <= window) {
            return this.getSliderTooCloseToBeginning(window, onEachSide)
        } else if (this.currentPage > this.numberOfPages - window) {
            return this.getSliderTooCloseToEnding(window, onEachSide)
        } else {
            return this.getFullSlider(onEachSide)
        }
    }

    getSliderTooCloseToBeginning(window, onEachSide) {
        return {
            first: this.getUrlRange(1, window + onEachSide),
            slider: null,
            last: this.getFinish(),
        }
    }

    getSliderTooCloseToEnding(window, onEachSide) {
        let last = this.getUrlRange(
            this.numberOfPages - (window + (onEachSide - 1)),
            this.numberOfPages
        )

        return {
            first: this.getStart(),
            slider: null,
            last: last,
        }
    }

    getFullSlider(onEachSide) {
        return {
            first: this.getStart(),
            slider: this.getAdjacentUrlRange(onEachSide),
            last: this.getFinish(),
        }
    }

    getAdjacentUrlRange(onEachSide) {
        return this.getUrlRange(
            this.currentPage - onEachSide,
            this.currentPage + onEachSide
        )
    }

    getStart() {
        return this.getUrlRange(1, 2)
    }

    getFinish() {
        return this.getUrlRange(this.numberOfPages - 1, this.numberOfPages)
    }

    hasPages() {
        return this.numberOfPages > 1
    }

    getUrlRange(start, end) {
        const arr = []

        for (let i = start; i <= end; i++) {
            arr.push(i)
        }

        return arr
    }
}

window.UrlWindow = UrlWindow