<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

    protected $listeners = ['tabClicked', 'tabSubClicked', 'dateChanged'];

    public function dateChanged($value)
    {
        $this->years = $this->rangeDates;
        $min = $value[0];
        $max = $value[1];

        foreach($this->years as $key => $year){
            if(date('Y', strtotime($year)) < $min){
                unset($this->years[$key]);
            }
            if(date('Y', strtotime($year)) > $max){
                unset($this->years[$key]);
            }
        }
        $this->years = array_values($this->years);
    }

    function getSelectedRangeProperty(){
        return $this->years;
    }

    // public function generatePresent($value)
    // {
    //     $unitType = $this->unitType;
    //     $units = [
    //         'Thousands' => 'T',
    //         'Millions' => 'M',
    //         'Billions' => 'B',
    //     ];

    //     $decimalDisplay = intval($this->decimalDisplay);

    //     if (str_contains($value, '%') || str_contains($value, '-') || !is_numeric($value)) {
    //         return $value;
    //     }

    //     if (str_contains($value, '.') || str_contains($value, ',')) {
    //         $float = floatval(str_replace(',', '', $value));

    //         $value = intval($float);
    //     }

    //     if (!isset($units[$unitType])) {
    //         return number_format($value, $decimalDisplay);
    //     }

    //     $unitAbbreviation = $units[$unitType];

    //     // Determine the appropriate unit based on the number
    //     if ($unitAbbreviation == 'B') {
    //         return number_format($value / 1000000000);
    //     } elseif ($unitAbbreviation == 'M') {
    //         return number_format($value / 1000000);
    //     } elseif ($unitAbbreviation == 'T') {
    //         return number_format($value / 1000);
    //     } else {
    //         return number_format($value);
    //     }
    // }

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
