<div>
    <div class="flex items-center justify-between gap-x-3">
        <div class="warning-wrapper">
            <div class="warning-text text-sm">
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.99967 14.6663C4.31777 14.6663 1.33301 11.6815 1.33301 7.99967C1.33301 4.31777 4.31777 1.33301 7.99967 1.33301C11.6815 1.33301 14.6663 4.31777 14.6663 7.99967C14.6663 11.6815 11.6815 14.6663 7.99967 14.6663ZM7.99967 13.333C10.9452 13.333 13.333 10.9452 13.333 7.99967C13.333 5.05415 10.9452 2.66634 7.99967 2.66634C5.05415 2.66634 2.66634 5.05415 2.66634 7.99967C2.66634 10.9452 5.05415 13.333 7.99967 13.333ZM7.33301 9.99967H8.66634V11.333H7.33301V9.99967ZM7.33301 4.66634H8.66634V8.66634H7.33301V4.66634Z"
                        fill="#DA680B" />
                </svg>
                {{ $symbol }} Key Metrics (millions)
            </div>
        </div>

        <div class="flex items-center">
            <span class="currency-font">Currency: &nbsp;</span>
            <select class="inline-flex font-bold !pr-8 bg-transparent">
                <option value="USD">USD</option>
            </select>
        </div>
    </div>

    <div class="h-screen overflow-auto">
        <table class="w-full rounded-lg overflow-clip text-right whitespace-nowrap text-base" id="main-table">
            <thead class="font-semibold capitalize bg-[#EDEDED] text-dark">
                <tr class="font-bold text-base">
                    <th class="pl-8 py-2 text-left">{{ $company_name }}
                        ({{ $symbol }})</th>
                    <th class="pl-6 py-2 last:pr-8">Quantity</th>
                </tr>
            </thead>

            <tbody class="bg-white">
                @foreach ($data as $report)
                    <tr class="font-bold">
                        <td class="pl-8 pt-2 pb-1 text-left">
                            {{ $report->period_of_report }}
                        </td>
                        <td class="pl-6 pt-2 pb-1 last:pr-8"></td>
                    </tr>
                    @foreach ($report->metrics as $key => $value)
                        <tr class="border-b border-[#D4DDD7]">
                            <td class="pl-12 pt-1 pb-2 text-left font-semibold">
                                {{ $key }}
                            </td>
                            <td class="pl-6 pt-1 pb-2 last:pr-8">
                                @if (is_object($value))
                                    @foreach ($value as $subKey => $subValue)
                        <tr class="border-b border-[#D4DDD7]">
                            <td class="pl-16 pt-1 pb-2 text-left">
                                {{ $subKey }}
                            </td>
                            <td class="pl-6 pt-1 pb-2 last:pr-8">
                                {!! format_overview_numbers($subValue) !!}
                            </td>
                        </tr>
                    @endforeach
                @else
                    {!! format_overview_numbers($value) !!}
                @endif
                </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
