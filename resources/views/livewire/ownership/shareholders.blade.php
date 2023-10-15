<div>
    <label class="flex items-center gap-1 text-sm">
        <span>Quarter to view</span>
        <select class="border-[0.5px] border-solid border-[#93959880] p-2 rounded-full" wire:model="quarter">
            <option value="">Select a quarter</option>
            @foreach ($quarters as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </select>
    </label>

    <div class="mt-6 flow-root overflow-x-auto text-dark">
        <table class="w-full text-right bg-white rounded-md overflow-clip">
            <thead class="font-sm font-semibold capitalize bg-[#E6E6E680] rounded-t-md">
                <tr class="[&>*]:pl-6 [&>*]:py-2 [&>*]:text-dark [&>*]:whitespace-nowrap">
                    <th class="text-left">Fund</th>
                    <th>
                        <button class="w-full flex items-center justify-end gap-1">
                            Shares Held
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                            </svg>
                        </button>
                    </th>
                    <th>
                        <button class="w-full flex items-center justify-end gap-1">
                            Market Value
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                            </svg>
                        </button>
                    </th>
                    <th>
                        <button class="w-full flex items-center justify-end gap-1">
                            % of Portfolio
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                            </svg>
                        </button>
                    </th>
                    <th>
                        <button class="w-full flex items-center justify-end gap-1">
                            Prior % of Portfolio
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                            </svg>
                        </button>
                    </th>
                    <th>
                        <button class="w-full flex items-center justify-end gap-1">
                            Changes in Shares
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                            </svg>
                        </button>
                    </th>
                    <th>
                        <button class="w-full flex items-center justify-end gap-1">
                            % Ownership
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                            </svg>
                        </button>
                    </th>
                    <th>
                        <button class="w-full flex items-center justify-end gap-1">
                            Date reported
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                            </svg>
                        </button>
                    </th>
                    <th class="pr-6">
                        <button class="w-full flex items-center justify-end gap-1">
                            Source Date
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                            </svg>
                        </button>
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y-2" wire:loading.remove>
                @foreach ($filings as $filing)
                    <tr class="[&>*]:pl-6 [&>*]:py-4 [&>*]:whitespace-nowrap" wire:key="{{ $filing->id }}">
                        <td class="text-left">
                            <a href="{{ route('company.shareholder', [
                                'ticker' => $company['ticker'],
                                'shareholder' => 'VGDGRP',
                            ]) }}"
                                class="text-blue">
                                {{ $filing->investor_name }}
                            </a>
                        </td>
                        <td>{{ number_format($filing->ssh_prnamt) }}</td>
                        <td>{{ number_format($filing->value) }}</td>
                        <td>{{ number_format($filing->weight) }}</td>
                        <td>{{ number_format($filing->last_weight) }}</td>
                        <td>{{ number_format($filing->change_in_shares) }}</td>
                        <td>{{ number_format($filing->ownership) }}</td>
                        <td>{{ $filing->signature_date }}</td>
                        <td class="pr-6">{{ number_format($filing->price_paid) }}</td>
                    </tr>
                @endforeach
            </tbody>

            <tbody class="divide-y-2 animate-pulse" wire:loading>
                @foreach (range(1, 8) as $row)
                    <tr class="[&>*]:pl-6 [&>*]:py-4 [&>*]:whitespace-nowrap" wire:key="{{ 'p-' . $row }}">
                        @foreach (range(1, 9) as $cell)
                            <td class="first:pl-8 last:pr-8" wire:key="{{ 'p-c' . $cell }}">
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
