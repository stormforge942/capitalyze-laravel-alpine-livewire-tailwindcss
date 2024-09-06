<div x-data="{
    chartData: @js($chartData),
    companyName: @js($companyName),
    price: @js($price),
    width: 1120,
    height: 150,
    offsetX: 0,
    offsetY: 0,
    xPositions: [],
    chartOptions: {
        circleRadius: 24,
        rectWidth: 24,
        fontSize: 12,
    },
    current: -1,
    init() {
        this.setupResizeObserver();

        const handleMouseMove = (e) => {
            mouseX = parseInt(e.clientX - this.offsetX);
            mouseY = parseInt(e.clientY - this.offsetY);

            for (let i = this.xPositions.length - 1; i >= 0; i--) {
                if (Math.abs(this.xPositions[i].x - mouseX) <= this.chartOptions.circleRadius && Math.abs(mouseY - this.height / 2) <= this.chartOptions.circleRadius) {
                    this.showTooltip(this.xPositions[i]);
                    return;
                }
            }

            this.showTooltip(null);
        };

        this.$refs.canvas.onmousemove = handleMouseMove;
        this.$refs.canvas.parentElement.onmouseout = () => this.$refs.tooltip.style.opacity = 0;
    },
    showTooltip(item) {
        // Access the tooltip element
        const tooltip = this.$refs.tooltip;

        if (!item) {
            tooltip.style.opacity = 0;
            return;
        }

        // Update the tooltip content
        tooltip.innerHTML = `
    <p style='font-size: 11px; font-weight: 400; background-color: inherit; color: rgb(70, 78, 73);'>
        Price
    </p>
    <span style='font-size: 13px; font-weight: 700; color: rgb(0, 0, 0);'>
        $${item.price}
    </span>
    <p class='whitespace-nowrap' style='font-size: 11px; font-weight: 400; background-color: inherit; color: rgb(70, 78, 73);'>
        Investors (${item.name.split('|').length})
    </p>
    <span class='whitespace-nowrap' style='font-size: 13px; font-weight: 700; color: rgb(0, 0, 0);'>
        ${item.name.split('|').join('<br />')}
    </span>
`;

        // Get the canvas and its bounding rectangle
        const canvasRect = this.$refs.canvas.getBoundingClientRect();

        // Calculate tooltip position based on the item's x position
        const tooltipX = item.x;
        const tooltipY = this.height / 2 + 25;

        // Apply the calculated position to the tooltip
        tooltip.style.left = `${tooltipX}px`;
        tooltip.style.bottom = `${tooltipY}px`;

        // Show the tooltip
        tooltip.style.opacity = 1;
    },
    setupResizeObserver() {
        // Create a ResizeObserver instance
        const observer = new ResizeObserver(entries => {
            for (let entry of entries) {
                const { width } = entry.contentRect;
                if (width === 0) return;

                this.width = width;
                this.offsetX = entry.target.getBoundingClientRect().left;
                this.offsetY = entry.target.getBoundingClientRect().top;

                this.$nextTick(() => this.renderChart(width));
            }
        });

        // Observe the element
        observer.observe(this.$refs.canvas.parentElement);
    },
    renderChart(width) {
        const tempData = [];
        for (const key in this.chartData) {
            tempData.push({ name: key, price: this.chartData[key] });
        }
        tempData.push({ name: this.companyName, price: this.price, current: true });
        tempData.sort((a, b) => a.price - b.price);

        // on tempData, when price is same, make them as one and the name should be sum of them
        const data = [];
        let prevPrice = null,
            prevName = null,
            prevCurrent = false;

        const radius = 30;
        const padding = 10;
        const margin = 100;

        for (const item of tempData) {
            if (prevPrice === item.price) {
                prevName += ` | ${item.name}`;
                prevCurrent = prevCurrent || (item.current ?? false);
            } else {
                if (prevName) {
                    data.push({ name: prevName, price: prevPrice, current: prevCurrent });
                }
                prevPrice = item.price;
                prevName = item.name;
                prevCurrent = item.current ?? false;
            }
        }
        data.push({ name: prevName, price: prevPrice, current: prevCurrent });

        // Normalize the prices to canvas width
        const minPrice = Math.min(...data.map(d => d.price));
        const maxPrice = Math.max(...data.map(d => d.price));

        const normalizePrice = (price) => {
            return margin + ((price - minPrice) / (maxPrice - minPrice)) * (width - 2 * margin);
        };

        // Calculate initial positions based on normalized values
        const xPositions = data.map(d => normalizePrice(d.price));

        // Ensure no overlap by adjusting positions
        const adjustPositions = (positions) => {
            const adjusted = [...positions];
            for (let i = 1; i < adjusted.length; i++) {
                let previous = adjusted[i - 1];
                let current = adjusted[i];
                let requiredSpacing = 2 * radius + padding;

                if (current - previous < requiredSpacing) {
                    adjusted[i] = previous +
                        requiredSpacing;
                }
            }
            const newMinPos = Math.min(...adjusted);
            const newMaxPos = Math.max(...adjusted);
            const adjustedTotalWidth = newMaxPos - newMinPos; // Scale positions if necessary
            if (adjustedTotalWidth > width - 2 * margin) {
                const scaleFactor = (width - 2 * margin) / adjustedTotalWidth;
                adjusted.forEach((_, i) => {
                    adjusted[i] = margin + (adjusted[i] - newMinPos) * scaleFactor;
                });
            }

            return adjusted;
        };

        const adjustedXPositions = adjustPositions(xPositions);

        // Create final data with adjusted x-values
        const data1 = data.map((item, index) => ({
            x: adjustedXPositions[index],
            name: item.name,
            price: item.price,
            current: item.current
        }));

        this.xPositions = data1;

        window.investorFundPage.renderPurchaseChart(this.$refs.canvas, data1, this.chartOptions);
    },
}" wire:init="load">
    <div class="bg-white px-4 py-6 md:px-6 rounded-lg relative" x-transition>
        <div class="font-extrabold">Purchase Continuum</div>

        <div class="mt-3 place-items-center h-[150px]" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div class="relative mt-3 h-[150px]" wire:loading.remove>
            <canvas :width="Math.floor(width * (window.devicePixelRatio || 1))"
                :height="Math.floor(150 * (window.devicePixelRatio || 1))" class="w-full h-full" x-ref="canvas"></canvas>
            <div x-ref="tooltip"
                class="tooltip-caret absolute z-10 tooltip inline-block p-5 text-black transition-opacity duration-300 bg-white rounded-xl shadow-sm border border-gray-100 opacity-0 translate-x-[-50%]">
            </div>
        </div>
    </div>
</div>
