<div class="flex flex-row bussiness-information  flex-wrap lg:flex-nowrap">
    <div class="bussiness-information-left order-2 lg:order-1 basis-full  lg:basis-3/4 ">
        <div class="white-card">
    @php
    $businessContent = $menuLinks['managements_discussion'];
    $businessContent = preg_replace('/\s+/', ' ', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('Item 1.', '', $businessContent);
    $businessContent = preg_replace('/Item [0-9]([a-z]?)./i', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i','', $businessContent);
    // style(.?)=(.?)"(.?)[a-z':#0123456789;,\-%]+"
    $stylePatteren = '/style(.?)=(.?)"' . "(.?)[a-z':#0123456789;,\-%.]+" . '"/i';
    $businessContent = preg_replace('/<div/i', "<p" , $businessContent);
    $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', "<p>" , $businessContent);
    $businessContent = preg_replace('/<\/div>/i', "</p>" , $businessContent);

    // $businessContent = preg_replace($stylePatteren,'', $businessContent);
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
    @endphp
    {!!$businessContent!!}
    @php
    $sidebarLinks = [];
    if(preg_match('/>Fiscal Year Highlights</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Fiscal Year Highlights',
            'link' => '#business-information-fiscal-year-highlights'
        ];
    }
    if(preg_match('/>Products and Services Performance</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Products and Services Performance',
            'link' => '#business-information-products-services-performance'
        ];
    }
    if(preg_match('/>Segment Operating Performance</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Segment Operating Performance',
            'link' => '#business-information-segment-operating-performance'
        ];
    }
    if(preg_match('/>Gross Margin</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Gross Margin',
            'link' => '#business-information-gross-margin'
        ];
    }
    if(preg_match('/>Operating Expenses</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Operating Expenses',
            'link' => '#business-information-operating-expenses'
        ];
    }
    if(preg_match('/>Other Income\/[(]Expense[)], Net</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Other Income/(Expense), Net',
            'link' => '#business-information-other-income'
        ];
    }
    if(preg_match('/>Provision for Income Taxes</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Provision for Income Taxes',
            'link' => '#business-information-provision-income-taxes'
        ];
    }
    if(preg_match('/>Liquidity and Capital Resources</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Liquidity and Capital Resources',
            'link' => '#business-information-liquidity-capital'
        ];
    }
    if(preg_match('/>Manufacturing Purchase Obligations</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Manufacturing Purchase Obligations',
            'link' => '#business-information-manufacturing-purchase'
        ];
    }
    if(preg_match('/>Critical Accounting Estimates</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Critical Accounting Estimates',
            'link' => '#business-information-critical-accounting'
        ];
    }
    @endphp
</div>
</div>
<div class="bussiness-information-right order-1 lg:order-2 basis-full lg:basis-1/4">

<div class="white-card sticky-sidebar">

    <ul class="list-items" x-data="{
        activeLink: ''
    }">
        @foreach ($sidebarLinks as $item)

        <li>
            <a
            :class="{'active': activeLink == '{{$item['link']}}'}"
            x-on:click="activeLink = '{{$item['link']}}'"
                href="{{$item['link']}}">
                {{$item['anchorText']}}
            </a>
        </li>

        @endforeach
    </ul>
    <div class="flex justify-end">
        <span class="business-footer-text">
            <a href="{{$menuLinks['s3_url']}}">Source: FY {{date('Y', strtotime('acceptance_time'))}} 10-k</a>
        </span>
    </div>
</div>
</div>
</div>
