<div class="py-12">
    <div class="mx-auto flex flex-col md:flex-row justify-center">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-4 rounded md:w-2/3 w-full">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto text-center">
                    <h1 class="text-xl font-bold leading-10 text-gray-900">Earnings Calendar - {{ $formattedDate }}</h1>
                </div>
            </div>
            <div class="flex justify-between mb-3 mt-3">
                <button wire:click="previousWeek" class="text-gray-500"><x-heroicon-s-chevron-left class="w-4 h-6 inline-block align-text-bottom"/> Previous Week</button>
                <select id="exchange-select" wire:model="selectedExchange">
                    <option value="all">All Exchanges</option>
                    @foreach($exchanges as $exchange)
                        <option value="{{ $exchange }}">{{ $exchange }}</option>
                    @endforeach
                </select>

                <input type="week" wire:model="week" wire:change="selectWeek($event.target.value)" class="border-b border-cyan-500">

                <button wire:click="nextWeek"class="text-gray-500">Next Week <x-heroicon-s-chevron-right class="w-4 h-6 inline-block align-text-bottom"/></button>
            </div>

            <table class="table-auto w-full">
                @foreach($earningsCalls->sortBy(function ($call) { return $call->date . ' ' . $call->time; })->groupBy('date') as $date => $calls)
                    <tr>
                        <td colspan="4" class="font-bold py-4">{{ $date }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-4">Company name</td>
                        <td class="font-semibold py-4">Symbol</td>
                        <td class="font-semibold py-4">Exchange</td>
                        <td class="font-semibold py-4">Time</td>
                        <td class="font-semibold py-4">Origin</td>
                        <td class="font-semibold py-4">reported time</td>
                        <td class="font-semibold py-4">Url</td>
                    </tr>
                    @foreach($calls as $call)
                        <tr>
                            <td class="break-all">@if(isset($call->company_name)) {{ $call->company_name }} @else {{ $call->symbol }} @endif</td>
                            <td class="px-2">{{ $call->symbol }}</td>
                            <td class="px-2">{{ $call->exchange }}</td>
                            <td class="px-2">{{ $call->time }}</td>
                            <td class="px-2">{{ $call->origin }}</td>
                            <td class="px-2">@if(isset($call->acceptance_time)) {{ substr($call->acceptance_time, 0, 10) }} @else {{ $call->pub_date }} @endif</td>
                            <td class="px-2"><a href="{{ $call->url }}" target="_blank">More Info</a></td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>
</div>
