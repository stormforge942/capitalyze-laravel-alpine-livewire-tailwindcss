@if (count($table['summary']) && count($table['data']))
    <template x-if="summaryAt === '{{ $for }}'">
        <tbody class="[&>tr]:border-b-2 [&>tr]:border-gray-light font-semibold">
            @if ($for === 'top')
                <tr>
                    <td class="px-6 py-4" colspan="10000">
                        <div class="flex gap-x-6">
                            <span class="text-blue font-semibold">Summary Statistics of generated
                                table</span>
                            <button class="bg-green-light4 text-xs flex gap-x-1.5 px-2 py-1 rounded font-semibold"
                                @click="toggleSummary">
                                <span>Move Summary To Bottom</span>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.57 1.33203H7.4248C6.0822 1.33203 5.36222 1.51768 4.71037 1.8663C4.05852 2.21491 3.54694 2.72649 3.19833 3.37834C2.84972 4.03019 2.66406 4.75017 2.66406 6.09277V9.90463C2.66406 11.2472 2.84972 11.9672 3.19833 12.619C3.54694 13.2709 4.05852 13.7825 4.71037 14.1311C5.36222 14.4797 6.0822 14.6654 7.4248 14.6654H8.57C9.9126 14.6654 10.6326 14.4797 11.2844 14.1311C11.9363 13.7825 12.4479 13.2709 12.7965 12.619C13.1451 11.9672 13.3307 11.2472 13.3307 9.90463V6.09277C13.3307 4.75017 13.1451 4.03019 12.7965 3.37834C12.4479 2.72649 11.9363 2.21491 11.2844 1.8663C10.6326 1.51768 9.9126 1.33203 8.57 1.33203ZM7.33073 7.33203V3.9987H8.66406V7.33203H7.33073ZM5.16927 9.1707L6.11208 8.2279L7.99773 10.1135L9.88333 8.2279L10.8261 9.1707L7.99773 11.9991L5.16927 9.1707Z"
                                        fill="#121A0F" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @endif

            @foreach ($summaries as $summary)
                <tr style="background: rgba(82, 198, 255, 0.10)">
                    <td class="uppercase pl-6 py-4">{{ $summary }}</td>
                    <td colspan="{{ count($columns['simple']) - 1 }}"></td>
                    @foreach ($columns['complex'] as $column)
                        <td class="pl-6 last:pr-6 py-4">
                            <?php $key = $column['accessor'] . '_' . strtolower($summary); ?>

                            @if (isset($table['summary'][$key]) && !is_null($table['summary'][$key]))
                                <span :data-tooltip-content="{{ $table['summary'][$key] }}">
                                    {{ number_format($table['summary'][$key], 3) }}
                                </span>
                            @else
                                N/A
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach

            @if ($for === 'bottom')
                <tr class="last:border-0">
                    <td class="px-6 py-4" colspan="10000">
                        <div class="flex gap-x-6">
                            <span class="text-blue font-semibold">Summary Statistics of generated
                                table</span>
                            <button class="bg-green-light4 text-xs flex gap-x-1.5 px-2 py-1 rounded font-semibold"
                                @click="toggleSummary">
                                <span>Move Summary To Top</span>
                                <svg class="transform rotate-180" width="16" height="16" viewBox="0 0 16 16"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.57 1.33203H7.4248C6.0822 1.33203 5.36222 1.51768 4.71037 1.8663C4.05852 2.21491 3.54694 2.72649 3.19833 3.37834C2.84972 4.03019 2.66406 4.75017 2.66406 6.09277V9.90463C2.66406 11.2472 2.84972 11.9672 3.19833 12.619C3.54694 13.2709 4.05852 13.7825 4.71037 14.1311C5.36222 14.4797 6.0822 14.6654 7.4248 14.6654H8.57C9.9126 14.6654 10.6326 14.4797 11.2844 14.1311C11.9363 13.7825 12.4479 13.2709 12.7965 12.619C13.1451 11.9672 13.3307 11.2472 13.3307 9.90463V6.09277C13.3307 4.75017 13.1451 4.03019 12.7965 3.37834C12.4479 2.72649 11.9363 2.21491 11.2844 1.8663C10.6326 1.51768 9.9126 1.33203 8.57 1.33203ZM7.33073 7.33203V3.9987H8.66406V7.33203H7.33073ZM5.16927 9.1707L6.11208 8.2279L7.99773 10.1135L9.88333 8.2279L10.8261 9.1707L7.99773 11.9991L5.16927 9.1707Z"
                                        fill="#121A0F" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </template>
@endif
