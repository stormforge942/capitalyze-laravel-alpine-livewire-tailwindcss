@php
    $businessContent = $menuLinks['legal_proceedings'] ?? '';
    $businessContent = preg_replace('/\s+/', ' ', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('Item 1.', '', $businessContent);

    $businessContent = str_replace('\u{A0}\u{A0}\u{A0}\u{A0}', '', $businessContent);
    $businessContent = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $businessContent);
    $businessContent = preg_replace('/Item [0-9]([a-z]?)./i', '', $businessContent);
    $businessContent = str_replace('style="height:42.75pt;position:relative;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="bottom:0;position:absolute;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="min-height:42.75pt;width:100%"', '', $businessContent);
    $businessContent = str_replace('<br/>', '', $businessContent);
    $businessContent = preg_replace('/Apple Inc. | 2022 Form 10-K | [0-9]+/i', '', $businessContent);
    $businessContent = str_replace('||', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i','', $businessContent);
    $stylePatteren = '/style(.?)=(.?)"' . "(.?)[a-z':#0123456789;,\-%.]+" . '"/i';
    $businessContent = preg_replace('/<div/i', "<p" , $businessContent);
    $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', "<p>" , $businessContent);
    $businessContent = preg_replace('/<\/div>/i', "</p>" , $businessContent);
    $businessContent = preg_replace('/<hr(.?)\/>/i', "" , $businessContent);
    $businessContent = preg_replace('/<hr (.?)[a-z="-:]+\/>/mi', "" , $businessContent);
    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9_-]+("|\')(.?)\/>/mi', "" , $businessContent);

    $businessContent = preg_replace('/Legal Proceedings(?=\<) /i', "<p class='title'>Legal Proceedings</p>" , $businessContent, 1);
    $businessContent=preg_replace('/Legal Proceedings</i', "<p class='title'>Legal Proceedings</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Epic Games</i', "><span class='anchor' id='business-information-epic-games'></span><p class='subtitle'>Epic Games</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Other Legal Proceedings</i', "><span class='anchor' id='business-information-other-legal-proceedings'></span><p class='subtitle'>Other Legal Proceedings</p><" ,$businessContent, 1);
    $businessContent = str_replace('<p style="margin-top:18pt;padding-left:45pt;text-align:justify;text-indent:-45pt"><span style="color:#000000;font-family:\'Helvetica\',sans-serif;font-size:9pt;font-weight:700;line-height:120%"><p class=\'title\'>Legal Proceedings</p></span></p>', '<p class=\'title\'>Legal Proceedings</p>', $businessContent);
    $businessContent = str_replace('9pt', '14px', $businessContent);
$sidebarLinks = [];
if(preg_match('/>Epic Games</i', $businessContent)){
    $sidebarLinks[]=[ 'anchorText'=> 'Epic Games',
    'link' => '#business-information-epic-games',
    'startRegex' => "<p class='subtitle'>Epic Games<\/p>",
    'endRegex' => "<span class='anchor' id='business-information-other-legal-proceedings'><\/span>",
];
}
if(preg_match('/>Other Legal Proceedings</i', $businessContent)){ $sidebarLinks[]=[
    'anchorText'=> 'Other Legal Proceedings',
    'link' => '#business-information-other-legal-proceedings',
    'startRegex' => "<p class='subtitle'>Other Legal Proceedings<\/p>",
    'endRegex' => "",
];
}
@endphp

@include('livewire.company-profile.business-overview.content')
