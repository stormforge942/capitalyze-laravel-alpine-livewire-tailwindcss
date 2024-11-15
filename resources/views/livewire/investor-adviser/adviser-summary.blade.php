<div x-data>
    <div class="grid grid-cols-1 gap-y-4 mt-4">
        <?php
        $cards = [
            [
                'title' => 'Basic Information',
                'items' => [
                    [
                        'key' => 'Primary Business Name',
                        'value' => $adviser['form_data']['Primary Business Name'] ?? '-',
                    ],
                    [
                        'key' => 'Legal Name',
                        'value' => $adviser['form_data']['Legal Name'] ?? '-',
                    ],
                    [
                        'key' => 'Organization CRD#',
                        'value' => $adviser['form_data']['Organization CRD#'] ?? '-',
                    ],
                    [
                        'key' => 'SEC Region',
                        'value' => $adviser['form_data']['SEC Region'] ?? '-',
                    ],
                    [
                        'key' => 'SEC#',
                        'value' => $adviser['form_data']['SEC#'] ?? '-',
                    ],
                ],
            ],
            [
                'title' => 'Location & Contact',
                'items' => [
                    [
                        'key' => 'Main Location',
                        'value' => 
                            ($adviser['form_data']['Main Office Street Address 1'] ?? '') . ' ' .
                            ($adviser['form_data']['Main Office City'] ?? '') . ', ' .
                            ($adviser['form_data']['Main Office State'] ?? '') . ', ' .
                            ($adviser['form_data']['Main Office Country'] ?? ''),
                    ],
                    [
                        'key' => 'Main Office Telephone Number',
                        'value' => $adviser['form_data']['Main Office Telephone Number'] ?? '-',
                    ],
                    [
                        'key' => 'Main Office Facsimile Number',
                        'value' => $adviser['form_data']['Main Office Facsimile Number'] ?? '-',
                    ],
                ],
            ],
            [
                'title' => 'Registration & Status',
                'items' => [
                    [
                        'key' => 'Status',
                        'value' => $adviser['form_data']['SEC Current Status'] ?? '-',
                    ],
                    [
                        'key' => 'Status Effective Date',
                        'value' => isset($adviser['form_data']['SEC Status Effective Date']) 
                            ? \Carbon\Carbon::parse($adviser['form_data']['SEC Status Effective Date'])->format('Y-m-d') 
                            : '-',
                    ],
                    [
                        'key' => 'Latest ADV Filing Date',
                        'value' => isset($adviser['form_data']['Latest ADV Filing Date']) 
                            ? \Carbon\Carbon::parse($adviser['form_data']['Latest ADV Filing Date'])->format('Y-m-d') 
                            : '-',
                    ],
                    [
                        'key' => 'Type',
                        'value' => 
                            ($adviser['form_data']['2A(1)'] == 'Y' ? 'Large Advisory Firm' : '') . 
                            ($adviser['form_data']['2A(7)'] == 'Y' ? ', Pension Consultant' : ''),
                    ],
                    [
                        'key' => 'Form of Organization',
                        'value' => ($adviser['form_data']['3A'] ?? '-') . 
                                ($adviser['form_data']['3A-Other'] ? ', ' . $adviser['form_data']['3A-Other'] : ''),
                    ],
                    [
                        'key' => 'Under the laws of which state',
                        'value' => ($adviser['form_data']['3C-State'] ?? '-') . ', ' . ($adviser['form_data']['3C-Country'] ?? '-'),
                    ],
                ],
            ],
            [
                'title' => 'Employees & Clients',
                'items' => [
                    [
                        'key' => 'Employees Count',
                        'value' => $adviser['form_data']['5A'] ?? '-',
                    ],
                    [
                        'key' => 'Investment Advisory Employees',
                        'value' => ($adviser['form_data']['5B(1)'] ?? '-') . ' advisory, ' .
                                ($adviser['form_data']['5B(2)'] ?? '-') . ' broker-dealer reps',
                    ],
                    [
                        'key' => 'Total Clients',
                        'value' => $adviser['form_data']['5C(1)'] ?? '-',
                    ],
                ],
            ],
        ];
        ?>
        <div
            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-x-6 xl:gap-x-4 gap-y-4 text-base leading-normal order-2 lg:order-1">
            @foreach ($cards as $card)
                <div class="bg-white p-4 md:p-6 xl:p-4 2xl:p-6 rounded-lg">
                    <div class="mb-4 text-sm font-semibold text-blue">
                        {{ $card['title'] }}
                    </div>

                    <div class="grid grid-cols-3 xl:grid-cols-2 gap-x-3 gap-y-5">
                        @foreach ($card['items'] as $item)
                            <div>
                                <div
                                    class="text-dark-light2 xl:text-[11px] 2xl:text-sm xl:tracking-[-0.33px] 2xl:tracking-normal">
                                    {{ $item['key'] }}</div>
                                <div class="font-semibold">{{ $item['value'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="order-1 lg:order-2">
            <livewire:investor-adviser.adviser-graph :legalName="$adviser->legal_name" />
        </div>
    </div>
</div>
