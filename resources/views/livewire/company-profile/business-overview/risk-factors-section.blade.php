@php
    $businessContent = $menuLinks['risk_factors'];
    $businessContent = preg_replace('/\s+/', ' ', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('Item 1.', '', $businessContent);

    $businessContent = str_replace('\u{A0}\u{A0}\u{A0}\u{A0}', '', $businessContent);
    $businessContent = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $businessContent);
    $businessContent = preg_replace('/Item 1([a-z]?)./i', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i','', $businessContent);
    $businessContent = preg_replace('/<p[a-z 0-9.;%><:="-\/]+<\/p><\/p>/mi','', $businessContent);
    $stylePatteren = '/style(.?)=(.?)"' . "(.?)[a-z':#0123456789;,\-%.]+" . '"/i';
    $businessContent = preg_replace('/<div/i', "<p" , $businessContent);
    $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', "<p>" , $businessContent);
    $businessContent = preg_replace('/<\/div>/i', "</p>" , $businessContent);
    $businessContent = preg_replace('/<hr(.?)\/>/i', "" , $businessContent);
    $businessContent = str_replace('style="height:42.75pt;position:relative;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="bottom:0;position:absolute;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="min-height:42.75pt;width:100%"', '', $businessContent);
    $businessContent = str_replace('<br/>', '', $businessContent);
    $businessContent = preg_replace('/Apple Inc. | 2022 Form 10-K | [0-9]+/i', '', $businessContent);
    $businessContent = str_replace('||', '', $businessContent);

    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9_-]+("|\')(.?)\/>/mi', "" , $businessContent);
    $businessContent = str_replace('<p style="min-height:42.75pt;width:100%"><p style="text-align:justify"><span><br/></span></p></p>', '', $businessContent);
    $businessContent = preg_replace('/<hr (.?)[a-z="-:]+\/>/mi', "" , $businessContent);

    $businessContent = preg_replace('/Risk Factors(?=\<) /i', "<p class='title'>Risk Factors</p>" , $businessContent, 1);
    $businessContent = preg_replace('/Risk Factors</i', "<p class='title'>Risk Factors</p><" , $businessContent, 1);

    $businessContent=preg_replace('/>Macroeconomic and Industry Risks</i', "><span class='anchor' id='business-information-macroeconomic'></span><p class='subtitle'>Macroeconomic and Industry Risks</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Business Risks</i', "><span class='anchor' id='business-information-business-risks'></span><p class='subtitle'>Business Risks</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Legal and Regulatory Compliance Risks</i', "><span class='anchor' id='business-information-compliance-risk'></span><p class='subtitle'>Legal and Regulatory Compliance Risks</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Financial Risks</i', "><span class='anchor' id='business-information-financial-risks'></span><p class='subtitle'>Financial Risks</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>General Risks</i', "><span class='anchor' id='business-information-general-risks'></span><p class='subtitle'>General Risks</p><" , $businessContent, 1);
    $businessContent = str_replace('<p style="padding-left:45pt;text-align:justify;text-indent:-45pt"><span style="color:#000000;font-family:\'Helvetica\',sans-serif;font-size:9pt;font-weight:700;line-height:120%"><p class=\'title\'>Risk Factors</p></span></p>', '<p class=\'title\'>Risk Factors</p>', $businessContent);
    $businessContent = str_replace('9pt', '14px', $businessContent);
    $sidebarLinks = [];
    if(preg_match('/>Macroeconomic and Industry Risks</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Macroeconomic and Industry Risks',
            'link' => '#business-information-macroeconomic',
            'startRegex' => "<p class='subtitle'>Macroeconomic and Industry Risks<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-business-risks'><\/span>",
        ];
    }
    if(preg_match('/>Business Risks</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Business Risks',
            'link' => '#business-information-business-risks',
            'startRegex' => "<p class='subtitle'>Business Risks<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-compliance-risk'><\/span>",
        ];
    }
    if(preg_match('/>Legal and Regulatory Compliance Risks</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Legal and Regulatory Compliance Risks',
            'link' => '#business-information-compliance-risk',
            'startRegex' => "<p class='subtitle'>Legal and Regulatory Compliance Risks<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-financial-risks'><\/span>",
        ];
    }
    if(preg_match('/>Financial Risks</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Financial Risks',
            'link' => '#business-information-financial-risks',
            'startRegex' => "<p class='subtitle'>Financial Risks<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-general-risks'><\/span>",
        ];
    }
    if(preg_match('/>General Risks</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'General Risks',
            'link' => '#business-information-general-risks',
            'startRegex' => "<p class='subtitle'>General Risks<\/p>",
            'endRegex' => "",
        ];
    }
@endphp

@include('livewire.company-profile.business-overview.content')
