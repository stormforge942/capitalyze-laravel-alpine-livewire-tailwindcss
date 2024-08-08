<div x-data="{
    chartData: @js($chartData),
    data: @js($data),
    init() {
        this.renderChart();
    },
    renderChart() {
        const tempData = [];
        for (const key in this.chartData) {
            tempData.push({ name: key, price: this.chartData[key] });
        }
        tempData.push({ name: this.data.company_name, price: this.data.price, current: true });
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
                x: index === 0 ? 100 : index === data.length - 1 ? 900 : 100 + (item.price - data[0].price) / (data[data.length - 1].price - data[0].price) * 800,
                name: item.name,
                price: item.price,
                current: item.current,
            };
        });

        window.investorFundPage.renderPurchaseChart(this.$refs.canvas, data1);
    },
}">
    <div class="bg-white px-4 py-6 md:px-6 rounded-lg relative" x-transition>
        <div class="font-extrabold">Purchase Continuum</div>

        <div class="mt-3 h-[150px]">
            <canvas width="1000" height="150" class="w-full h-full" x-ref="canvas"></canvas>
        </div>
    </div>
</div>
