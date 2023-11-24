@php
    $businessContent = $menuLinks['business'];
    $businessContent = preg_replace('/\s+/', ' ', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('Item 1.', '', $businessContent);
    $businessContent = str_replace('\u{A0}\u{A0}\u{A0}\u{A0}', '', $businessContent);
    $businessContent = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $businessContent);
    $businessContent = str_replace('style="height:42.75pt;position:relative;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="bottom:0;position:absolute;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="min-height:42.75pt;width:100%"', '', $businessContent);
    $businessContent = str_replace('<br/>', '', $businessContent);
    $businessContent = preg_replace('/Apple Inc. | 2022 Form 10-K | [0-9]+/i', '', $businessContent);
    $businessContent = str_replace('||', '', $businessContent);
    $businessContent = preg_replace('/<hr(.?)\/>/i', '', $businessContent);
    $businessContent = preg_replace('/Item 1([a-z]?)./i', '', $businessContent);
    $businessContent = preg_replace('/<hr (.?)[a-z="-:]+\/>/mi', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i', '', $businessContent);
    $businessContent = preg_replace('/<div/i', '<p', $businessContent);
    $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', '<p>', $businessContent);
    $businessContent = preg_replace('/<\/div>/i', '</p>', $businessContent);
    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9_-]+("|\')(.?)\/>/mi', '', $businessContent);
    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9:;_-]+("|\')(.?)><[a-z]+(.?)[a-z=";:#0-9-\',%]+>((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)<\/[a-z]+><\/[a-z]>/mi', '', $businessContent);
    $businessContent = preg_replace('/business(?=\<) /i', "<p class='title'>Business</p>", $businessContent, 1);
    $businessContent = preg_replace('/business</i', "<p class='title'>Business</p><", $businessContent, 1);
    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9:;_-]+("|\')(.?)><[a-z]+(.?)[a-z=";:#0-9-\',%>]+<p class=\'title\'>Business<\/p><\/[a-z]+><\/[a-z]+>/mi', "<p class='title'>Business</p>", $businessContent);
    $businessContent = preg_replace('/>company background</i', "><span class='anchor' id='business-information-company-background'></span><p class='subtitle'>Company Background</p><", $businessContent, 1);
    $businessContent = preg_replace('/>products</i', "><span class='anchor' id='business-information-products'></span><p class='subtitle'>Products</p><", $businessContent, 1);
    $businessContent = preg_replace('/>services</i', "><span class='anchor' id='business-information-services'></span><p class='subtitle'>Services</p><", $businessContent, 1);
    $businessContent = preg_replace('/>markets and distribution</i', "><span class='anchor' id='business-information-market-distribution'></span><p class='subtitle'>Markets and Distribution</p><", $businessContent, 1);
    $businessContent = preg_replace('/>competition</i', "><span class='anchor' id='business-information-competition'></span><p class='subtitle'>Competition</p><", $businessContent, 1);
    $businessContent = preg_replace('/>supply of components</i', "><span class='anchor' id='business-information-supply-of-components'></span><p class='subtitle'>Supply of Components</p><", $businessContent, 1);
    $businessContent = preg_replace('/>research and development</i', "><span class='anchor' id='business-information-rnd'></span><p class='subtitle'>Research and Development</p><", $businessContent, 1);
    $businessContent = preg_replace('/>intellectual property</i', "><span class='anchor' id='business-information-intellectual-property'></span><p class='subtitle'>Intellectual Property</p><", $businessContent, 1);
    $businessContent = preg_replace('/>business seasonality and product introductions</i', "><span class='anchor' id='business-information-business-seasonality'></span><p class='subtitle'>Business Seasonality and Product Introductions</p><", $businessContent, 1);
    $businessContent = preg_replace('/>human capital</i', "><span class='anchor' id='business-information-human-capital'></span><p class='subtitle'>Human Capital</p><", $businessContent, 1);
    $businessContent = preg_replace('/>available information</i', "><span class='anchor' id='business-information-available-information'></span><p class='subtitle'>Available Information</p><", $businessContent, 1);
    $businessContent = str_replace('9pt', '14px', $businessContent);
    $sidebarLinks = [];
    if (preg_match('/>company background</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Company Background',
            'link' => '#business-information-company-background',
            'startRegex' => "<p class='subtitle'>Company Background<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-products'><\/span>",
        ];
    }
    if (preg_match('/>products</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Products',
            'link' => '#business-information-products',
            'startRegex' => "<p class='subtitle'>Products<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-services'><\/span>",
        ];
    }
    if (preg_match('/>services</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Services',
            'link' => '#business-information-services',
            'startRegex' => "<p class='subtitle'>Services<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-market-distribution'><\/span>",
        ];
    }
    if (preg_match('/>markets and distribution</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Markets and Distribution',
            'link' => '#business-information-market-distribution',
            'startRegex' => "<p class='subtitle'>Markets and Distribution<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-competition'><\/span>",
        ];
    }
    if (preg_match('/>competition</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Competition',
            'link' => '#business-information-competition',
            'startRegex' => "<p class='subtitle'>Markets and Distribution<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-supply-of-components'><\/span>",
        ];
    }
    if (preg_match('/>supply of components</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Supply of Components',
            'link' => '#business-information-supply-of-components',
            'startRegex' => "<p class='subtitle'>Supply of Components<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-rnd'><\/span>",
        ];
    }
    if (preg_match('/>research and development</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Research and Development',
            'link' => '#business-information-rnd',
            'startRegex' => "<p class='subtitle'>Research and Development<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-intellectual-property'><\/span>",
        ];
    }
    if (preg_match('/>intellectual property</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Intellectual Property',
            'link' => '#business-information-intellectual-property',
            'startRegex' => "<p class='subtitle'>Intellectual Property<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-business-seasonality'><\/span>",
        ];
    }
    if (preg_match('/>business seasonality and product introductions</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Business Seasonality and Product Introductions',
            'link' => '#business-information-business-seasonality',
            'startRegex' => "<p class='subtitle'>Business Seasonality and Product Introductions<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-human-capital'><\/span>",
        ];
    }
    if (preg_match('/>human capital</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Human Capital',
            'link' => '#business-information-human-capital',
            'startRegex' => "<p class='subtitle'>Human Capital<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-available-information'><\/span>",
        ];
    }
    if (preg_match('/>available information</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Available Information',
            'link' => '#business-information-available-information',
            'startRegex' => "<p class='subtitle'>Available Information<\/p>",
            'endRegex' => '<p ><p ><\/p><\/p>',
        ];
    }
@endphp

<div class="flex flex-row desktop-show bussiness-information  flex-wrap lg:flex-nowrap">
    <div class="bussiness-information-left order-2 lg:order-1 basis-full  lg:basis-7/12 ">
        <div class="white-card">
            {!! $businessContent !!}
        </div>
    </div>
    <div class="bussiness-information-right order-1 lg:order-2 basis-full lg:basis-1/5">

        <div class="white-card sticky-sidebar">

            <ul class="list-items" x-data="{
                activeLink: ''
            }">
                @foreach ($sidebarLinks as $key => $item)
                    <li>
                        @if ($key == 0)
                            <a onclick="scrollToTop()" :class="{ 'active': activeLink == '{{ $item['link'] }}' }"
                                x-on:click="activeLink = '{{ $item['link'] }}'">
                                {{ $item['anchorText'] }}
                            </a>
                        @else
                            <a onclick="smoothScroll('{{ $item['link'] }}'.replace('#', ''))"
                                :class="{ 'active': activeLink == '{{ $item['link'] }}' }"
                                x-on:click="activeLink = '{{ $item['link'] }}'">
                                {{ $item['anchorText'] }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
            <div class="flex justify-end">
                <span class="business-footer-text">
                    <a href="{{ $menuLinks['s3_url'] }}">Source: FY
                        {{ date('Y', strtotime($menuLinks['acceptance_time'])) }} 10-K</a>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="mobile-show">
    <div class="bussiness-information" x-data="{ collapse: false }">
        <div class="white-card relative" x-data="{
            activeTab: '{{ $sidebarLinks[0]['link'] }}'
        }">
            <span class="text_absolute">
                <a href="{{ $menuLinks['s3_url'] }}">Source: FY
                    {{ date('Y', strtotime($menuLinks['acceptance_time'])) }} 10-K</a>
            </span>
            <div class="title__header">
                <span class="title">
                    Business
                </span>
            </div>
            @foreach ($sidebarLinks as $item)
                <div class="accordian_header">
                    <span class="title" @click="activeTab = '{{ $item['link'] }}'">
                        {{ $item['anchorText'] }}
                    </span>
                    <svg x-show="activeTab != '{{ $item['link'] }}'" @click="activeTab = '{{ $item['link'] }}'"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M8.78126 8.00047L5.48145 4.70062L6.42425 3.75781L10.6669 8.00047L6.42425 12.2431L5.48145 11.3003L8.78126 8.00047Z"
                            fill="#3561E7" />
                    </svg>
                    <svg @click="activeTab = ''" x-show="activeTab == '{{ $item['link'] }}'"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M7.99953 8.78126L11.2994 5.48145L12.2422 6.42425L7.99953 10.6669L3.75694 6.42425L4.69973 5.48144L7.99953 8.78126Z"
                            fill="#3561E7" />
                    </svg>
                </div>
                <div class="accordian_body" x-show="activeTab == '{{ $item['link'] }}'">
                    @php
                        $matches = [];
                        preg_match_all('/' . $item['startRegex'] . '(.*)' . $item['endRegex'] . '/i', $businessContent, $matches);
                        $text = $matches[1];
                    @endphp
                    {!! $text[0] ?? '' !!}
                </div>
            @endforeach
        </div>
    </div>
</div>
