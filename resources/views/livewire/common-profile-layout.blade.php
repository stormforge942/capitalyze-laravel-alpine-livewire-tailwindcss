<div class="pb-12">
    <div class="mx-auto">
        <div class="px-4 sm:px-6 ml-3 lg:px-8 bg-white py-4 shadow my-5 rounded mx-auto">
            <div>
                <div>
                    <h4 class="text-[#3561E7] font-medium text-sm mb-5">Business Description</h4>
                    <p class="text-sm font-normal leading-6">{{$data->description ?? ''}}</p>
                </div>
            </div>
        </div>
        <div class="px-4 sm:px-6 ml-3 lg:px-8 bg-white py-4 shadow rounded mx-auto">
            <div class="flex flex-col md:flex-row justify-between content-between">
                <div>
                    Company Profile
                </div>
                <div>
                    <a href="#" wire:click.prevent="viewProfile">{{!$profile ? 'View full' : 'Hide full'}} {{$internationProfile? 'international': ''}} profile</a>
                </div>
            </div>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-clos-4 xl:grid-cols-5 2xl:grid-cols-6 gap-y-1 gap-x-2 mt-4 p-4">
                <div class="flex felx-col md:flex-row justify-start items-center">
                    <div class="mr-4">
                        <img src={{url("/svg/sic.svg")}} alt="sic"/>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-[#464E49]">Symbol</h4>
                        <span class="text-[#121A0F] font-medium text-sm">{{$data->symbol ?? '--'}}</span>
                    </div>
                </div>
                <div class="flex felx-col md:flex-row justify-start items-center">
                    <div class="mr-4">
                        <img src={{url("/svg/ceo.svg")}} alt="ceo"/>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-[#464E49]">Current CEO</h4>
                        <span class="text-[#121A0F] font-medium text-sm">{{$data->ceo ?? '--'}}</span>
                    </div>
                </div>
                <div class="flex felx-col md:flex-row justify-start items-center">
                    <div class="mr-4">
                        <img src={{url("/svg/address.svg")}} alt="address"/>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-[#464E49]">Adress</h4>
                        <span class="text-[#121A0F] font-medium text-sm">{{$data->address ?? '--'}}</span>
                    </div>
                </div>
                <div class="flex felx-col md:flex-row justify-start items-center">
                    <div class="mr-4">
                        <img src={{url("/svg/ipo_date.svg")}} alt="ipo_date"/>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-[#464E49]">Ipo Date</h4>
                        <span class="text-[#121A0F] font-medium text-sm">{{$data->ipo_date ?? '--'}}</span>
                    </div>
                </div>
                <div class="flex felx-col md:flex-row justify-start items-center">
                    <div class="mr-4">
                        <img src={{url("/svg/employee.svg")}} alt="employee"/>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-[#464E49]">No. of employees</h4>
                        <span class="text-[#121A0F] font-medium text-sm">{{$data->employees ?? '--'}}</span>
                    </div>
                </div>
                <div class="flex felx-col md:flex-row justify-start items-center">
                    <div class="mr-4">
                        <img style="height:70px; width:60px;" src={{url("/svg/web.svg")}} alt="web"/>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-[#464E49]">Official Website</h4>
                        <span class="text-[#52D3A2] font-medium text-sm">{{$data->website ?? '--'}}</span>
                    </div>
                </div>
                @if($profile)
                    <!-- <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">CIK</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->cik ?? '--'}}</span>
                        </div>
                    </div> -->
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Registrant Name</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->registrant_name ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">ISIN</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->isin ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Phone Number</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->phone_number ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">LEI</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->lei ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Industry</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->industry ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Open figi composite</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->open_figi_composite ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Exchange</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->exchange ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Sec Filings URL</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->sec_filings_url ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">One Year Beta</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->one_year_beta ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4"></div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Three Year Beta</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->three_year_beta ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Seven Year Beta</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->seven_year_beta ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Ten Year Beta</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->ten_year_beta ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">52 Week Range</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->fiftytwo_week_range ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Is Active</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->is_active ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Asset Type</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->asset_type ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Price Currency</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->price_currency ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Market Sector</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->market_sector ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Security Type</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->security_type ?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">IS FUND</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->is_fund?? '--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">ETF</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->etf??'--'}}</span>
                        </div>
                    </div>
                    <div class="flex felx-col md:flex-row justify-start items-center mt-4">
                        <div class="mr-4">
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-[#464E49]">Updated At</h4>
                            <span class="text-[#121A0F] font-medium text-sm">{{$data->updated_at??'--'}}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>