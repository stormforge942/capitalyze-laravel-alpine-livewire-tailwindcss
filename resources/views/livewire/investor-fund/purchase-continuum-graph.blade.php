<div x-data="{
    chartData: @js($chartData),
    data: @js($data),
    price: @js($price),
    width: 1120,
    init() {
        this.setupResizeObserver();
    },
    setupResizeObserver() {
        // Create a ResizeObserver instance
        const observer = new ResizeObserver(entries => {
            for (let entry of entries) {
                const { width } = entry.contentRect;
                if (width === 0) return;
                this.width = width;

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
        tempData.push({ name: this.data.company_name, price: this.price, current: true });
        tempData.sort((a, b) => a.price - b.price);

        // on tempData, when price is same, make them as one and the name should be sum of them
        const data = [];
        let prevPrice = null,
            prevName = null,
            prevCurrent = false;

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

        const data1 = data.map((item, index) => {
            return {
                x: index === 0 ? 100 : index === data.length - 1 ? (width - 100) : 100 + (item.price - data[0].price) / (data[data.length - 1].price - data[0].price) * (width - 200),
                name: item.name,
                price: item.price,
                current: item.current,
            };
        });

        window.investorFundPage.renderPurchaseChart(this.$refs.canvas, data1);
    },
}" wire:init="load">
    <div class="bg-white px-4 py-6 md:px-6 rounded-lg relative" x-transition>
        <div class="font-extrabold">Purchase Continuum</div>

        <div class="mt-3 place-items-center h-[150px]" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div class="mt-3 h-[150px]" wire:loading.remove>
            <canvas :width="width" :height="150" class="w-full h-full" x-ref="canvas"></canvas>
        </div>
    </div>
</div>
