<?php

namespace App\Http\Livewire;

use App\Models\InfoTikrPresentation;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RevenueByEmployee extends Component
{
    use TableFiltersTrait;

    public $company;
    public $ticker;
    public $companyName;
    public $unit= 0;
    public $currency = 'USD';
    public $period = "annual";
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
    public $chartId = 'rbe';
    public $employeeCount;
    protected $listeners = ['tabClicked', 'tabSubClicked', 'rbeanalysisDatesChanged', 'rbedecimalChange', 'rbeperiodChanged', 'rbeunitChanged'];

    public function rbedecimalChange($decimal){
        $this->decimalPoint = $decimal;
    }

    public function rbeunitChanged($unit){
        $this->unit = $unit;
    }

    public function getSelectedUnitProperty(){
        return $this->unit;
    }

    public function rbeanalysisDatesChanged($value)
    {
        $this->years = array_reverse(array_keys($this->revenues));
        if($this->reverseOrder){
            $this->years = array_reverse(array_keys($this->revenues));
        }
        $this->minDate = $value[0];
        $this->maxDate = $value[1];
        $range = [];
        foreach ($this->years as $key => $year) {
            if (!(date('Y', strtotime($year)) < $this->minDate || date('Y', strtotime($year)) > $this->maxDate)) {
                $range[] = $year;
            }
        }
        $this->years = $range;
    }

    function getSelectedRangeProperty()
    {
        if($this->reverseOrder){
            return array_reverse($this->years);
        }
        return $this->years;
    }

    public function rbeperiodChanged($period){
        $this->period = $period == 'arps' ? 'annual' : 'quarterly';
        $this->getPresentationData();
        $this->getEmployeeCount();
        $this->rangeDates = array_keys($this->revenues);

        $this->years = array_reverse(array_keys($this->revenues));
        if($this->reverseOrder){
            $this->years = array_keys($this->revenues);
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
        $this->getPresentationData();
        $this->getEmployeeCount();
        $this->rangeDates = array_keys($this->revenues);
        $this->years = array_reverse(array_keys($this->revenues));
        if($this->reverseOrder){
            $this->years = array_keys($this->revenues);
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

    public function getEmployeeCount(){
        $counts = DB::connection('pgsql-xbrl')
        ->table('employee_count')
        ->where('symbol', $this->ticker)->get()->toArray();
        $this->employeeCount = [];
        foreach($counts as $item){

            foreach(array_keys($this->revenues) as $year){
                if(date('Y', strtotime($year)) == date('Y', strtotime($item->period_of_report))){
                    $this->employeeCount[$year] = $item->count;
                }
            }
        }
    }

    public function getPresentationData()
    {
        $period = $this->period;
        if($this->period == 'quarterly'){
            $period = 'quarter';
        }
        $data = json_decode(InfoTikrPresentation::where('ticker', $this->ticker)
            ->orderByDesc('id')->first()->info, true)[$period];
        $this->revenues = $data['Income Statement']['Revenues'];
    }
    public function render()
    {
        return view('livewire.revenue-by-employee');
    }
}
