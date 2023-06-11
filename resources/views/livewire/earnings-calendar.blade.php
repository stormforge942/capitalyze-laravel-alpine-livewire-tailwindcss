<div class="py-12">
    <div class="mx-auto flex flex-col md:flex-row justify-center">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-4 rounded md:w-10/12 2xl:w-2/3 w-full">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto text-center">
                    <h1 class="text-xl font-bold leading-10 text-gray-900">Earnings Calendar - {{ $formattedDate }}</h1>
                </div>
            </div>
            <div class="flex justify-between mb-3 mt-3">
                <button wire:click="previousWeek" class="text-gray-500"><x-heroicon-s-chevron-left class="w-4 h-6 inline-block align-text-bottom"/> Previous Week</button>
                <select id="exchange-select" wire:model="selectedExchange" class="border-b-2">
                    <option value="all">All Exchanges</option>
                    @foreach($exchanges as $exchange)
                        <option value="{{ $exchange }}">{{ $exchange }}</option>
                    @endforeach
                </select>

                <input type="week" wire:model="week" wire:change="selectWeek($event.target.value)" class="border-b border-cyan-500">

                <button wire:click="nextWeek"class="text-gray-500">Next Week <x-heroicon-s-chevron-right class="w-4 h-6 inline-block align-text-bottom"/></button>
            </div>
            <div wire:loading.flex class="justify-center items-center">
                    <div class="grid place-content-center h-full" role="status">
                    <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="overflow-x-scroll">
                <table class="table-auto w-full overflow-scroll" wire:loading.remove>
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
</div>
