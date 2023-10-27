<div class="flex flex-row bussiness-information  flex-wrap lg:flex-nowrap">
    <div class="bussiness-information-left order-2 lg:order-1 basis-full  lg:basis-3/4 ">
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
                // $businessContent = preg_replace($stylePatteren,'', $businessContent);

                $businessContent = preg_replace('/Risk Factors(?=\<) /i', "<p class='title'>Risk Factors</p>" , $businessContent, 1);
                $businessContent = preg_replace('/Risk Factors</i', "<p class='title'>Risk Factors</p><" , $businessContent, 1);

                $businessContent=preg_replace('/>Macroeconomic and Industry Risks</i', "><br><p id='business-information-macroeconomic' class='subtitle'>Macroeconomic and Industry Risks</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>Business Risks</i', "><br><p id='business-information-business-risks' class='subtitle'>Business Risks</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>Legal and Regulatory Compliance Risks</i', "><br><p id='business-information-compliance-risk' class='subtitle'>Legal and Regulatory Compliance Risks</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>Financial Risks</i', "><br><p id='business-information-financial-risks' class='subtitle'>Financial Risks</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>General Risks</i', "><br><p id='business-information-general-risks' class='subtitle'>General Risks</p><" , $businessContent, 1);
            @endphp
            {!!$businessContent!!}
            @php
            $sidebarLinks = [];
            if(preg_match('/>Macroeconomic and Industry Risks</i', $businessContent)){
                $sidebarLinks[] = [
                    'anchorText' => 'Macroeconomic and Industry Risks',
                    'link' => '#business-information-macroeconomic'
                ];
            }
            if(preg_match('/>Business Risks</i', $businessContent)){
                $sidebarLinks[] = [
                    'anchorText' => 'Business Risks',
                    'link' => '#business-information-business-risks'
                ];
            }
            if(preg_match('/>Legal and Regulatory Compliance Risks</i', $businessContent)){
                $sidebarLinks[] = [
                    'anchorText' => 'Legal and Regulatory Compliance Risks',
                    'link' => '#business-information-compliance-risk'
                ];
            }
            if(preg_match('/>Financial Risks</i', $businessContent)){
                $sidebarLinks[] = [
                    'anchorText' => 'Financial Risks',
                    'link' => '#business-information-financial-risks'
                ];
            }
            if(preg_match('/>General Risks</i', $businessContent)){
                $sidebarLinks[] = [
                    'anchorText' => 'General Risks',
                    'link' => '#business-information-general-risks'
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
