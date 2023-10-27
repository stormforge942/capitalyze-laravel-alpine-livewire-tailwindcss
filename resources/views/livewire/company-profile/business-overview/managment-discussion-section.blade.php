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

    $businessContent = preg_replace($stylePatteren,'', $businessContent);
    $businessContent = preg_replace('/Management’s Discussion and Analysis of Financial Condition and Results of Operations(?=\<) /i', "<p class='title'>Management’s Discussion and Analysis of Financial Condition and Results of Operations</p>" , $businessContent, 1);
    $businessContent=preg_replace('/Management’s Discussion and Analysis of Financial Condition and Results of Operations</i', "<p class='title'>Management’s Discussion and Analysis of Financial Condition and Results of Operations</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Fiscal Year Highlights</i', "><br><p class='subtitle'>Fiscal Year Highlights</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Products and Services Performance</i', "><br><p class='subtitle'>Products and Services Performance</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Segment Operating Performance</i', "><br><p class='subtitle'>Segment Operating Performance</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Gross Margin</i', "><br><p class='subtitle'>Gross Margin</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Operating Expenses</i', "><br><p class='subtitle'>Operating Expenses</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Other Income\/[(]Expense[)], Net</i', "><br><p class='subtitle'>Other Income/(Expense), Net</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Provision for Income Taxes</i', "><br><p class='subtitle'>Provision for Income Taxes</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Liquidity and Capital Resources</i', "><br><p class='subtitle'>Liquidity and Capital Resources</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Manufacturing Purchase Obligations</i', "><br><p class='subtitle'>Manufacturing Purchase Obligations</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Critical Accounting Estimates</i', "><br><p class='subtitle'>Critical Accounting Estimates</p><" ,$businessContent, 1);
    @endphp
    {!!$businessContent!!}

</div>
