<div>
    <div class="py-12">
        <div class="mx-auto">
            <div class="px-4 sm:px-6 lg:px-8 bg-white py-4 shadow mx-4 rounded">
                <div wire:loading.flex class="justify-center items-center min-w-full">
                        <div class="grid place-content-center h-full" role="status">
                        <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="sm:flex sm:items-start flex-col" wire:loading.remove>
                    <div class="block">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Company Profile</h1>
                    </div>
                    @foreach ($profile as $data)
                    <div>Symbol: {{ $data->symbol }}</div>
                    <div>Registrant Name: {{ $data->registrant_name }}</div>
                    <div>CIK: {{ $data->cik }}</div>
                    <div>SIC Code: {{ $data->sic_code }}</div>
                    <div>SIC Description: {{ $data->sic_description }}</div>
                    <div>SIC Group: {{ $data->sic_group }}</div>
                    <div>LEI: {{ $data->lei }}</div>
                    <div>ISIN: {{ $data->isin }}</div>
                    <div>Business Address: {{ $data->business_address }}</div>
                    <div>Mailing Address: {{ $data->mailing_address }}</div>
                    <div>Phone Number: {{ $data->phone_number }}</div>
                    <div>Postal Code: {{ $data->postal_code }}</div>
                    <div>City: {{ $data->city }}</div>
                    <div>State: {{ $data->state }}</div>
                    <div>Country: {{ $data->country }}</div>
                    <div>Description: {{ $data->description }}</div>
                    <div>CEO: {{ $data->ceo }}</div>
                    <div>Website: {{ $data->website }}</div>
                    <div>Exchange: {{ $data->exchange }}</div>
                    <div>IPO Date: {{ $data->ipo_date }}</div>
                    <div>Employees: {{ $data->employees }}</div>
                    <div>Sec Fillings URL: {{ $data->sec_filings_url }}</div>
                    <div>One Year Beta: {{ $data->one_year_beta }}</div>
                    <div>Three Year Beta: {{ $data->three_year_beta }}</div>
                    <div>Five Year Beta: {{ $data->five_year_beta }}</div>
                    <div>Seven Year Beta: {{ $data->seven_year_beta }}</div>
                    <div>Ten Year Beta: {{ $data->ten_year_beta }}</div>
                    <div>52 Week Range: {{ $data->fiftytwo_week_range }}</div>
                    <div>Is Active: {{ $data->is_active }}</div>
                    <div>Asset Type: {{ $data->asset_type }}</div>
                    <div>Open FIGI Composite: {{ $data->open_figi_composite }}</div>
                    <div>Price Currency: {{ $data->price_currency }}</div>
                    <div>Market Sector: {{ $data->market_sector }}</div>
                    <div>Security Type: {{ $data->security_type }}</div>
                    <div>Is Fund: {{ $data->is_fund }}</div>
                    <div>Is Etf: {{ $data->is_etf }}</div>
                    <div>Is Adr: {{ $data->is_adr }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>