<div>
    <div class="sm:flex sm:items-start">
        <div class="mt-2">
            <p class="text-sm text-gray-500">{{ $title }}</p>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Symbol</th>
                                <th scope="col" class="px-6 py-4">Series</th>
                                <th scope="col" class="px-6 py-4">Class</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr class="border-b dark:border-neutral-500">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-blue-500">
                                    <a href="{{ route('mutual-fund.holdings', ['cik' => $item['cik'], 'fund_symbol' => $item['fund_symbol'], 'series_id' => $item['series_id'], 'class_id' => $item['class_id']]) }}">{{ $item['registrant_name'] }}</a>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $item['fund_symbol'] }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $item['series_id'] }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $item['class_id'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
