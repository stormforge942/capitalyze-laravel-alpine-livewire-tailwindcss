<div class="flex flex-row bussiness-information  flex-wrap lg:flex-nowrap">
    <div class="bussiness-information-left order-2 lg:order-1 basis-full  lg:basis-3/4 ">
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

    // $businessContent = preg_replace($stylePatteren,'', $businessContent);
    $businessContent = preg_replace('/Legal Proceedings(?=\<) /i', "<p class='title'>Legal Proceedings</p>" , $businessContent, 1);
    $businessContent=preg_replace('/Legal Proceedings</i', "<p class='title'>Legal Proceedings</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>Epic Games</i', "><br><p id='business-information-epic-games' class='subtitle'>Epic Games</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>Other Legal Proceedings</i', "><br><p id='business-information-other-legal-proceedings' class='subtitle'>Other Legal Proceedings</p><" ,$businessContent, 1);
    @endphp
    {!!$businessContent!!}
    @php
    $sidebarLinks = [];
    if(preg_match('/>Epic Games</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Epic Games',
            'link' => '#business-information-epic-games'
        ];
    }
    if(preg_match('/>Other Legal Proceedings</i', $businessContent)){
        $sidebarLinks[] = [
            'anchorText' => 'Other Legal Proceedings',
            'link' => '#business-information-other-legal-proceedings'
        ];
    }
    @endphp
</div>
</div>
<div class="bussiness-information-right order-1 lg:order-2 basis-full lg:basis-1/4">

<div class="white-card">

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
