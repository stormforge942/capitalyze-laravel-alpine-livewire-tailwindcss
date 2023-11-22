<?php

namespace App\Http\Livewire\CompanyProfile;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\DB;
use App\Models\InfoTikrPresentation;

class CompanyOverview extends Component
{
    use AsTab;

    public $profile;
    public $period;
    public $products;
    public $segments;
    public $ebitda;
    public $adjNetIncome;
    public $dilutedEPS;
    public $revenues;
    public $dilutedSharesOut;

    public function mount(array $data = [])
    {
        $this->profile = $this->formatProfile($data['profile']);
        $this->period = $data['period'];

        $this->getProducts($data['profile']['symbol']);
        $this->getPresentationData($data['profile']['symbol']);
    }

    public function render()
    {
        return view('livewire.company-profile.company-overview');
    }

    private function formatProfile($profile)
    {
        [$high, $low] = isset($profile['fiftytwo_week_range'])
            ? [getHighPriceFromDashRange($profile['fiftytwo_week_range']), getLowPriceFromDashRange($profile['fiftytwo_week_range'])]
            : [null, null];

        return [
            'profile' => [
                [
                    'key' => 'SIC',
                    'value' => data_get($profile, 'sic_description'),
                    'icon' => <<<'ICON'
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <g clip-path="url(#clip0_301_52187)">
                                    <path d="M1.75 5.25H1.25V9.25H1.75V5.25Z" fill="#5C6373" />
                                    <path d="M1.75 9.75H1.25V11H1.75V9.75Z" fill="#5C6373" />
                                    <path d="M8.25 3.5H7.75V4.75H8.25V3.5Z" fill="#5C6373" />
                                    <path d="M8.25 5.25H7.75V6.5H8.25V5.25Z" fill="#5C6373" />
                                    <path d="M5.75 14.5H2.5V15.5H5.75V14.5Z" fill="#5C6373" />
                                    <path d="M13.5 14.5H10.25V15.5H13.5V14.5Z" fill="#5C6373" />
                                    <path d="M15.5 2H2V3.5H15.5V2Z" fill="#121A0F" />
                                    <path d="M2 0.5L0.5 1.5V3.25C0.5 4.325 1.05 5.35 1.95 5.95L2 6V0.5Z" fill="#121A0F" />
                                    <path
                                        d="M8 5.5C8.27614 5.5 8.5 5.27614 8.5 5C8.5 4.72386 8.27614 4.5 8 4.5C7.72386 4.5 7.5 4.72386 7.5 5C7.5 5.27614 7.72386 5.5 8 5.5Z"
                                        fill="#A6A6A6" />
                                    <path d="M13.75 9.75V3.5H14.75V9.75" fill="#5C6373" />
                                    <path
                                        d="M1.5 10C1.77614 10 2 9.77614 2 9.5C2 9.22386 1.77614 9 1.5 9C1.22386 9 1 9.22386 1 9.5C1 9.77614 1.22386 10 1.5 10Z"
                                        fill="#A6A6A6" />
                                    <path
                                        d="M14.25 12C14.9404 12 15.5 11.4404 15.5 10.75C15.5 10.0596 14.9404 9.5 14.25 9.5C13.5596 9.5 13 10.0596 13 10.75C13 11.4404 13.5596 12 14.25 12Z"
                                        fill="#A6A6A6" />
                                    <path d="M10.5 15.5L9.25 6.5H6.75L5.5 15.5H10.5Z" fill="#121A0F" />
                                    <path d="M9.74687 10.1L9.62187 9.275L6.84687 6.5H6.74687L6.67188 7.025L9.74687 10.1Z"
                                        fill="#121A0F" />
                                    <path d="M9.25 6.5H9.15L6.375 9.275L6.25 10.1L9.325 7.025L9.25 6.5Z" fill="#121A0F" />
                                    <path d="M6.04688 11.6L10.3719 15.5H10.4969L10.3969 14.85L6.12187 11L6.04688 11.6Z"
                                        fill="#121A0F" />
                                    <path d="M9.875 11L5.6 14.85L5.5 15.5H5.625L9.95 11.6L9.875 11Z" fill="#121A0F" />
                                    <path d="M6.14844 10.75H9.84844L9.77344 10.25H6.22344L6.14844 10.75Z" fill="#121A0F" />
                                    <path d="M3.75 14.5H3.25V15.5H3.75V14.5Z" fill="#A6A6A6" />
                                    <path d="M12.75 14.5H12.25V15.5H12.75V14.5Z" fill="#A6A6A6" />
                                    <path d="M11.75 14.5H11.25V15.5H11.75V14.5Z" fill="#A6A6A6" />
                                    <path
                                        d="M12.175 3.5H12.75V3.475V2.6L13.675 3.5H14.25V3.475V2.6L15.175 3.5H15.5V3.125L14.35 2H13.75V2.875L12.85 2H12.25V2.875L11.35 2H10.75V2.9L9.85 2H9.25V2.875L8.35 2H7.75V2.875L6.85 2H6.25V2.875L5.35 2H4.75V2.875L3.85 2H3.25V2.9L2.35 2H2V2.35L3.15 3.5H3.75V2.6L4.675 3.5H5.25V3.475V2.6L6.175 3.5H6.75V3.475V2.6L7.675 3.5H8.25V3.475V2.6L9.175 3.5H9.75V3.475V2.6L10.65 3.5H11.25V2.6L12.175 3.5Z"
                                        fill="#121A0F" />
                                    <path d="M2 1.75H0.5V2.25H2V1.75Z" fill="#121A0F" />
                                    <path d="M2 2.75H0.5V3.25H2V2.75Z" fill="#121A0F" />
                                    <path d="M0.646875 4.25H1.99688V3.75H0.546875C0.571875 3.925 0.596875 4.075 0.646875 4.25Z"
                                        fill="#121A0F" />
                                    <path d="M4.75 14.5H4.25V15.5H4.75V14.5Z" fill="#A6A6A6" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_301_52187">
                                        <rect width="16" height="16" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        ICON
                ],
                [
                    'key' => 'Current C.E.O',
                    'value' => data_get($profile, 'ceo'),
                    'icon' => <<<'ICON'
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M2.66406 14.668C2.66406 11.7224 5.05188 9.33464 7.9974 9.33464C10.9429 9.33464 13.3307 11.7224 13.3307 14.668H2.66406ZM7.9974 8.66797C5.7874 8.66797 3.9974 6.87797 3.9974 4.66797C3.9974 2.45797 5.7874 0.667969 7.9974 0.667969C10.2074 0.667969 11.9974 2.45797 11.9974 4.66797C11.9974 6.87797 10.2074 8.66797 7.9974 8.66797Z" fill="#121A0F" />
                            </svg>
                        ICON
                ],
                [
                    'key' => 'Location - HQ',
                    'value' => data_get($profile, 'city') . (isset($profile['country'], $profile['city']) ? ' , ' : '') . data_get($profile, 'country'),
                    'icon' => <<<'ICON'
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M7.33342 11.9589C4.70254 11.6308 2.66675 9.38656 2.66675 6.66683C2.66675 3.72131 5.05456 1.3335 8.00008 1.3335C10.9456 1.3335 13.3334 3.72131 13.3334 6.66683C13.3334 9.38656 11.2976 11.6308 8.66675 11.9589V13.3412C11.2976 13.4028 13.3334 13.8236 13.3334 14.3335C13.3334 14.8858 10.9456 15.3335 8.00008 15.3335C5.05456 15.3335 2.66675 14.8858 2.66675 14.3335C2.66675 13.8236 4.70254 13.4028 7.33342 13.3412V11.9589ZM8.00008 8.00016C8.73648 8.00016 9.33342 7.40323 9.33342 6.66683C9.33342 5.93045 8.73648 5.3335 8.00008 5.3335C7.26368 5.3335 6.66675 5.93045 6.66675 6.66683C6.66675 7.40323 7.26368 8.00016 8.00008 8.00016Z"
                                    fill="#121A0F" />
                            </svg>
                        ICON
                ],
                [
                    'key' => 'IPO date',
                    'value' => data_get($profile, 'ipo_data'),
                    'icon' => <<<'ICON'
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M3.33333 2V12.6667H14V14H2V2H3.33333ZM13.2929 3.95956L14.7071 5.37377L10.6667 9.4142L8.66667 7.414L6.04044 10.0405L4.62623 8.6262L8.66667 4.58579L10.6667 6.586L13.2929 3.95956Z"
                                    fill="#121A0F" />
                            </svg>
                        ICON
                ],
                [
                    'key' => 'Number of Employees',
                    'value' => data_get($profile, 'employees'),
                    'icon' => <<<'ICON'
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M7.99992 6.66683C9.47265 6.66683 10.6666 5.47292 10.6666 4.00016C10.6666 2.5274 9.47265 1.3335 7.99992 1.3335C6.52716 1.3335 5.33325 2.5274 5.33325 4.00016C5.33325 5.47292 6.52716 6.66683 7.99992 6.66683ZM3.66659 8.66683C4.58706 8.66683 5.33325 7.92063 5.33325 7.00016C5.33325 6.07969 4.58706 5.3335 3.66659 5.3335C2.74611 5.3335 1.99992 6.07969 1.99992 7.00016C1.99992 7.92063 2.74611 8.66683 3.66659 8.66683ZM13.9999 7.00016C13.9999 7.92063 13.2537 8.66683 12.3333 8.66683C11.4128 8.66683 10.6666 7.92063 10.6666 7.00016C10.6666 6.07969 11.4128 5.3335 12.3333 5.3335C13.2537 5.3335 13.9999 6.07969 13.9999 7.00016ZM7.99992 7.3335C9.84085 7.3335 11.3333 8.8259 11.3333 10.6668V14.6668H4.66658V10.6668C4.66658 8.8259 6.15897 7.3335 7.99992 7.3335ZM3.33325 10.6668C3.33325 10.2048 3.40037 9.75856 3.52537 9.33723L3.41235 9.3471C2.24327 9.47376 1.33325 10.464 1.33325 11.6668V14.6668H3.33325V10.6668ZM14.6666 14.6668V11.6668C14.6666 10.4254 13.6972 9.41036 12.4745 9.33723C12.5995 9.75856 12.6666 10.2048 12.6666 10.6668V14.6668H14.6666Z"
                                    fill="#121A0F" />
                            </svg>
                        ICON
                ],
                [
                    'key' => 'Official Website',
                    'value' => data_get($profile, 'website'),
                    'type' => 'link',
                    'icon' => <<<'ICON'
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M1.36621 8.66657H5.01816C5.13749 10.8458 5.83826 12.8701 6.968 14.5872C3.99174 14.1246 1.66673 11.6934 1.36621 8.66657ZM1.36621 7.33324C1.66673 4.30637 3.99174 1.87509 6.968 1.4126C5.83826 3.12962 5.13749 5.15399 5.01816 7.33324H1.36621ZM14.6337 7.33324H10.9817C10.8624 5.15399 10.1617 3.12962 9.03193 1.4126C12.0082 1.87509 14.3332 4.30637 14.6337 7.33324ZM14.6337 8.66657C14.3332 11.6934 12.0082 14.1246 9.03193 14.5872C10.1617 12.8701 10.8624 10.8458 10.9817 8.66657H14.6337ZM6.35378 8.66657H9.64613C9.53173 10.5218 8.94306 12.2487 7.99993 13.7276C7.0568 12.2487 6.46819 10.5218 6.35378 8.66657ZM6.35378 7.33324C6.46819 5.47798 7.0568 3.75106 7.99993 2.27219C8.94306 3.75106 9.53173 5.47798 9.64613 7.33324H6.35378Z"
                                    fill="#121A0F" />
                            </svg>
                        ICON
                ],
                [
                    'key' => 'CIK',
                    'value' => data_get($profile, 'cik'),
                ],
                [
                    'key' => 'SIC Code',
                    'value' => data_get($profile, 'sic_code'),
                ],
                [
                    'key' => 'SIC Group',
                    'value' => data_get($profile, 'sic_group'),
                ],
                [
                    'key' => 'ISIN',
                    'value' => data_get($profile, 'isin'),
                ],
                [
                    'key' => 'Phone Number',
                    'value' => data_get($profile, 'phone_number'),
                ],
                [
                    'key' => 'LEI',
                    'value' => data_get($profile, 'lei'),
                ],
                [
                    'key' => 'Postal Code',
                    'value' => data_get($profile, 'postal_code'),
                ],
                [
                    'key' => 'Exchange',
                    'value' => data_get($profile, 'exchange'),
                ],
                [
                    'key' => 'Sec Filings URL',
                    'value' => data_get($profile, 'sec_filings_url'),
                    'type' => 'link',
                ],
                [
                    'key' => 'One Year Beta',
                    'value' => data_get($profile, 'one_year_beta'),
                ],
                [
                    'key' => 'Three Year Beta',
                    'value' => data_get($profile, 'three_year_beta'),
                ],
                [
                    'key' => 'Five Year Beta',
                    'value' => data_get($profile, 'five_year_beta'),
                ],
                [
                    'key' => 'Seven Year Beta',
                    'value' => data_get($profile, 'seven_year_beta'),
                ],
                [
                    'key' => 'Ten Year Beta',
                    'value' => data_get($profile, 'ten_year_beta'),
                ],
                [
                    'key' => '52 Week Range',
                    'value' => data_get($profile, 'fiftytwo_week_range'),
                ],
                [
                    'key' => 'Is Active',
                    'value' => data_get($profile, 'five_year_beta'),
                ],
                [
                    'key' => 'Asset Type',
                    'value' => data_get($profile, 'asset_type'),
                ],
                [
                    'key' => 'Open FIGI Composite',
                    'value' => data_get($profile, 'open_figi_composite'),
                ],
                [
                    'key' => 'Price Currency',
                    'value' => data_get($profile, 'price_currency'),
                ],
                [
                    'key' => 'Market Sector',
                    'value' => data_get($profile, 'market_sector'),
                ],
                [
                    'key' => 'Security Type',
                    'value' => data_get($profile, 'security_type'),
                ],
                [
                    'key' => 'Is Fund',
                    'value' => data_get($profile, 'is_fund'),
                ],
                [
                    'key' => 'ETF',
                    'value' => data_get($profile, 'is_etf'),
                ],
                [
                    'key' => 'ADR',
                    'value' => data_get($profile, 'is_adr'),
                ],
            ],
            'fiftytwo_week_range_high' => $high,
            'fiftytwo_week_range_low' => $low,
            'symbol' => data_get($profile, 'symbol'),
            'description' => data_get($profile, 'description'),
            'registrant_name' => data_get($profile, 'registrant_name'),
        ];
    }

    private function getProducts($symbol)
    {
        $source = ($this->period == 'annual') ? 'arps' : 'qrps';
        $json = DB::connection('pgsql-xbrl')
            ->table('as_reported_sec_segmentation_api')
            ->where('ticker', '=', $symbol)
            ->where('endpoint', '=', $source)
            ->value('api_return_open_ai');

        $data = json_decode($json, true);
        $dates = [];
        $this->products = [];
        $this->segments = [];

        if ($json === null) {
            return;
        }

        foreach ($data as $date) {
            $key = array_key_first($date);
            $dates[] = $key;
            $this->products[$key] = $date[$key];
            $keys = array_keys($this->products[$key]);
            foreach ($keys as $subkey) {
                if (!in_array($subkey, $this->segments, true)) {
                    $this->segments[] = $subkey;
                }
            }
        }

        $this->products = array_reverse(array_slice($this->products, 0, 6));
        $this->segments = array_slice($this->segments, 0, 6);
    }

    private function getPresentationData($symbol)
    {
        $data = json_decode(InfoTikrPresentation::where('ticker', $symbol)
            ->orderByDesc('id')->first()->info, true)['annual'];
        $this->ebitda = $data['Income Statement']['EBITDA'];
        $this->adjNetIncome = $data['Income Statement']['Net Income'];
        $this->dilutedEPS = $data['Income Statement']['Diluted EPS Excl Extra Items'];
        $this->revenues = $data['Income Statement']['Revenues'];
        $this->dilutedSharesOut = $data['Income Statement']['Weighted Average Diluted Shares Outstanding'];
    }
}
