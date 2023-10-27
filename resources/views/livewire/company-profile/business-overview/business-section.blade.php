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
    $stylePatteren = '/style(.?)=(.?)"' . "(.?)[a-z':#0123456789;,\-%.]+" . '"/i';
    $businessContent = preg_replace('/<div/i', "<p" , $businessContent);
    $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', "<p>" , $businessContent);
    $businessContent = preg_replace('/<\/div>/i', "</p>" , $businessContent);

    $businessContent = preg_replace($stylePatteren,'', $businessContent);
    $businessContent = preg_replace('/business(?=\<) /i', "<p class='title'>Business</p>" , $businessContent, 1);
    $businessContent=preg_replace('/business</i', "<p class='title'>Business</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>company background</i', "><br><p class='subtitle'>Company Background</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>products</i', "><br><p class='subtitle'>Products</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>services</i', "><br><p class='subtitle'>Services</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>markets and distribution</i', "><br><p class='subtitle'>Markets and Distribution</p><" , $businessContent,1);
    $businessContent=preg_replace('/>competition</i', "><br><p class='subtitle'>Competition</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>supply of components</i', "><br><p class='subtitle'>Supply of Components</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>research and development</i', "><br><p class='subtitle'>Research and Development</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>intellectual property</i', "><br><p class='subtitle'>Intellectual Property</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>business seasonality and product introductions</i', "><br><p class='subtitle'>Business Seasonality and Product Introductions</p><" , $businessContent, 1);
    $businessContent=preg_replace('/>human capital</i', "><br><p class='subtitle'>Human Capital</p><" ,$businessContent, 1);
    $businessContent=preg_replace('/>available information</i', "><br><p class='subtitle'>Available Information</p><" , $businessContent, 1);
    @endphp
    {!!$businessContent!!}

</div>
