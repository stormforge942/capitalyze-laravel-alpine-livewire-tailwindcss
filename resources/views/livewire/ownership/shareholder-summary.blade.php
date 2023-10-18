<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-9">
            <div class="bg-white rounded">
                <div class="flex items-center justify-between py-3 px-6 border-b">
                    <h3 class="text-md font-medium">Market Value Overtime</h3>

                    <select class="bg-gray-light rounded px-2.5 py-1.5">
                        <option value="" selected>This month</option>
                    </select>
                </div>
                <div class="p-6">
                    <div class="chart-here bg-gray-200 w-full h-80">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-3">
            <div class="bg-white p-6 rounded">
                <h3 class="text-blue text-sm mb-4 font-semibold">13F Holding Summary</h3>

                <div class="space-y-4">
                    @foreach ($activity as $key => $value)
                        <div class="flex items-center justify-between">
                            <span class="text-sm">{{ Str::title($value->name_of_issuer) }} @if ($value->symbol)
                                    ({{ $value->symbol }})
                                @endif
                            </span>
                            <span class="font-semibold">{{ number_format($value->weight, 2) }}%</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-center">
                    <a href="#" class="text-sm font-semibold hover:underline">
                        View All Holdings
                    </a>
                </div>
            </div>
        </div>

        <div class="col-span-6">
            <div class="bg-white p-6 rounded" x-data="{ active: 'buys' }" x-init="window.renderTopBuysChart()">
                <div>
                    <div class="border p-1 rounded-lg inline-flex items-center gap-1 text-sm font-semibold">
                        <button class="rounded px-6 py-2 transition"
                            :class="active == 'buys' ? 'bg-blue text-white' : 'hover:bg-gray-light'"
                            @click="active = 'buys'">Top
                            Buys</button>
                        <button class="rounded px-4 py-2 transition"
                            :class="active == 'sells' ? 'bg-blue text-white' : 'hover:bg-gray-light'"
                            @click="active = 'sells'">Top
                            Sells</button>
                    </div>
                </div>

                <div class="mt-4">
                    <div :class="active === 'buys' ? 'block' : 'hidden'" x-cloak>
                        <canvas id="topBuys"></canvas>
                    </div>

                    <div :class="active === 'sells' ? 'block' : 'hidden'" x-cloak>
                        <canvas id="topSells"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-6">

        </div>
    </div>
</div>

@push('scripts')
    <script>
        function drawRoundedRect(ctx, x, y, width, height, radius) {
            ctx.beginPath();
            ctx.moveTo(x + radius, y);
            ctx.lineTo(x + width - radius, y);
            ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
            ctx.lineTo(x + width, y + height - radius);
            ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
            ctx.lineTo(x + radius, y + height);
            ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
            ctx.lineTo(x, y + radius);
            ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.closePath();
            ctx.fill();
        }

        const progressBarPlugin = {
            id: 'progressBarPlugin',
            beforeDatasetsDraw(chart) {
                const {
                    data,
                    ctx,
                    chartArea: {
                        top,
                        bottom,
                        left,
                        right,
                        width,
                        height
                    },
                    scales: {
                        x,
                        y
                    }
                } = chart;
                ctx.save();

                ctx.fillStyle = '#F0F6FF';
                for (let i = 0; i < data.labels.length; i++) {
                    drawRoundedRect(ctx, left, y.getPixelForValue(i) - 10, width, 20, 12)
                }
                ctx.restore();
            }
        }

        function renderTopBuysChart() {
            const topBuysDataRaw = @json($topBuys)

            const data = {
                labels: topBuysDataRaw.map(item => item.name_of_issuer),
                datasets: [{
                    data: topBuysDataRaw.map(item => item.change_in_shares),
                    backgroundColor: Array.from({
                        length: topBuysDataRaw.length
                    }, () => '#3561E7'),
                }]
            }

            const topBuys = new Chart(
                document.getElementById('topBuys'), {
                    type: 'bar',
                    data,
                    options: {
                        responsive: true,
                        indexAxis: 'y',
                        plugins: {
                            legend: {
                                display: false,
                            },
                        },
                        barThickness: 8,
                        borderRadius: 40,
                        borderSkipped: false,
                        scales: {
                            x: {
                                categorySpacing: 5,
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: false,
                                },
                                ticks: {
                                    display: false,
                                },
                            },
                            y: {
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: false,
                                },
                                ticks: {
                                    display: true,
                                }
                            }
                        },
                    },
                    plugins: [progressBarPlugin]
                }
            )
        }
    </script>
@endpush
