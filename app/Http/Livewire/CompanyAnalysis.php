<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDO;

class CompanyAnalysis extends Component
{
    use TableFiltersTrait;

    public $company;
    public $decimalDisplay = '0';
    public $ticker;
    public $companyName;
    public $unitType = 'Thousands';
    public $currency = 'USD';
    public $period;
    public $rangeDates = [];
    public $noData = false;
    public $cost;
    public $products = [];
    public $segments = [];
    public $ebitda = [];
    public $adjNetIncome = [];
    public $dilutedEPS = [];
    public $revenues = [];
    public $dilutedSharesOut = [];
    public $dynamic;
    public $reverse;
    public $years;
    public $minDate;
    public $maxDate;
    public $chartData;
    public $name;

    protected $listeners = ['tabClicked', 'tabSubClicked', 'dateChanged'];

    public function dateChanged($value)
    {
        $this->minDate = $value[0];
        $this->maxDate = $value[1];
        foreach ($this->years as $key => $year) {
            if (date('Y', strtotime($year)) < $this->minDate) {
                unset($this->years[$key]);
            }
            if (date('Y', strtotime($year)) > $this->maxDate) {
                unset($this->years[$key]);
            }
        }
        $this->years = array_values($this->years);
        $this->emit("initChart", $this->years);
    }

    function getSelectedRangeProperty()
    {
        return $this->years;
    }

    public function mount(Request $request, $company, $ticker, $period)
    {
        $first = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', strtolower($this->ticker))
            ->latest('date')->first()?->adj_close;
        $previous = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', strtolower($this->ticker))
            ->latest('date')
            ->skip(1)->first()?->adj_close;
        if ($previous && $first) {
            $this->dynamic = round((($first - $previous) / $previous) * 100, 2);
        }

        $this->cost =  $first;
        $this->company = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->companyName = $this->ticker;
        $this->getProducts();
        $this->getTickerPresentation();
        $this->rangeDates = array_keys($this->products);
        $this->years = array_keys($this->products);

        $this->minDate = array_reverse($this->years)[0];
        $this->maxDate = $this->years[0];
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


    public function getTickerPresentation()
    {
        $data = json_decode(DB::connection('pgsql-xbrl')
            ->table('info_tikr_presentations')
            ->where('ticker', $this->ticker)->orderByDesc('id')->first()->info, true)['annual'];
        $this->ebitda = $data['Income Statement']['EBITDA'];
        $this->adjNetIncome = $data['Income Statement']['Net Income'];
        $this->dilutedEPS = $data['Income Statement']['Diluted EPS Excl Extra Items'];
        $this->revenues = $data['Income Statement']['Revenues'];
        $this->dilutedSharesOut = $data['Income Statement']['Weighted Average Diluted Shares Outstanding'];
        // dd($this->ebitda, $this->adjNetIncome, $this->dilutedEPS);
    }

    public function render()
    {
        return view('livewire.company-analysis');
    }
}
