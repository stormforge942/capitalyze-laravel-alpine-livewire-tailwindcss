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

<div id="business-information" class="cards-wrapper wide-cards-wrapper" x-data="{ active: 0 }">
    <div class="flex flex-wrap lg:flex-nowrap nav-top">
        <div class=" basis-full order-2 lg:order-1  lg:basis-7/12">
            <div class="white-card-nav">
                <ul class="nav-top-list">
                    @foreach ($tabs as $idx => $tab)
                        <li>
                            <a href="#" @click.prevent="active = {{ $idx }}"
                                :class="active === {{ $idx }} ? 'active' : ''">
                                {{ $tab['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="bussiness-information-right order-1 lg:order-2 basis-full lg:basis-1/5">
        </div>
    </div>

    @foreach ($tabs as $idx => $tab)
        <div x-show="active === {{ $idx }}" x-cloak>
            @include($tab['content'])
        </div>
    @endforeach
</div>
