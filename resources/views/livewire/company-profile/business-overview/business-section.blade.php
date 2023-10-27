<div class="flex flex-row bussiness-information  flex-wrap lg:flex-nowrap">
    <div class="bussiness-information-left order-2 lg:order-1 basis-full  lg:basis-3/4 ">
        <div class="white-card">
            @php
            $businessContent = $menuLinks['business'];
            $businessContent = preg_replace('/\s+/', ' ', $businessContent);
            $businessContent = str_replace('\n', '', $businessContent);
            $businessContent = str_replace('\n', '', $businessContent);
            $businessContent = str_replace('Item 1.', '', $businessContent);

            $businessContent = preg_replace('/Item 1([a-z]?)./i', '', $businessContent);
            $businessContent = preg_replace('/class="(.?)+"/i','', $businessContent);
            // style(.?)=(.?)"(.?)[a-z':#0123456789;,\-%]+"
            // $stylePatteren = '/style(.?)=(.?)"' . "(.?)[a-z':#0123456789;,\-%.]+" . '"/i';
            $businessContent = preg_replace('/<div/i', "<p" , $businessContent);
            $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', "<p>" , $businessContent);
            $businessContent = preg_replace('/<\/div>/i', "</p>" , $businessContent);

            // $businessContent = preg_replace($stylePatteren,'', $businessContent);
            $businessContent = preg_replace('/business(?=\<) /i', "<p class='title'>Business</p>" , $businessContent, 1);
            $businessContent=preg_replace('/business</i', "<p class='title'>Business</p><" , $businessContent, 1);
            $businessContent=preg_replace('/>company background</i', "><span class='anchor' id='business-information-company-background'></span><p class='subtitle'>Company Background</p><" ,$businessContent, 1);
            $businessContent=preg_replace('/>products</i', "><span class='anchor' id='business-information-products'></span><p class='subtitle'>Products</p><" ,$businessContent, 1);
            $businessContent=preg_replace('/>services</i', "><span class='anchor' id='business-information-services'></span><p class='subtitle'>Services</p><" , $businessContent, 1);
            $businessContent=preg_replace('/>markets and distribution</i', "><span class='anchor' id='business-information-market-distribution'></span><p class='subtitle'>Markets and Distribution</p><" , $businessContent,1);
            $businessContent=preg_replace('/>competition</i', "><span class='anchor' id='business-information-competition'></span><p class='subtitle'>Competition</p><" ,$businessContent, 1);
            $businessContent=preg_replace('/>supply of components</i', "><span class='anchor' id='business-information-supply-of-components'></span><p class='subtitle'>Supply of Components</p><" , $businessContent, 1);
            $businessContent=preg_replace('/>research and development</i', "><span class='anchor' id='business-information-rnd'></span><p class='subtitle'>Research and Development</p><" , $businessContent, 1);
            $businessContent=preg_replace('/>intellectual property</i', "><span class='anchor' id='business-information-intellectual-property'></span><p class='subtitle'>Intellectual Property</p><" , $businessContent, 1);
            $businessContent=preg_replace('/>business seasonality and product introductions</i', "><span class='anchor' id='business-information-business-seasonality'></span><p class='subtitle'>Business Seasonality and Product Introductions</p><" , $businessContent, 1);
            $businessContent=preg_replace('/>human capital</i', "><span class='anchor' id='business-information-human-capital'></span><p class='subtitle'>Human Capital</p><" ,$businessContent, 1);
            $businessContent=preg_replace('/>available information</i', "><span class='anchor' id='business-information-available-information'></span><p class='subtitle'>Available Information</p><" , $businessContent, 1);
            @endphp
            {!!$businessContent!!}

            @php
                $sidebarLinks = [];
                if(preg_match('/>company background</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Company Background',
                        'link' => '#business-information-company-background'
                    ];
                }
                if(preg_match('/>products</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Products',
                        'link' => '#business-information-products'
                    ];
                }
                if(preg_match('/>services</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Services',
                        'link' => '#business-information-services'
                    ];
                }
                if(preg_match('/>markets and distribution</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Markets and Distribution',
                        'link' => '#business-information-market-distribution'
                    ];
                }
                if(preg_match('/>competition</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Competition',
                        'link' => '#business-information-competition'
                    ];
                }
                if(preg_match('/>supply of components</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Supply of Components',
                        'link' => '#business-information-supply-of-components'
                    ];
                }
                if(preg_match('/>research and development</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Research and Development',
                        'link' => '#business-information-rnd'
                    ];
                }
                if(preg_match('/>intellectual property</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Intellectual Property',
                        'link' => '#business-information-intellectual-property'
                    ];
                }
                if(preg_match('/>business seasonality and product introductions</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Business Seasonality and Product Introductions',
                        'link' => '#business-information-business-seasonality'
                    ];
                }
                if(preg_match('/>human capital</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Human Capital',
                        'link' => '#business-information-human-capital'
                    ];
                }
                if(preg_match('/>available information</i', $businessContent)){
                    $sidebarLinks[] = [
                        'anchorText' => 'Available Information',
                        'link' => '#business-information-available-information'
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
