<div class="w-full">
    @if($noData)
        <div class="py-12">
            <div class="mx-auto flex">
                <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-1/2 md:mx-auto">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">No data available</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else

    <div class="py-0 bg-gray-100" x-data="{currentTab: 'revenue-by-product'}">
        <div class="mx-auto">
            <div class="px-4 sm:pr-6 lg:pr-8 py-0 pl-0">
                <div class="mt-0 flow-root company-profile-loading overflow-x-hidden">
                    <div class="align-middle">
                        <div class="block min-w-full sm:rounded-lg">
                            <div class="py-0">
                                <div class="flex w-full justify-between items-center" >
                                    <div class="page-titles mt-2">
                                        <b class="company-name">{{ @$companyName }}  @if(@$ticker) ({{ @$ticker }}) @endif </b> <br>
                                        <span class="brr"></span>
                                        <b>${{ number_format($cost) }}</b>
                                        <small class="text-color-green">({{ $dynamic > 0 ? '+' : '-' }}{{ abs($dynamic) }}%)</small>
                                    </div>
                                    <div class="download-buttons-wrapper flex">
                                        <a class="download-button" href="#">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z" fill="#121A0F"/>
                                            </svg>
                                            Download PDF
                                        </a>
                                        <a class="download-button" href="#">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z" fill="#121A0F"/>
                                            </svg>
                                            Download Excel
                                        </a>
                                        <a class="download-button" href="#">
                                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z" fill="#121A0F"/>
                                            </svg>
                                            Download CSV
                                        </a>
                                    </div>
                                </div>


                                <div class="flex w-full overflow-x-hidden">
                                    <div class="tabs-container w-full" style="overflow-x: auto; white-space: nowrap;">
                                        <ul class="tabs-wrapper flex">
                                            <li data-tab-index="0" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:text-[#828C85] px-6 tab active" wire:click="$emit('tabSubClicked', 'revenue')">Revenue</li>
                                            <li data-tab-index="0" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:text-[#828C85] px-6 tab" wire:click="$emit('tabSubClicked', 'efficiency')">Efficiency</li>
                                            <li data-tab-index="0" class="whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg cursor-pointer border-transparent text-[#828C85] hover:text-[#828C85] px-6 tab" wire:click="$emit('tabSubClicked', 'capital-allocation')">Capital Allocation</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="flex w-full overflow-x-hidden">
                                    <ul class="revenue-tab">
                                        <li @click="currentTab = 'revenue-by-product'" :class="currentTab == 'revenue-by-product' ? 'active' : ''">Revenue by Product</li>
                                        <li @click="currentTab = 'revenue-by-geography'" :class="currentTab == 'revenue-by-geography' ? 'active' : ''">Revenue by Geography</li>
                                        <li @click="currentTab = 'revenue-by-employee'" :class="currentTab == 'revenue-by-employee' ? 'active' : ''">Revenue per Employee</li>
                                    </ul>
                                </div>
                                <div x-show="currentTab == 'revenue-by-product'">
                                    @livewire('revenue-by-product', [
                                        'company' => $company,
                                        'companyName' => $companyName,
                                        'ticker' => $ticker,
                                        'cost' => $cost,
                                        'period' => $period,
                                        'chartId' => 'revenue-by-product'
                                    ])
                                </div>
                                <div x-show="currentTab == 'revenue-by-geography'">
                                    @livewire('revenue-by-geography', [
                                        'company' => $company,
                                        'companyName' => $companyName,
                                        'ticker' => $ticker,
                                        'cost' => $cost,
                                        'period' => $period,
                                        'chartId' => 'revenue-by-geography'
                                    ])
                                </div>
                                {{-- <div x-show="currentTab == 'revenue-by-geography'">
                                    @livewire('revenue-by-geography', [
                                        'company' => $company,
                                        'companyName' => $companyName,
                                        'ticker' => $ticker,
                                        'cost' => $cost,
                                        'period' => $period
                                    ])
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@push('scripts')
<script>
    let decimalPoints = 0;
    let unitType = 0
    let reversOrder = false
    function setRound(v){
        decimalPoints = v
        Livewire.emit('decimalChanged', decimalPoints)
        @this.set('decimalPoint', decimalPoints)
    }
    function setReverseOrder(v){
        reversOrder = v
        Livewire.emit('orderChanged', v)
        @this.set('reverseOrder', v)
    }
    function setUnitType(v){
        unitType = v
        Livewire.emit('unitChanged', unitType)
        @this.set('unit', unitType)
    }
    let slideOpen = false;
    function generateRangeArray(inputArray) {
        if (inputArray.length !== 2) {
            return [];
        }

        let start = inputArray[0];
        let end = inputArray[1];
        let rangeArray = [];

        if (start <= end) {
            for (let i = start; i <= end; i++) {
                rangeArray.push(i);
            }
        } else {
            for (let i = start; i >= end; i--) {
                rangeArray.push(i);
            }
        }

        return rangeArray;
    }



    document.addEventListener('DOMContentLoaded', function() {
        // document.body.addEventListener('click', function(event) {
        //     var element = event.target;
        //     if (element.classList.contains('open-slide') && !slideOpen) {
        //         var value = element.dataset.value;
        //         value = JSON.parse(value);
        //         window.livewire.emit('slide-over.open', 'company-analysis-slide', value, {force: true});
        //         slideOpen = true;
        //     }
        // });
    })

    Livewire.on('slide-over.close', () => {
        slideOpen = false;
    });

    const annualCheckbox = document.getElementById("date-annual");
    const fiscalAnnualCheckbox = document.getElementById("date-fiscal-annual");

    annualCheckbox.addEventListener("click", function() {
        Livewire.emit('periodChanged', 'arps')
        // const currentUrl = window.location.href;

        // const separator = currentUrl.includes('?') ? '&' : '?';

        // const newUrl = currentUrl + separator + 'period=annual';

        // window.location.href = newUrl;
    });
    fiscalAnnualCheckbox.addEventListener("click", function() {
        Livewire.emit('periodChanged', 'arps')
        // const currentUrl = window.location.href;

        // const separator = currentUrl.includes('?') ? '&' : '?';

        // const newUrl = currentUrl + separator + 'period=fiscal-annual';

        // window.location.href = newUrl;
    });
    // date-fiscal-quarterly
    const quarterlyCheckbox = document.getElementById("date-quarterly");
    const fiscalQuarterlyCheckbox = document.getElementById("date-fiscal-quaterly");

    quarterlyCheckbox.addEventListener("click", function() {
        Livewire.emit('periodChanged', 'qrps')
        // const currentUrl = window.location.href;

        // const separator = currentUrl.includes('?') ? '&' : '?';

        // const newUrl = currentUrl + separator + 'period=quarterly';

        // window.location.href = newUrl;
    });
    fiscalQuarterlyCheckbox.addEventListener("click", function() {
        Livewire.emit('periodChanged', 'qrps')
        // const currentUrl = window.location.href;

        // const separator = currentUrl.includes('?') ? '&' : '?';

        // const newUrl = currentUrl + separator + 'period=fiscal-quarterly';

        // window.location.href = newUrl;
    });

    const unitTypeDropdownCloseIcon = document.getElementById("unitTypeClose");

    unitTypeDropdownCloseIcon.addEventListener("click", function() {
        document.getElementById('dropdown-UnitType').classList.toggle("hidden");
    });
</script>
@endpush


