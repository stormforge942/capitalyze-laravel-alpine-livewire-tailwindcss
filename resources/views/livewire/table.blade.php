<div x-data="{}">
    <div class="mt-6 flow-root overflow-x-auto text-dark">
        <table class="w-full text-right bg-white rounded-md overflow-clip">
            <thead class="font-sm font-semibold capitalize bg-[#E6E6E680] rounded-t-md">
                <tr class="[&>*]:pl-6 [&>*]:py-2 [&>*]:text-dark [&>*]:whitespace-nowrap">
                    @foreach ($cols as $idx => $col)
                        <th
                            class="@if ($loop->first) text-left @endif @if ($loop->last) pr-6 @endif">
                            @if (is_string($col))
                                {{ $col }}
                            @elseif(is_array($col) && $col['sortable'])
                                <button class="w-full flex items-center justify-end gap-1"
                                    wire:click="sortBy({{ $col['key'] }})">
                                    {{ $col['label'] }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16
                                        16" fill="none">
                                        <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                                    </svg>
                                </button>
                            @endif
                        </th>
                    @endif
                    @endforeach
                </tr>
            </thead>

            <tbody class="divide-y-2" wire:loading.remove>
                @foreach ($rows as $row)
                    <tr class="[&>*]:pl-6 [&>*]:py-4 [&>*]:whitespace-nowrap">
                        @foreach ($row as $idx => $cell)
                            <td
                                class="@if ($loop->first) text-left @endif @if ($loop->last) pr-6 @endif">
                                @if (isset($cell['html']) && $cell['html'])
                                    {!! $cell['text'] !!}
                                @else
                                    {{ $cell }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>

            <tbody class="divide-y-2 animate-pulse" wire:loading>
                @foreach (range(1, $placeholders ?? 10) as $row)
                    <tr class="[&>*]:pl-6 [&>*]:py-4 [&>*]:whitespace-nowrap">
                        @foreach (range(1, 9) as $cell)
                            <td class="last:pr-6">
                                <div class="h-4 w-full rounded bg-gray-300">
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $filings->links() }}
    </div>
</div>
