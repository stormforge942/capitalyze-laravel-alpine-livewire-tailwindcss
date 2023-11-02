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
