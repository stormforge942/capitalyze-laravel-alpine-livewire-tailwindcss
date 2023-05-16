<div class="py-12">
    <div class="mx-auto flex flex-col md:flex-row justify-center">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-4 rounded md:w-1/2 w-full">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto text-center">
                    <h1 class="text-xl font-bold leading-10 text-gray-900">Earnings Calendar - {{ $formattedDate }}</h1>
                </div>
            </div>
            <div class="flex justify-between mb-3 mt-3">
                <button wire:click="previousMonth" class="text-gray-500"><x-heroicon-s-chevron-left class="w-4 h-6 inline-block align-text-bottom"/> Previous Month</button>
                <select id="exchange-select" wire:model="selectedExchange">
                    <option value="all">All Exchanges</option>
                    @foreach($exchanges as $exchange)
                        <option value="{{ $exchange }}">{{ $exchange }}</option>
                    @endforeach
                </select>

                <input type="month" wire:model="month" wire:change="selectMonth($event.target.value)" class="border-b border-cyan-500">

                <button wire:click="nextMonth"class="text-gray-500">Next Month <x-heroicon-s-chevron-right class="w-4 h-6 inline-block align-text-bottom"/></button>
            </div>

            <table class="table-auto w-full">
                @foreach($earningsCalls->groupBy('date') as $date => $calls)
                    <tr>
                        <td colspan="4" class="font-bold py-4">{{ $date }}</td>
                    </tr>
                    @foreach($calls as $call)
                        <tr>
                            <td>@if(isset($call->company_name)) {{ $call->company_name }} @else - @endif</td>
                            <td>{{ $call->symbol }}</td>
                            <td>{{ $call->exchange }}</td>
                            <td>{{ $call->time }}</td>
                            <td><a href="{{ $call->url }}" target="_blank">More Info</a></td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>
</div>
