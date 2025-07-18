@php
    $businessContent = $menuLinks['managements_discussion'] ?? '';
    $businessContent = preg_replace('/\s+/', ' ', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('Item 1.', '', $businessContent);
    $businessContent = preg_replace('/Item [0-9]([a-z]?)./i', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i', '', $businessContent);
    $stylePatteren = '/style(.?)=(.?)"' . "(.?)[a-z':#0123456789;,\-%.]+" . '"/i';
    $businessContent = preg_replace('/<div/i', '<p', $businessContent);
    $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', '<p>', $businessContent);
    $businessContent = preg_replace('/<\/div>/i', '</p>', $businessContent);
    $businessContent = str_replace('\u{A0}\u{A0}\u{A0}\u{A0}', '', $businessContent);
    $businessContent = preg_replace('/[\x00-\x1F\x7F]/', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i', '', $businessContent);
    $businessContent = preg_replace('/<p[a-z 0-9.;%><:="-\/]+<\/p><\/p>/mi', '', $businessContent);
    $businessContent = preg_replace('/<hr (.?)[a-z="-:]+\/>/mi', '', $businessContent);
    $businessContent = str_replace('style="height:42.75pt;position:relative;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="bottom:0;position:absolute;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="min-height:42.75pt;width:100%"', '', $businessContent);
    $businessContent = str_replace('<br/>', '', $businessContent);
    $businessContent = preg_replace('/Apple Inc. \| \d{4} Form 10-K \| [0-9]+/i', '| Form-K |', $businessContent);
    $businessContent = str_replace('||', '', $businessContent);
    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9_-]+("|\')(.?)\/>/mi', '', $businessContent);
    $businessContent = str_replace('<p style="padding-left:45pt;text-align:justify;text-indent:-45pt"><span style="color:#000000;font-family:\'Helvetica\',sans-serif;font-size:9pt;font-weight:700;line-height:120%">Managements Discussion and Analysis of Financial Condition and Results of Operations</span></p>', '<p class="title">Managements Discussion and Analysis</p>', $businessContent);
    $businessContent = preg_replace('/Management’s Discussion and Analysis of Financial Condition and Results of Operations(?=\<) /i', "<p class='title'>Management’s Discussion and Analysis of Financial Condition and Results of Operations</p>", $businessContent, 1);
    $businessContent = preg_replace('/Management’s Discussion and Analysis of Financial Condition and Results of Operations</i', "<p class='title'>Management’s Discussion and Analysis of Financial Condition and Results of Operations</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Fiscal Year Highlights</i', "><span class='anchor' id='business-information-fiscal-year-highlights'></span><p class='subtitle'>Fiscal Year Highlights</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Products and Services Performance</i', "><span class='anchor' id='business-information-products-services-performance'></span><p class='subtitle'>Products and Services Performance</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Segment Operating Performance</i', "><span class='anchor' id='business-information-segment-operating-performance'></span><p class='subtitle'>Segment Operating Performance</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Gross Margin</i', "><span class='anchor' id='business-information-gross-margin'></span><p class='subtitle'>Gross Margin</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Operating Expenses</i', "><span class='anchor' id='business-information-operating-expenses'></span><p class='subtitle'>Operating Expenses</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Other Income\/[(]Expense[)], Net</i', "><span class='anchor' id='business-information-other-income'></span><p class='subtitle'>Other Income/(Expense), Net</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Provision for Income Taxes</i', "><span class='anchor' id='business-information-provision-income-taxes'></span><p class='subtitle'>Provision for Income Taxes</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Liquidity and Capital Resources</i', "><span class='anchor' id='business-information-liquidity-capital'></span><p class='subtitle'>Liquidity and Capital Resources</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Manufacturing Purchase Obligations</i', "><span class='anchor' id='business-information-manufacturing-purchase'></span><p class='subtitle'>Manufacturing Purchase Obligations</p><", $businessContent, 1);
    $businessContent = preg_replace('/>Critical Accounting Estimates</i', "><span class='anchor' id='business-information-critical-accounting'></span><p class='subtitle'>Critical Accounting Estimates</p><", $businessContent, 1);
    $businessContent = str_replace('9pt', '14px', $businessContent);
    $sidebarLinks = [];
    if (preg_match('/>Fiscal Year Highlights</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Fiscal Year Highlights',
            'link' => '#business-information-fiscal-year-highlights',
            'startRegex' => "<p class='subtitle'>Fiscal Year Highlights<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-products-services-performance'><\/span>",
        ];
    }
    if (preg_match('/>Products and Services Performance</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Products and Services Performance',
            'link' => '#business-information-products-services-performance',
            'startRegex' => "<p class='subtitle'>Products and Services Performance<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-segment-operating-performance'><\/span>",
        ];
    }
    if (preg_match('/>Segment Operating Performance</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Segment Operating Performance',
            'link' => '#business-information-segment-operating-performance',
            'startRegex' => "<p class='subtitle'>Segment Operating Performance<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-gross-margin'><\/span>",
        ];
    }
    if (preg_match('/>Gross Margin</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Gross Margin',
            'link' => '#business-information-gross-margin',
            'startRegex' => "<p class='subtitle'>Gross Margin<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-operating-expenses'><\/span>",
        ];
    }
    if (preg_match('/>Operating Expenses</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Operating Expenses',
            'link' => '#business-information-operating-expenses',
            'startRegex' => "<p class='subtitle'>Operating Expenses<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-other-income'><\/span>",
        ];
    }
    if (preg_match('/>Other Income\/[(]Expense[)], Net</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Other Income/(Expense), Net',
            'link' => '#business-information-other-income',
            'startRegex' => "<p class='subtitle'>Other Income\/\(Expense\), Net<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-provision-income-taxes'><\/span>",
        ];
    }
    if (preg_match('/>Provision for Income Taxes</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Provision for Income Taxes',
            'link' => '#business-information-provision-income-taxes',
            'startRegex' => "<p class='subtitle'>Provision for Income Taxes<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-liquidity-capital'><\/span>",
        ];
    }
    if (preg_match('/>Liquidity and Capital Resources</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Liquidity and Capital Resources',
            'link' => '#business-information-liquidity-capital',
            'startRegex' => "<p class='subtitle'>Liquidity and Capital Resources<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-manufacturing-purchase'><\/span>",
        ];
    }
    if (preg_match('/>Manufacturing Purchase Obligations</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Manufacturing Purchase Obligations',
            'link' => '#business-information-manufacturing-purchase',
            'startRegex' => "<p class='subtitle'>Manufacturing Purchase Obligations<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-critical-accounting'><\/span>",
        ];
    }
    if (preg_match('/>Critical Accounting Estimates</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Critical Accounting Estimates',
            'link' => '#business-information-critical-accounting',
            'startRegex' => "<p class='subtitle'>Critical Accounting Estimates<\/p>",
            'endRegex' => '',
        ];
    }
@endphp

@include('livewire.company-profile.business-overview.content')
