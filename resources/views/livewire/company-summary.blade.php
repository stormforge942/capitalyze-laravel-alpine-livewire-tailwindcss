<div class="py-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block mb-3">
                    <h1 class="text-base font-semibold leading-10 text-gray-900">Company Summary - {{ Str::title($quarters[$selectedQuarter]) }}</h1>
                </div>
                <div class="block mb-3">
                    <label for="quarter-select">Quarter to view:</label>
                    <select wire:model="selectedQuarter" id="quarter-select" class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500">
                        @foreach ($quarters as $quarterEndDate => $quarterText)
                            <option value="{{ $quarterEndDate }}">{{ $quarterText }}</option>
                        @endforeach
                    </select>
                </div>
                <div wire:loading.flex class="justify-center items-center min-w-full">
                        <div class="grid place-content-center h-full" role="status">
                        <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="rounded rounded-lg border border-pg-primary-200 min-w-full overflow-scroll" wire:loading.remove>
                    <table class="table-auto min-w-full data-report" style="font-size:1em;color:#000;">
                    <thead>
                        <tr>
                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">{{ Str::title($quarters[$selectedQuarter]) }}</th>
                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">All 13F Filers</th>
                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">Prior</th>
                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">Change</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php($i = 0)
                    @foreach ($rows as $title => $row)
                        <tr class="@if($i % 2 == 0) bg-cyan-50 @else bg-white @endif hover:bg-blue-200">
                            <td class="@if($i % 2 == 0) bg-cyan-50 @else bg-white @endif sticky left-0 p-2 break-words text-sm">{{ $title }}</td>
                            <td class="p-2">{{ rtrim(rtrim(number_format($summary[$row['value']], 2), '0'), '.') ?? '-' }}</td>
                            <td class="p-2">{{ rtrim(rtrim(number_format($summary[$row['prior']], 2), '0'), '.') ?? '-' }}</td>
                            <td class="p-2"><span class="{{ $summary[$row['change']] >= 0 ? 'bg-green-600' : 'bg-red-600' }} text-white text-sm px-2 py-1 rounded">{{ rtrim(rtrim(number_format($summary[$row['change']], 2), '0'), '.') ?? '-' }}</span></td>
                        </tr>
                        @php($i++)
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>