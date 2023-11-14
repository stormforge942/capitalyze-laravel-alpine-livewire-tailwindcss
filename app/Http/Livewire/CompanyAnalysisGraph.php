<?php

namespace App\Http\Livewire;

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

    protected $listeners = ['initChart'];


    public function initChart($selectedYears = null, $source)
    {
        if($this->chartId == 'rbg'){
            $this->getProducts('args');
        }elseif($this->chartId == 'rbp'){
            $this->getProducts('arps');
        }

        $this->chartData['annual'] = $this->generateChartData($selectedYears);
        if($this->chartId == 'rbg'){
            $this->getProducts('qrgs');
        }elseif($this->chartId == 'rbp'){
            $this->getProducts('qrps');
        }
        $this->chartData['quarterly'] = $this->generateChartData($selectedYears);
        $this->dispatchBrowserEvent($this->chartId.'refreshChart', $this->chartData);
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
