<?php
$tabs = [
    [
        'title' => 'Business',
        'content' => 'livewire.company-profile.business-overview.business-section',
    ],
    [
        'title' => 'Risk Factors',
        'content' => 'livewire.company-profile.business-overview.risk-factors-section',
    ],
    [
        'title' => "Managenent's Discussion and Analysis",
        'content' => 'livewire.company-profile.business-overview.managment-discussion-section',
    ],
    [
        'title' => 'Legal Proceedings',
        'content' => 'livewire.company-profile.business-overview.legal-proceedings-section',
    ],
];
?>

<div x-data="{ active: 0 }">
    <div class="max-w-[612px] lg:max-w-[723px] xl:max-w-[800px] w-full mb-6 flex flex-wrap items-center gap-x-2 gap-y-4 text-sm [&>*]:tracking-[-0.12px]">
        @foreach ($tabs as $idx => $tab)
            <button @click.prevent="active = {{ $idx }}" class="p-2 border rounded-full transition"
                :class="active === {{ $idx }} ? 'border-green-dark bg-green bg-opacity-20' :
                    'border-[#D1D3D5] hover:bg-gray-200'">
                {{ $tab['title'] }}
            </button>
        @endforeach
    </div>

    @foreach ($tabs as $idx => $tab)
        <div x-show="active === {{ $idx }}" x-cloak>
            @include($tab['content'])
        </div>
    @endforeach
</div>
