<div id="business-information" class="cards-wrapper wide-cards-wrapper">

    <div class="flex flex-wrap lg:flex-nowrap nav-top">
        <div class=" basis-full order-2 lg:order-1  lg:basis-3/4">
            <div class="white-card-nav">
                <ul class="nav-top-list">
                    <li><a wire:click="$set('activeBusinessSection', 'business')" {{$activeBusinessSection == 'business' ? "class=active" : ''}}>Business</a></li>
                    <li><a wire:click="$set('activeBusinessSection', 'risk-factors')" {{$activeBusinessSection == 'risk-factors' ? "class=active" : ''}}>Risk Factors</a></li>
                    <li><a wire:click="$set('activeBusinessSection', 'managment-discussions')" {{$activeBusinessSection == 'managment-discussions' ? "class=active" : ''}}>Managenent's Discussion and Analysis</a></li>
                    <li><a wire:click="$set('activeBusinessSection', 'legal-proceedings')" {{$activeBusinessSection == 'legal-proceedings' ? "class=active" : ''}}>Legal Proceedings</a></li>

                </ul>
            </div>
        </div>
        <div class="bussiness-information-right order-1 lg:order-2 basis-full lg:basis-1/4">
        </div>
    </div>

    <div class="flex flex-row bussiness-information  flex-wrap lg:flex-nowrap">
        <div class="bussiness-information-left order-2 lg:order-1 basis-full  lg:basis-3/4 ">
            @if($activeBusinessSection == 'business')
                @include('livewire.company-profile.business-overview.business-section')
                @elseif($activeBusinessSection == 'risk-factors')
                @include('livewire.company-profile.business-overview.risk-factors-section')
                @elseif($activeBusinessSection == 'managment-discussions')
                @include('livewire.company-profile.business-overview.managment-discussion-section')
                @elseif($activeBusinessSection == 'properties')
                @include('livewire.company-profile.business-overview.properties-section')
                @elseif($activeBusinessSection == 'legal-proceedings')
                @include('livewire.company-profile.business-overview.legal-proceedings-section')
            @endif
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
