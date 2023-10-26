<div id="business-information" class="cards-wrapper wide-cards-wrapper">

    <div class="flex flex-wrap lg:flex-nowrap nav-top">
        <div class=" basis-full order-2 lg:order-1  lg:basis-3/4">
            <div class="white-card-nav">
                <ul class="nav-top-list">
                    <li><a href="" class="active">Business</a></li>
                    <li><a href="">Risk Factors</a></li>
                    <li><a href="">Managenent's Discussion and Analysis</a></li>
                    <li><a href="">Properties</a></li>
                    <li><a href="">Legal Proceedings</a></li>

                </ul>
            </div>
        </div>
        <div class="bussiness-information-right order-1 lg:order-2 basis-full lg:basis-1/4">
        </div>
    </div>

    <div class="flex flex-row bussiness-information  flex-wrap lg:flex-nowrap">
        <div class="bussiness-information-left order-2 lg:order-1 basis-full  lg:basis-3/4 ">

            <div class="white-card">
                @php
                $businessContent = $menuLinks['business'];
                $businessContent = preg_replace('/\s+/', ' ', $businessContent);
                $businessContent = str_replace('\n', '', $businessContent);
                $businessContent = str_replace('\t', '', $businessContent);
                $businessContent = preg_replace('/class="(.?)+"/i','', $businessContent);
                $businessContent = preg_replace('/business(?=\<) /i', "<p class='title'>Business</p>" , $businessContent, 1);
                $businessContent=preg_replace('/business</i', "<p class='title'>Business</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>company background</i', "><p class='subtitle'>Company Background</p><" ,$businessContent, 1);
                $businessContent=preg_replace('/>products</i', "><p class='subtitle'>Products</p><" ,$businessContent, 1);
                $businessContent=preg_replace('/>services</i', "><p class='subtitle'>Services</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>markets and distribution</i', "><p class='subtitle'>Markets and Distribution</p><" , $businessContent,1);
                $businessContent=preg_replace('/>competition</i', "><p class='subtitle'>Competition</p><" ,$businessContent, 1);
                $businessContent=preg_replace('/>supply of components</i', "><p class='subtitle'>Supply of Components</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>research and development</i', "><p class='subtitle'>Research and Development</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>intellectual property</i', "><p class='subtitle'>Intellectual Property</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>business seasonality and product introductions</i', "><p class='subtitle'>Business Seasonality and Product Introductions</p><" , $businessContent, 1);
                $businessContent=preg_replace('/>human capital</i', "><p class='subtitle'>Human Capital</p><" ,$businessContent, 1);
                $businessContent=preg_replace('/>available information</i', "><p class='subtitle'>Available Information</p><" , $businessContent, 1);
                @endphp
                    {!!$businessContent!!}
                </div>
            </div>
        </div>
        <div class="bussiness-information-right order-1 lg:order-2 basis-full lg:basis-1/4">

            <div class="white-card">

                <ul class="list-items">
                    <li>
                        <a href="#" class="active">Company Background</a>
                    </li>
                    <li>
                        <a href="#">Products</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Markets and Distribution</a>
                    </li>
                    <li>
                        <a href="#">Competition</a>
                    </li>
                    <li>
                        <a href="#">Supply of Components</a>
                    </li>
                    <li>
                        <a href="#">Research and Development</a>
                    </li>
                    <li>
                        <a href="#">Intellectual Properties</a>
                    </li>
                    <li>
                        <a href="#">Business Seasonality and Product Introductions</a>
                    </li>
                    <li>
                        <a href="#">Human Capital</a>
                    </li>
                </ul>
                <div class="flex justify-end">
                    <span class="business-footer-text">
                        Source: FY 2022 10-k
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
