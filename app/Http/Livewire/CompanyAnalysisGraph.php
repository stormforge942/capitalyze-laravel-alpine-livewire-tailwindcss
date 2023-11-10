<?php

namespace App\Http\Livewire;

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

    protected $listeners = ['initChart'];


    public function initChart($selectedYears = null)
    {
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
                "label" => $product,
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
                    "percentage" => ($data[$product]/$sum) * 100,
                    "revenue" => $data[$product],
                    "fontColor" => $fontColors[$key] ?? "#000"
                ];
            }
            $dataSets[] = $set;
        }
        // $this->dispatchBrowserEvent("dateschanged", json_encode($dataSets));
        $this->chartData = $dataSets;
    }

    public function mount(){
        $this->initChart();
    }

    public function render()
    {
        return view('livewire.company-analysis-graph');
    }
}
