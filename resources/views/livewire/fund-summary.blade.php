<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded max-w-5xl mx-auto">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block mb-3">
                    <h1 class="text-base font-semibold leading-10 text-gray-900">{{ Str::title($fund->name) }}</h1>
                </div>
                <div class="block mb-3">
                    <label for="quarter-select">Quarter to view:</label>
                    <select wire:model="selectedQuarter" id="quarter-select" class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500">
                        @foreach ($quarters as $quarterEndDate => $quarterText)
                            <option value="{{ $quarterEndDate }}">{{ $quarterText }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid gap-4 w-full grid-cols-1 md:grid-cols-2 items-start" wire:init="loadFundData('{{$selectedQuarter}}')">
                    <div wire:loading.flex class="justify-center items-center min-w-full col-span-2">
                            <div class="grid place-content-center h-full " role="status">
                            <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="rounded rounded-lg border border-sky-950 w-full overflow-scroll inline-block" wire:loading.remove>
                        <table class="table-auto min-w-full" style="font-size:1em;color:#000;">
                        <thead>
                            <tr>
                            <th colspan="2" scope="colgroup" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">Top Buys (13F)</th>
                            </tr>
                        </thead>
                        </table>
                        <canvas id="topBuys"></canvas>
                    </div>

                    <div class="rounded rounded-lg border border-sky-950 w-full overflow-scroll inline-block" wire:loading.remove>
                        <table class="table-auto min-w-full" style="font-size:1em;color:#000;">
                        <thead>
                            <tr>
                            <th colspan="2" scope="colgroup" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">Top Sells (13F)</th>
                            </tr>
                        </thead>
                        </table>
                        <canvas id="topSells"></canvas>
                    </div>

                    <div class="rounded rounded-lg border border-sky-950 w-full overflow-scroll inline-block" wire:loading.remove>
                        <table class="table-auto min-w-full" style="font-size:1em;color:#000;">
                        <thead>
                            <tr>
                            <th colspan="2" scope="colgroup" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">13F Holdings Summary</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr class="border-t border-gray-200">
                            <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Name</th>
                            <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">% Portfolio</th>
                        </tr>
                        @foreach($activity as $key => $value)
                            <tr>
                                <td class="px-3 py-3.5"><span class="text-base font-semibold">{{ $value->symbol }}</span> <small>{{ Str::title($value->name_of_issuer) }}</small> </td>
                                <td class="px-3 py-3.5 text-left text-sm text-blue-500">{{ number_format($value->weight, 2) }} %</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-blue-500">
                                <th colspan="2" scope="colgroup" wire:click="allHoldings()"><a href="/fund/{{ $cik }}/holdings" class="px-3 py-3.5 bg-blue-500 hover:underline hover:cursor-pointer text-white w-full block">See all holdings</a></th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>

                    <div class="rounded rounded-lg border border-sky-950 w-full inline-block" wire:loading.remove>
                        <table class="table-auto min-w-full" style="font-size:1em;color:#000;">
                        <thead>
                            <tr>
                            <th colspan="2" scope="colgroup" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">13F Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr class="border-t border-gray-200">
                            <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Name</th>
                            <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Change</th>
                        </tr>
                        @foreach($summary as $key => $value)
                            <tr>
                                <td class="px-3 py-1 text-sm font-semibold">{{ str_replace('_', ' ', Str::title($key)) }} </td>
                                <td class="px-3 py-1 text-left text-sm break-all">
                                    @if(Str::startsWith($value, 'https'))
                                        <a href="{{ $value }}" class="hover:underline text-blue-600" target="_blank">{{ $value }}</a>
                                    @else
                                        {{ $value }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
const chartBuys = new Chart(
    document.getElementById('topBuys'), {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: []
        },
    }
);

const chartSells = new Chart(
    document.getElementById('topSells'), {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: []
        },
    }
);


document.addEventListener('livewire:load', function () {
    Livewire.on('getTopBuys', function (chartData) {
        const labels = chartData.map((data) => data.name_of_issuer);
        const datasets = [{label: 'Change', data: chartData.map((data) => data.change_in_shares)}];

        chartBuys.data.labels = labels;
        chartBuys.data.datasets = datasets;
        chartBuys.update();
    });

    Livewire.on('getTopSells', function (chartData) {
        const labels = chartData.map((data) => data.name_of_issuer);
        const datasets = [{label: 'Change', data: chartData.map((data) => data.change_in_shares)}];

        chartSells.data.labels = labels;
        chartSells.data.datasets = datasets;
        chartSells.update();
    });
});
</script>
@endpush