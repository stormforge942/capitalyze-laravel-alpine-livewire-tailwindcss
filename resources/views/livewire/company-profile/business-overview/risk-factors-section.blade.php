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
<div class="flex flex-row bussiness-information desktop-show flex-wrap lg:flex-nowrap">
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
                @if($key == 0)
                <a
                onclick="scrollToTop()"
                :class="{'active': activeLink == '{{$item['link']}}'}"
                x-on:click="activeLink = '{{$item['link']}}'">
                    {{$item['anchorText']}}
                </a>
                @else
                <a
                onclick="smoothScroll('{{$item['link']}}'.replace('#', ''))"
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
                    <a href="{{$menuLinks['s3_url']}}">Source: FY {{date('Y', strtotime($menuLinks['acceptance_time']))}} 10-k</a>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="mobile-show">
    <div class="bussiness-information" x-data="{ collapse: false }">
        <div class="white-card relative" x-data="{
            activeTab: '{{$sidebarLinks[0]['link']}}'
        }">
            <span class="text_absolute">
                <a href="{{$menuLinks['s3_url']}}">Source: FY {{date('Y', strtotime($menuLinks['acceptance_time']))}} 10-k</a>
            </span>
            <div class="title__header">
                <span class="title">
                    Risk Factors
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
