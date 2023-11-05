<?php

namespace App\Http\Livewire;

use App\Models\CompanyPresentation;
use App\Models\InfoTikrPresentation;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyProfile extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $profile;
    public $menuLinks;
    public $ebitda;
    public $adjNetIncome;
    public $dilutedEPS;
    public $revenues;
    public $products;
    public $dilutedSharesOut;

    public $segments;

    public $infoTabActive = 'overview';
    public $cost = null;
    public $dynamic = null;
    public $activeBusinessSection = 'business';

    public function setInfoActiveTab(string $tab): void
    {
        $this->infoTabActive = $tab;
        $this->emit('updateChart');
    }

    public $showFullProfile = false;
    public function toggleFullProfile(): void
    {
        $this->showFullProfile = !$this->showFullProfile;
    }

    public function mount($company, $ticker, $period)
    {
        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;

        $first = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', strtolower($this->ticker))
            ->latest('date')
            ->first()
            ?->adj_close;

        $this->cost =  $first;

        $previous = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', strtolower($this->ticker))
            ->latest('date')
            ->skip(1)
            ->first()
            ?->adj_close;

        if ($previous && $first) {
            $this->dynamic = round((($first - $previous) / $previous) * 100, 2);
        }

        $this->getCompanyProfile();
        $this->getMenu();
        $this->getProducts();
        $this->getTickerPresentation();
    }

    public function getMenu()
    {
        $this->menuLinks = CompanyPresentation::where('business', '!=', null)->where('symbol', $this->ticker)->orderByDesc('acceptance_time')->first()?->toArray();
    }

    public function getTickerPresentation()
    {
        $data = json_decode(InfoTikrPresentation::where('ticker', $this->ticker)->orderByDesc('id')->first()->info, true)['annual'];
        $this->ebitda = $data['Income Statement']['EBITDA'];
        $this->adjNetIncome = $data['Income Statement']['Net Income'];
        $this->dilutedEPS = $data['Income Statement']['Diluted EPS Excl Extra Items'];
        $this->revenues = $data['Income Statement']['Revenues'];
        $this->dilutedSharesOut = $data['Income Statement']['Weighted Average Diluted Shares Outstanding'];
        // dd($this->ebitda, $this->adjNetIncome, $this->dilutedEPS);
    }

    public function getCompanyProfile()
    {
        $this->profile = \App\Models\CompanyProfile::query()
            ->where('symbol', $this->ticker)
            ->first()
            ?->toArray();
    }

    public function getProducts()
    {
        $source = ($this->period == 'annual') ? 'arps' : 'qrps';
        $json = DB::connection('pgsql-xbrl')
            ->table('as_reported_sec_segmentation_api')
            ->where('ticker', '=', $this->ticker)
            ->where('endpoint', '=', $source)
            ->value('api_return_open_ai');

        $data = json_decode($json, true);
        $products = [];
        $dates = [];
        $segments = [];

        if ($json === null) {
            $this->noData = true;

            return;
        }

        foreach ($data as $date) {
            $key = array_key_first($date);
            $dates[] = $key;
            $products[$key] = $date[$key];
            $keys = array_keys($products[$key]);
            foreach ($keys as $subkey) {
                if (!in_array($subkey, $segments, true)) {
                    $segments[] = $subkey;
                }
            }
        }

        $this->json = base64_encode($json);
        $this->products = array_slice($products, 0, 6);
        $this->segments = array_slice($segments, 0, 6);
    }

    public function render()
    {
        return view('livewire.company-profile.component');
    }
}
