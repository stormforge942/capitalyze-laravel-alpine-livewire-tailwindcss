@php
    $businessContent = $menuLinks['managements_discussion'];
    $businessContent = preg_replace('/\s+/', ' ', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('Item 1.', '', $businessContent);
    $businessContent = preg_replace('/Item [0-9]([a-z]?)./i', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i','', $businessContent);
    $stylePatteren = '/style(.?)=(.?)"' . "(.?)[a-z':#0123456789;,\-%.]+" . '"/i';
    $businessContent = preg_replace('/<div/i', "<p" , $businessContent);
    $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', "<p>" , $businessContent);
    $businessContent = preg_replace('/<\/div>/i', "</p>" , $businessContent);
    $businessContent = str_replace('\u{A0}\u{A0}\u{A0}\u{A0}', '', $businessContent);
    $businessContent = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i','', $businessContent);
    $businessContent = preg_replace('/<p[a-z 0-9.;%><:="-\/]+<\/p><\/p>/mi','', $businessContent);
    $businessContent = preg_replace('/<hr (.?)[a-z="-:]+\/>/mi', "" , $businessContent);
    $businessContent = str_replace('style="height:42.75pt;position:relative;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="bottom:0;position:absolute;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="min-height:42.75pt;width:100%"', '', $businessContent);
    $businessContent = str_replace('<br/>', '', $businessContent);
    $businessContent = preg_replace('/Apple Inc. | 2022 Form 10-K | [0-9]+/i', '', $businessContent);
    $businessContent = str_replace('||', '', $businessContent);
    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9_-]+("|\')(.?)\/>/mi', "" , $businessContent);
    $businessContent = str_replace('<p style="padding-left:45pt;text-align:justify;text-indent:-45pt"><span style="color:#000000;font-family:\'Helvetica\',sans-serif;font-size:9pt;font-weight:700;line-height:120%">Managements Discussion and Analysis of Financial Condition and Results of Operations</span></p>', '<p class="title">Managements Discussion and Analysis</p>', $businessContent);
    $businessContent = preg_replace('/Management’s Discussion and Analysis of Financial Condition and Results of Operations(?=\<) /i', "<p class='title'>Management’s Discussion and Analysis of Financial Condition and Results of Operations</p>" , $businessContent, 1);
    $businessContent=preg_replace('/Management’s Discussion and Analysis of Financial Condition and Results of Operations</i', "<p class='title'>Management’s Discussion and Analysis of Financial Condition and Results of Operations</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Fiscal Year Highlights</i', "><span class='anchor' id='business-information-fiscal-year-highlights'></span><p class='subtitle'>Fiscal Year Highlights</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Products and Services Performance</i', "><span class='anchor' id='business-information-products-services-performance'></span><p class='subtitle'>Products and Services Performance</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Segment Operating Performance</i', "><span class='anchor' id='business-information-segment-operating-performance'></span><p class='subtitle'>Segment Operating Performance</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Gross Margin</i', "><span class='anchor' id='business-information-gross-margin'></span><p class='subtitle'>Gross Margin</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Operating Expenses</i', "><span class='anchor' id='business-information-operating-expenses'></span><p class='subtitle'>Operating Expenses</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Other Income\/[(]Expense[)], Net</i', "><span class='anchor' id='business-information-other-income'></span><p class='subtitle'>Other Income/(Expense), Net</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Provision for Income Taxes</i', "><span class='anchor' id='business-information-provision-income-taxes'></span><p class='subtitle'>Provision for Income Taxes</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Liquidity and Capital Resources</i', "><span class='anchor' id='business-information-liquidity-capital'></span><p class='subtitle'>Liquidity and Capital Resources</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Manufacturing Purchase Obligations</i', "><span class='anchor' id='business-information-manufacturing-purchase'></span><p class='subtitle'>Manufacturing Purchase Obligations</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Critical Accounting Estimates</i', "><span class='anchor' id='business-information-critical-accounting'></span><p class='subtitle'>Critical Accounting Estimates</p><" ,$businessContent, 1);
    $businessContent = str_replace('9pt', '14px', $businessContent);
    $sidebarLinks = [];
    if(preg_match('/>Fiscal Year Highlights</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Fiscal Year Highlights',
            'link' => '#business-information-fiscal-year-highlights',
            'startRegex' => "<p class='subtitle'>Fiscal Year Highlights<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-products-services-performance'><\/span>",
        ];
    }
    if(preg_match('/>Products and Services Performance</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Products and Services Performance',
            'link' => '#business-information-products-services-performance',
            'startRegex' => "<p class='subtitle'>Products and Services Performance<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-segment-operating-performance'><\/span>",
        ];
    }
    if(preg_match('/>Segment Operating Performance</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Segment Operating Performance',
            'link' => '#business-information-segment-operating-performance',
            'startRegex' => "<p class='subtitle'>Segment Operating Performance<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-gross-margin'><\/span>",
        ];
    }
    if(preg_match('/>Gross Margin</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Gross Margin',
            'link' => '#business-information-gross-margin',
            'startRegex' => "<p class='subtitle'>Gross Margin<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-operating-expenses'><\/span>",
        ];
    }
    if(preg_match('/>Operating Expenses</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Operating Expenses',
            'link' => '#business-information-operating-expenses',
            'startRegex' => "<p class='subtitle'>Operating Expenses<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-other-income'><\/span>",
        ];
    }
    if(preg_match('/>Other Income\/[(]Expense[)], Net</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Other Income/(Expense), Net',
            'link' => '#business-information-other-income',
            'startRegex' => "<p class='subtitle'>Other Income\/\(Expense\), Net<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-provision-income-taxes'><\/span>",
        ];
    }
    if(preg_match('/>Provision for Income Taxes</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Provision for Income Taxes',
            'link' => '#business-information-provision-income-taxes',
            'startRegex' => "<p class='subtitle'>Provision for Income Taxes<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-liquidity-capital'><\/span>",
        ];
    }
    if(preg_match('/>Liquidity and Capital Resources</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Liquidity and Capital Resources',
            'link' => '#business-information-liquidity-capital',
            'startRegex' => "<p class='subtitle'>Liquidity and Capital Resources<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-manufacturing-purchase'><\/span>",
        ];
    }
    if(preg_match('/>Manufacturing Purchase Obligations</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Manufacturing Purchase Obligations',
            'link' => '#business-information-manufacturing-purchase',
            'startRegex' => "<p class='subtitle'>Manufacturing Purchase Obligations<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-critical-accounting'><\/span>",
        ];
    }
    if(preg_match('/>Critical Accounting Estimates</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Critical Accounting Estimates',
            'link' => '#business-information-critical-accounting',
            'startRegex' => "<p class='subtitle'>Critical Accounting Estimates<\/p>",
            'endRegex' => "",
        ];
    }
    @endphp

<div class="flex flex-row bussiness-information desktop-show flex-wrap lg:flex-nowrap">
    <div class="bussiness-information-left order-2 lg:order-1 basis-full  lg:basis-7/12 ">
        <div class="white-card">
            {!!$businessContent!!}
        </div>
    </div>
    <div class="bussiness-information-right order-1 lg:order-2 basis-full lg:basis-1/5">

        <div class="white-card sticky-sidebar">

            <ul class="list-items" x-data="{
        activeLink: ''
    }">
                @foreach ($sidebarLinks as $key => $item)

                <li>
                    @if($key == 0)
                    <a onclick="scrollToTop()" :class="{'active': activeLink == '{{$item['link']}}'}"
                        x-on:click="activeLink = '{{$item['link']}}'">
                        {{$item['anchorText']}}
                    </a>
                    @else
                    <a onclick="smoothScroll('{{$item['link']}}'.replace('#', ''))"
                        :class="{'active': activeLink == '{{$item['link']}}'}"
                        x-on:click="activeLink = '{{$item['link']}}'">
                        {{$item['anchorText']}}
                    </a>
                    @endif
                </li>

                @endforeach
            </ul>
            <div class="flex justify-end">
                <span class="business-footer-text">
                    <a href="{{$menuLinks['s3_url']}}">Source: FY {{date('Y',
                        strtotime($menuLinks['acceptance_time']))}} 10-k</a>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="mobile-show">
    <div class="bussiness-information" x-data="{ collapse: false">
        <div class="white-card relative" x-data="{
            activeTab: '{{$sidebarLinks[0]['link']}}'
        }">
            <span class="text_absolute">
                <a href="{{$menuLinks['s3_url']}}">Source: FY {{date('Y', strtotime($menuLinks['acceptance_time']))}} 10-k</a>
            </span>
            <div class="title__header">
                <span class="title">
                    Managements Discussion and Analysis
                </span>
            </div>
            @foreach($sidebarLinks as $item)
            <div class="accordian_header">
              <span class="title" @click="activeTab = '{{$item['link']}}'">
                {{$item['anchorText']}}
              </span>
              <svg x-show="activeTab != '{{$item['link']}}'" @click="activeTab = '{{$item['link']}}'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8.78126 8.00047L5.48145 4.70062L6.42425 3.75781L10.6669 8.00047L6.42425 12.2431L5.48145 11.3003L8.78126 8.00047Z" fill="#3561E7"/>
            </svg>
            <svg @click="activeTab = ''" x-show="activeTab == '{{$item['link']}}'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M7.99953 8.78126L11.2994 5.48145L12.2422 6.42425L7.99953 10.6669L3.75694 6.42425L4.69973 5.48144L7.99953 8.78126Z" fill="#3561E7"/>
              </svg>
            </div>
            <div class="accordian_body" x-show="activeTab == '{{$item['link']}}'">
                @php
                $matches = [];
                preg_match_all('/' . $item['startRegex'] . '(.*)' . $item['endRegex'] . '/i', $businessContent, $matches);
                $text = $matches[1];
                @endphp
                {!!$text[0] ?? ""!!}
            </div>
            @endforeach
        </div>
    </div>
</div>
