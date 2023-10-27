<div class="white-card">
    @php
    $businessContent = $menuLinks['legal_proceedings'];
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
    $businessContent = preg_replace('/Legal Proceedings(?=\<) /i', "<p class='title'>Legal Proceedings</p>" , $businessContent, 1);
    $businessContent=preg_replace('/Legal Proceedings</i', "<p class='title'>Legal Proceedings</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Epic Games</i', "><br><p class='subtitle'>Epic Games</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Other Legal Proceedings</i', "><br><p class='subtitle'>Other Legal Proceedings</p><" ,$businessContent, 1);
    @endphp
    {!!$businessContent!!}

</div>
