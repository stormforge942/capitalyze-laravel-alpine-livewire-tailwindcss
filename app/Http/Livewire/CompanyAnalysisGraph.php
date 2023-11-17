<?php

namespace App\Http\Livewire;

use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CompanyAnalysisGraph extends Component
{
    public $years;
    public $minDate;
    public $maxDate;
    public $persentage;
    public $ticker;
    public $chartData;
    public $name;
    public $segments;
    public $products;
    public $period;
    public $chartId;
    public $revenues;
    public $employeeCount;

    protected $listeners = ['initChart'];


    public function initChart($selectedYears = null, $source)
    {
        if($this->chartId == 'rbg'){
            $this->getProducts('args');
            $this->chartData['annual'] = $this->generateChartData($selectedYears);
        }elseif($this->chartId == 'rbp'){
            $this->getProducts('arps');
            $this->chartData['annual'] = $this->generateChartData($selectedYears);
        }
        if($this->chartId == 'rbg'){
            $this->getProducts('qrgs');
            $this->chartData['quarterly'] = $this->generateChartData($selectedYears);
        }elseif($this->chartId == 'rbp'){
            $this->getProducts('qrps');
            $this->chartData['quarterly'] = $this->generateChartData($selectedYears);
        }
        if($this->chartId == 'rbe'){
            $this->chartData = $this->generateChartData($selectedYears);
        }
        $this->dispatchBrowserEvent($this->chartId.'refreshChart', $this->chartData);
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
        return $this->employeeCount;
    }

    public function getPresentationData($period = "annual")
    {
        $data = json_decode(InfoTikrPresentation::where('ticker', $this->ticker)
            ->orderByDesc('id')->first()->info, true)[$period];
        $this->revenues = $data['Income Statement']['Revenues'];
        return $data['Income Statement']['Revenues'];
    }

    public function generateChartData($selectedYears = null){
        if($selectedYears){
            $this->years = $selectedYears;
        }
        $dataSets = [];
        $colors = [
            "#464E49",
            "#9A46CD",
            "#52D3A2",
            "#3561E7",
            "#E38E48",
        ];
        $fontColors = [
            "#fff",
            "#fff",
            "#000",
            "#fff",
            "#fff",
        ];

        if($this->chartId == 'rbe'){
            $annualRevenueData = $this->getPresentationData();
            $annualEmployeeData = $this->getEmployeeCount();
            $quarterlyData = $this->getPresentationData("quarter");
            $annualDataSet["revenue"] = [
                "label" => "Revenue",
                "borderRadius" => 2,
                "fill" => true,
            ];
            $annualDataSet["employee"] = [
                "label" => "Employees",
                "borderRadius" => 2,
                "fill" => true,
                "type" => 'line',
            ];
            $quarterDataSet["revenue"] = [
                "label" => "Revenue",
                "borderRadius" => 2,
                "fill" => true,
            ];
            $quarterDataSet["employee"] = [
                "label" => "Employees",
                "borderRadius" => 2,
                "fill" => true,
                "type" => 'line',
            ];
            foreach($annualRevenueData as $date => $item){
                $set = [];
                $set["x"] = $date;
                $set["y"] = (double)explode("|", $item[0])[0];
                $set['backgroundColor'] = $colors[2];
                $set['datalabels'] = ['color' => $fontColors[2]];
                $annualDataSet["revenue"]["data"][] = $set;
                $annualDataSet["employee"]["data"][] = [
                    "x" => $date,
                    "y" => $this->employeeCount[$date],
                    // (double)round((explode("|", $item[0])[0]/$this->employeeCount[$date]), 2)
                ];
            }
            foreach($quarterlyData as $date => $item){
                $set = [];
                $set["x"] = $date;
                $set["y"] = (double)explode("|", $item[0])[0];
                $set['backgroundColor'] = $colors[2];
                $set['datalabels'] = ['color' => $fontColors[2]];
                $quarterDataSet["revenue"]["data"][] = $set;

                foreach($this->employeeCount as $eDate => $eCount){
                    if(date('Y', strtotime($date)) == date('Y', strtotime($eDate))){
                        $date;
                        $eDate;
                        $quarterDataSet["employee"]["data"][] = [
                            "x" => $date,
                            "y" => $eCount,
                        ];
                        break;
                    }
                }
            }
            // $quarterDataSet["employee"]["data"] = array_values($quarterDataSet["employee"]["data"]);

            $annualDataSet["revenue"]["label"] = "Revenue";
            $annualDataSet["revenue"]["borderRadius"] = "2";
            $annualDataSet["revenue"]["yAxisID"] = "y";
            $annualDataSet["revenue"]["fill"] = true;
            $annualDataSet["revenue"]["backgroundColor"] = $colors[2];
            $annualDataSet["revenue"]["datalabels"] = ['color' => $fontColors[2]];

            $annualDataSet["employee"]["label"] = "Employees";
            $annualDataSet["employee"]["yAxisID"] = "y1";
            $annualDataSet["employee"]["borderRadius"] = "2";
            $annualDataSet["employee"]["fill"] = false;
            $annualDataSet["employee"]["borderColor"] = "#C22929";
            $annualDataSet["employee"]["datalabels"] = ['color' => $fontColors[1]];


            $quarterDataSet["revenue"]["label"] = "Revenue";
            $quarterDataSet["revenue"]["yAxisID"] = "y";
            $quarterDataSet["revenue"]["borderRadius"] = "2";
            $quarterDataSet["revenue"]["fill"] = true;
            $quarterDataSet["revenue"]["backgroundColor"] = $colors[2];
            $quarterDataSet["revenue"]["datalabels"] = ['color' => $fontColors[2]];

            $quarterDataSet["employee"]["label"] = "Employees";
            $quarterDataSet["employee"]["yAxisID"] = "y1";
            $quarterDataSet["employee"]["borderRadius"] = "2";
            $quarterDataSet["employee"]["fill"] = false;
            $quarterDataSet["employee"]["borderColor"] = "#C22929";
            $quarterDataSet["employee"]["datalabels"] = ['color' => $fontColors[1]];

            return [
                "annual" => array_values(array_reverse($annualDataSet)),
                "quarterly" => array_values(array_reverse($quarterDataSet))
            ];
        }

        foreach ($this->segments as $key => $product) {
            $set = [
                "label" => str_replace('[Member]', '', $product),
                "borderRadius" => 2,
                "fill" => true,
            ];

            if(isset($colors[$key]))
            {
                $set['backgroundColor'] = $colors[$key];
                $set['datalabels'] = ['color' => $fontColors[$key]];
            }
            $set['datalabels']['weight'] = 400;
            foreach ($this->products as $date => $data) {
                $sum = array_sum($this->products[$date]);
                $set["data"][] = [
                    "x" => $date,
                    "y" => $data[$product],
                    "percentage" => count($this->segments) > 1 ? (($data[$product]/$sum) * 100) : 100,
                    "revenue" => $data[$product],
                    "fontColor" => $fontColors[$key] ?? "#000"
                ];
            }
            $dataSets[] = $set;
        }
        return $dataSets;
    }

    public function getProducts($period = null)
    {
        if($this->chartId == 'rbg'){
            $source = ($this->period == 'annual' || $this->period == 'fiscal-annual') ? 'args' : 'qrgs';
        }
        elseif($this->chartId == 'rbp') {
            $source = ($this->period == 'annual' || $this->period == 'fiscal-annual') ? 'arps' : 'qrps';
        }
        elseif($this->chartId == 'rbe'){

        }

        if($period){
            $source = $period;
        }

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

        // $this->json = base64_encode($json);
        if($source == 'arps'){
            $this->products = array_slice($products, 0, 6);
            $this->segments = array_slice($segments, 0, 6);
        }
        else{
            $this->products = $products;
            $this->segments = $segments;
        }
    }

    public function mount(){
        $this->initChart(null, 'arps');
    }

    public function render()
    {
        return view('livewire.company-analysis-graph');
    }
}
