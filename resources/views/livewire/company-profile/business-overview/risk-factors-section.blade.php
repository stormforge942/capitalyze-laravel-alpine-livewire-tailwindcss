<div class="white-card">
    @php
    $businessContent = $menuLinks['risk_factors'];
    $businessContent = preg_replace('/\s+/', ' ', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('Item 1.', '', $businessContent);
    $businessContent = preg_replace('/Item 1([a-z]?)./i', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i','', $businessContent);
    // style(.?)=(.?)"(.?)[a-z':#0123456789;,\-%]+"
    $stylePatteren = '/style(.?)=(.?)"' . "(.?)[a-z':#0123456789;,\-%.]+" . '"/i';
    $businessContent = preg_replace('/<div/i', "<p" , $businessContent);
    $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', "<p>" , $businessContent);
    $businessContent = preg_replace('/<\/div>/i', "</p>" , $businessContent);
    $businessContent = preg_replace('/<hr(.?)\/>/i', "" , $businessContent);
    $businessContent = preg_replace($stylePatteren,'', $businessContent);

    $businessContent = preg_replace('/Risk Factors(?=\<) /i', "<p class='title'>Risk Factors</p>" , $businessContent, 1);
    $businessContent = preg_replace('/Risk Factors</i', "<p class='title'>Risk Factors</p><" , $businessContent, 1);

    $businessContent=preg_replace('/>Macroeconomic and Industry Risks</i', "><br><p class='subtitle'>Macroeconomic and Industry Risks</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Business Risks</i', "><br><p class='subtitle'>Business Risks</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Legal and Regulatory Compliance Risks</i', "><br><p class='subtitle'>Legal and Regulatory Compliance Risks</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Financial Risks</i', "><br><p class='subtitle'>Financial Risks</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>General Risks</i', "><br><p class='subtitle'>General Risks</p><" , $businessContent, 1);
    @endphp
        {!!$businessContent!!}

</div>
