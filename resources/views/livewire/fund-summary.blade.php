<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded max-w-5xl mx-auto">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block mb-3">
                    <h1 class="text-base font-semibold leading-10 text-gray-900">Fund Summary - {{ Str::title($fund->name) }}</h1>
                </div>
                <div class="grid gap-4 w-full grid-cols-1 md:grid-cols-2 items-start">
                    <div class="rounded rounded-lg border border-sky-950 w-full overflow-scroll inline-block" wire:loading.remove>
                        <table class="table-auto min-w-full" style="font-size:1em;color:#000;">
                        <thead>
                            <tr>
                            <th colspan="2" scope="colgroup" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">Top Buys (13F)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr class="border-t border-gray-200">
                            <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Name</th>
                            <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Change</th>
                        </tr>
                        @foreach($topBuys as $key => $value)
                            <tr>
                                <td class="px-3 py-3.5"><span class="text-base font-semibold">{{ $value->symbol }}</span> <small>{{ Str::title($value->name_of_issuer) }}</small> </td>
                                <td class="px-3 py-3.5 text-left text-sm text-green-500">{{ number_format(floatval($value->change_in_shares), 0) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>

                    <div class="rounded rounded-lg border border-sky-950 w-full overflow-scroll inline-block" wire:loading.remove>
                        <table class="table-auto min-w-full" style="font-size:1em;color:#000;">
                        <thead>
                            <tr>
                            <th colspan="2" scope="colgroup" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-white bg-sky-950 text-center">Top Sells (13F)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr class="border-t border-gray-200">
                            <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Name</th>
                            <th class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Change</th>
                        </tr>
                        @foreach($topSells as $key => $value)
                            <tr>
                                <td class="px-3 py-3.5"><span class="text-base font-semibold">{{ $value->symbol }}</span> <small>{{ Str::title($value->name_of_issuer) }}</small> </td>
                                <td class="px-3 py-3.5 text-left text-sm text-red-500">{{ number_format(floatval($value->change_in_shares), 0) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
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