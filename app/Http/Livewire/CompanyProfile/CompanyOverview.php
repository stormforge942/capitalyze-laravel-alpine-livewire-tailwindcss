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
        $this->profile = $data['profile'];
        $this->period = $data['period'];

        $this->getProducts();
        $this->getPresentationData();
    }

    public function render()
    {
        return view('livewire.company-profile.company-overview');
    }

    private function getProducts()
    {
        $source = ($this->period == 'annual') ? 'arps' : 'qrps';
        $json = DB::connection('pgsql-xbrl')
            ->table('as_reported_sec_segmentation_api')
            ->where('ticker', '=', $this->profile['symbol'])
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

    public function getPresentationData()
    {
        $tickerSymbol = $this->profile['symbol'];

        $infoAnnualData = InfoTikrPresentation::where('ticker', $tickerSymbol)
            ->orderByDesc('id')
            ->first(['info']) // Select only the 'info' column.
            ->info['annual'];


        $this->ebitda = $infoAnnualData['Income Statement']['EBITDA'];
        $this->adjNetIncome = $infoAnnualData['Income Statement']['Net Income'];
        $this->dilutedEPS = $infoAnnualData['Income Statement']['Diluted EPS Excl Extra Items'];
        $this->revenues = $infoAnnualData['Income Statement']['Revenues'];
        $this->dilutedSharesOut = $infoAnnualData['Income Statement']['Weighted Average Diluted Shares Outstanding'];
    }
}
