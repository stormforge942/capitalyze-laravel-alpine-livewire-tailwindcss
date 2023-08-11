<div>
    <div class="py-12">
        <div class="mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
                <div wire:loading.flex class="justify-center items-center min-w-full">
                        <div class="grid place-content-center h-full" role="status">
                        <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="sm:flex sm:items-start flex-col" wire:loading.remove>
                    <div class="block">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Company Stock Chart</h1>
                    </div>
                    <div wire:init="getCompanyStockChart" class="p-4" wire:loading.remove>
                        <span class="font-medium px-2.5 py-0.5">Zoom</span>
                        @foreach($chartPeriods as $chartPeriod)
                            <span wire:click="setChartPeriod('{{ $chartPeriod }}')" class="{{ $currentChartPeriod === $chartPeriod ? 'bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400' : 'cursor-pointer bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500' }}">{{$chartPeriod}}</span>
                        @endforeach
                        <canvas id="lineChart" class="!w-full !h-full"></canvas>
                        <div class="relative" id="timebox-wrapper">
                            <div class="h-[100px]">
                                <canvas id="allTimeChart"></canvas>
                            </div>
                            <div id="timebox" class="absolute bg-red-900/[0.3] top-0 bottom-0 h-full left-0 right-0 m-auto">
                                <div id="fromDate" class="absolute h-[20px] w-[20px] bg-red-900 rounded-full top-0 left-[-9.5px] bottom-0 m-auto border-black border-solid border cursor-ew-resize"></div>
                                <div id="toDate" class="absolute h-[20px] w-[20px] bg-red-900 rounded-full top-0 right-[-9.5px] bottom-0 m-auto border-black border-solid border cursor-ew-resize"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const chart = new Chart(
    document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
    }
);

const allTimeChart = new Chart(
    document.getElementById('allTimeChart'), {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            onClick: (event, elements, chart) => {
                if (elements[0]) {            
                    const i = elements[0].index;
                    alert(chart.data.labels[i] + ': ' + chart.data.datasets[0].data[i]);
                }
            },
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                },
            },
            scales: {
                x: {
                    ticks: {
                        // display: false
                        maxTicksLimit: 9,
                        align: 'start',
                    }
                },
                y: {
                    ticks: {
                        display: false
                    }
                },
            }
        }
    }
)
let fromDate = new Date('1970');
let toDate = new Date();
let timebox = document.getElementById("timebox");
let timeboxWrapper = document.getElementById("timebox-wrapper");
const maxRight = parseInt(timeboxWrapper.offsetLeft) + parseInt(timeboxWrapper.offsetWidth);
const minLeft = parseInt(timeboxWrapper.offsetLeft);

let filterCharts = (chartData) => {
    return chartData.filter((data) => new Date(data.date).getTime() >= fromDate.getTime() && new Date(data.date).getTime() <= toDate.getTime());
}

const heightClickChart = (e) => {
    let points = [];

    let offsetHeight = parseInt(timeboxWrapper.offsetTop) + 60;

    for(let i = timeboxWrapper.offsetTop; i < offsetHeight; i++) {
        e.pageY = i;
        let event = e;
        let point = allTimeChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
        point.length > 0 && points.push(point);
    }

    return points;
}

const resizeLeft = (e) => {
    if(e.clientX >= minLeft && e.clientX <= maxRight) {
        let points = heightClickChart(e);
        // console.log(points);
        timebox.style.left = parseInt(e.clientX) - minLeft + "px";
    }
}

let fromDateHandler = (e) => {
    document.addEventListener("mousemove", resizeLeft, false);
}

const resizeRight = (e) => {
    const newRight = maxRight - parseInt(e.clientX);
    if(newRight > 0 && newRight < maxRight) {
        timebox.style.right = newRight + "px";
    }
}

let toDateHandler = (e) => {
    document.addEventListener("mousemove", resizeRight, false);
}

document.addEventListener("mouseup", function(){
    document.removeEventListener("mousemove", resizeLeft, false);
    document.removeEventListener("mousemove", resizeRight, false);
}, false);

document.getElementById("fromDate").addEventListener('mousedown', fromDateHandler)
document.getElementById("toDate").addEventListener('mousedown', toDateHandler)

document.addEventListener('livewire:load', function () {
    Livewire.on('getCompanyStockChart', function (chartData) {
        const ascChartData = chartData.sort(function(a,b){
            return new Date(a.date) - new Date(b.date);
        });

        const labels = chartData.map((data) => data.date);
        const datasets = [{label: chartData.shift().symbol, data: ascChartData.map((data) => data.close)}];

        chart.data.labels = labels;
        chart.data.datasets = datasets;
        chart.update();
    });

    Livewire.on('getAllData', function (chartData) {
        const ascChartData = filterCharts(chartData);

        const labels = ascChartData.map((data) => new Date(data.date).getFullYear());
        const datasets = [{label: chartData.shift().symbol, data: ascChartData.map((data) => data.close), pointStyle: false}];

        allTimeChart.data.labels = labels;
        allTimeChart.data.datasets = datasets;
        allTimeChart.update();
    });
});
</script>
@endpush