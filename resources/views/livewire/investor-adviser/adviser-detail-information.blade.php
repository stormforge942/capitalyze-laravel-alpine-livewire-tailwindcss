<?php
$tabs = [
    [
        'title' => 'Item 1 Identifying Information',
        'content' => 'livewire.investor-adviser.form-section.identifying-information',
    ],
    [
        'title' => 'Item 2 SEC Registration/Reporting',
        'content' => 'livewire.investor-adviser.form-section.sec-registration-reporting',
    ],
    [
        'title' => 'Item 3 Form of Organization',
        'content' => 'livewire.investor-adviser.form-section.form-organization',
    ],
    [
        'title' => 'Item 4 Successions',
        'content' => 'livewire.investor-adviser.form-section.successions',
    ],
    [
        'title' => 'Item 5 Information About Your Advisory Business',
        'content' => 'livewire.investor-adviser.form-section.information-advisory-business',
    ],
    [
        'title' => 'Item 6 Other Business Activites',
        'content' => 'livewire.investor-adviser.form-section.other-business-activities',
    ],
    [
        'title' => 'Item 7.A Financial Industry Afilliations',
        'content' => 'livewire.investor-adviser.form-section.financial-industry-afilliations',
    ],
    [
        'title' => 'Item 7.B Private Fund Reporting',
        'content' => 'livewire.investor-adviser.form-section.private-fund',
    ],
    [
        'title' => 'Item 8 Participation or Interest in Client Transactions',
        'content' => 'livewire.investor-adviser.form-section.client-transactions',
    ],
    [
        'title' => 'Item 9 Custody',
        'content' => 'livewire.investor-adviser.form-section.custody',
    ],
    [
        'title' => 'Item 10 Control Persons',
        'content' => 'livewire.investor-adviser.form-section.control-persons',
    ],
    [
        'title' => 'Item 11 Disclosure Information',
        'content' => 'livewire.investor-adviser.form-section.disclosure-information',
    ],
    [
        'title' => 'Item 12 Small Businesses',
        'content' => 'livewire.investor-adviser.form-section.small-businesses',
    ],
];
?>

<div x-data="{ active: 0 }">
    <div class="flex gap-6">
        <div class="lg:max-w-[723px] xl:max-w-[800px] flex-1">
            <x-card>
                @foreach ($tabs as $idx => $tab)
                    <div x-show="active === {{ $idx }}" x-cloak>
                        @include($tab['content'])
                    </div>
                @endforeach
            </x-card>
        </div>

        <div class="max-w-[300px] w-full">
            <x-card class="sticky top-2">
                <div class="space-y-2 text-blue">
                @foreach ($tabs as $idx => $tab)
                    <button @click.prevent="active = {{ $idx }}" class="w-full py-2 px-4 text-left rounded transition"
                        :class="active === {{ $idx }} ? 'border-green-light3 bg-green-light4 text-dark font-medium' :
                            'border-green-muted hover:bg-gray-200  text-blue font-normal'">
                        {{ $tab['title'] }}
                    </button>
                @endforeach
                </div>
            </x-card>
        </div>
    </div>
</div>
