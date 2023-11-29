<?php

namespace App\Http\Livewire;

use App\Models\EodPrices;
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
    protected $listeners = ['tabClicked', 'tabSubClicked', 'rbeAnalysisDatesChanged', 'rbeDecimalChange', 'rbePeriodChanged', 'rbeUnitChanged'];

    public function rbeDecimalChange($decimal){
        $this->decimalPoint = $decimal;
    }

    public function rbeUnitChanged($unit){
        $this->unit = $unit;
    }

    public function getSelectedUnitProperty(){
        return $this->unit;
    }

    public function rbeAnalysisDatesChanged($value)
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

    public function rbePeriodChanged($period){
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
        $eodPrices = EodPrices::where('symbol', strtolower($this->company->ticker))
            ->latest('date')
            ->take(2)
            ->pluck('adj_close')
            ->toArray();

        $latestPrice = $eodPrices[0] ?? 0;
        $previousPrice = $eodPrices[1] ?? 0;

        if ($latestPrice > 0 && $previousPrice > 0) {
            $this->dynamic = round((($latestPrice - $previousPrice) / $previousPrice) * 100, 2);
        }

        $this->cost =  $latestPrice;
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
        $data = InfoTikrPresentation::where('ticker', $this->ticker)
            ->orderByDesc('id')->first()->info[$period];
        $this->revenues = $data['Income Statement']['Revenues'];
    }
    public function render()
    {
        return view('livewire.revenue-by-employee');
    }
}
