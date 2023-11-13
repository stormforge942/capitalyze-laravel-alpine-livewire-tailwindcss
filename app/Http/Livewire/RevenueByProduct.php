<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RevenueByProduct extends Component
{
    use TableFiltersTrait;

    public $company;
    public $ticker;
    public $companyName;
    public $unit= 0;
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
    public $quarterRange = [];
    public $decimalPoint = 0;
    public $reverseOrder = false;

    protected $listeners = ['tabClicked', 'tabSubClicked', 'analysisDatesChanged', 'decimalChange', 'periodChanged'];

    public function decimalChange($decimal){
        $this->decimalPoint = $decimal;
    }

    public function unitChanged($unit){
        $this->unit = $unit;
    }

    public function getSelectedUnitProperty(){
        return $this->unit;
    }

    public function analysisDatesChanged($value)
    {
        $this->years = array_reverse(array_keys($this->products));
        if($this->reverseOrder){
            $this->years = array_keys($this->products);
        }
        $this->minDate = $value[0];
        $this->maxDate = $value[1];
        foreach (array_keys($this->products) as $key => $year) {
            if (date('Y', strtotime($year)) < $this->minDate) {
                unset($this->years[$key]);
            }
            if (date('Y', strtotime($year)) > $this->maxDate) {
                unset($this->years[$key]);
            }
        }
        $this->years = array_values($this->years);
    }

    function getSelectedRangeProperty()
    {
        if($this->reverseOrder){
            return array_reverse($this->years);
        }
        return $this->years;
    }

    public function periodChanged($period){
        $this->period = $period == 'arps' ? 'annual' : 'quarterly';
        $this->getProducts();
        $this->getTickerPresentation();
        $this->rangeDates = array_keys($this->products);

        $this->years = array_reverse(array_keys($this->products));
        if($this->reverseOrder){
            $this->years = array_keys($this->products);
        }
        if($this->period != "annual"){
            $this->rangeDates = [
                min($this->rangeDates),
                max($this->rangeDates)
            ];
        }
        $this->minDate = array_reverse($this->years)[0];
        $this->maxDate = $this->years[0];
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

        $this->years = array_reverse(array_keys($this->products));
        if($this->reverseOrder){
            $this->years = array_keys($this->products);
        }
        if($this->period != "annual"){
            $this->rangeDates = [
                min($this->rangeDates),
                max($this->rangeDates)
            ];
        }
        $this->minDate = array_reverse($this->years)[0];
        $this->maxDate = $this->years[0];
    }

    public function getProducts()
    {
        $source = ($this->period == 'annual' || $this->period == 'fiscal-annual') ? 'arps' : 'qrps';
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
        if($source == 'arps'){
            $this->products = array_slice($products, 0, 6);
            $this->segments = array_slice($segments, 0, 6);
        }
        else{
            $this->products = $products;
            $this->segments = $segments;
        }
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
        return view('livewire.revenue-by-product');
    }
}
