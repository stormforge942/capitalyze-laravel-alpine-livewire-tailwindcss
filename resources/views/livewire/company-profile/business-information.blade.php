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
        'title' => "Management's Discussion and Analysis",
        'content' => 'livewire.company-profile.business-overview.managment-discussion-section',
    ],
    [
        'title' => 'Legal Proceedings',
        'content' => 'livewire.company-profile.business-overview.legal-proceedings-section',
    ],
];
?>

<div x-data="{ active: 0 }">
    <div class="bg-white rounded py-3 px-2 max-w-[612px] lg:max-w-[723px] xl:max-w-[800px] w-full mb-6 flex flex-wrap items-center gap-x-4 gap-y-4 text-sm [&>*]:tracking-[-0.12px]">
        @foreach ($tabs as $idx => $tab)
            <button @click.prevent="active = {{ $idx }}" class="px-2 py-2 border rounded-full transition"
                :class="active === {{ $idx }} ? 'border-green-light3 bg-green-light4 text-dark font-medium' :
                    'border-green-muted hover:bg-gray-200 text-dark font-normal'">
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
