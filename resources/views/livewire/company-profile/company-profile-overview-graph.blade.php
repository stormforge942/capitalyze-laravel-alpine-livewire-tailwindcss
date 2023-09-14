<div class="graph-wrapper">
    <div class="graph-header">
        <div class="pr-3">
            <b class="title">Apple Inc. (AAPL)</b><br>
            <small class="text-blue-600">5.0% price return over 1yr</small>
        </div>
        <div class="select-graph-date-wrapper flex">
            <span class="text-blue-600 flex items-center">Date:</span>
            <ul class="items-center w-full flex">
                <li class="w-full mr-2">
                    <label class="flex items-center pl-3">
                        <input id="date-3m" type="radio" name="date-range" class="w-4 h-4 ">
                        <span class="w-full py-3 ml-2 ">3m</span>
                    </label>
                </li>
                <li class="w-full mr-2">
                    <label class="flex items-center pl-3">
                        <input id="date-6m" type="radio"  name="date-range" class="w-4 h-4 ">
                        <span class="w-full py-3 ml-2 ">6m</span>
                    </label>
                </li>
                <li class="w-full mr-2">
                    <label class="flex items-center pl-3">
                        <input id="date-1yr" type="radio"  name="date-range" class="w-4 h-4 ">
                        <span class="w-full py-3 ml-2 ">1yr</span>
                    </label>
                </li>
                <li class="w-full mr-2">
                    <label class="flex items-center pl-3">
                        <input id="date-5yr" type="radio"  name="date-range" class="w-4 h-4 ">
                        <span class="w-full py-3 ml-2 ">5yr</span>
                    </label>
                </li>
                <li class="w-full mr-2">
                    <label class="flex items-center pl-3">
                        <input id="date-custom" type="radio"  name="date-range" class="w-4 h-4">
                        <span class="w-full py-3 ml-2 ">Custom</span>
                    </label>
                </li>
            </ul>
            <div class="date-range-select-wrapper flex ml-2 graph-range-picker" wire:ignore>
                <div class="from-wrapper py-2 px-3">
                    <div class="label">From</div>
                    <div class="value">{{\Carbon\Carbon::today()->modify('-1 year')->format('M d, Y')}}</div>
                    <input type="hidden" name="start" value="{{\Carbon\Carbon::today()->modify('-1 year')}}">
                </div>
                <div class="to-wrapper py-2 px-4">
                    <div class="label">To</div>
                    <div class="value">{{\Carbon\Carbon::today()->format('M d, Y')}}</div>
                    <input type="hidden" name="end" value="{{\Carbon\Carbon::today()}}">
                </div>
                <div class="calendar-icon-wrapper icon-wrapper px-4 flex items-center">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19 3.81818H20C21.1 3.81818 22 4.63636 22 5.63636V20.1818C22 21.1818 21.1 22 20 22H4C2.9 22 2 21.1818 2 20.1818V5.63636C2 4.63636 2.9 3.81818 4 3.81818H5V2.90909C5 2.40909 5.45 2 6 2C6.55 2 7 2.40909 7 2.90909V3.81818H17V2.90909C17 2.40909 17.45 2 18 2C18.55 2 19 2.40909 19 2.90909V3.81818ZM5 20.1818H19C19.55 20.1818 20 19.7727 20 19.2727V8.36364H4V19.2727C4 19.7727 4.45 20.1818 5 20.1818Z" fill="#3561E7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full mt-3" wire:ignore>
        <canvas id="product-profile-chart" class="w-full"></canvas>
    </div>
</div>

@pushonce('scripts')
    <script>
        let chart;
        function initChart() {
            let canvas = document.getElementById("product-profile-chart");
            if (!canvas) return;
            let ctx = canvas.getContext('2d');
            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                maintainAspectRatio: true,
                aspectRatio: 3,
                type: 'line',
                data: {
                    labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
                    datasets: [{
                        data: [86,114,106,106,107,111,133,221,783,2478],
                        label: "Africa",
                        borderColor: "rgba(104, 104, 104, 0.87);",
                        borderWidth: 5,
                        fill: false
                    }, {
                        data: [282,350,411,502,635,809,947,1402,3700,5267],
                        label: "Asia",
                        borderColor: "#D1D1D1",
                        borderWidth: 5,
                        fill: false,
                    }
                    ]
                },
                options: {
                    title: {
                        display: false,
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: 'white',
                            callbacks: {

                                labelTextColor: function(context) {
                                    return 'black';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                    }
                }
            });
        }
        document.addEventListener('DOMContentLoaded', initChart);
        Livewire.on("updateChart", initChart);
        window.addEventListener("resize", initChart);

    </script>
@endpushonce


