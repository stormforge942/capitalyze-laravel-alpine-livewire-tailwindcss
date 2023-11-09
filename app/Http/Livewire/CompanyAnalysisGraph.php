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
        foreach ($this->segments as $key => $product) {
            $set = [
                "label" => $product,
                "borderRadius" => 2,
                "fill" => true,
            ];

            if(isset($colors[$key]))
            {
                $set['backgroundColor'] = $colors[$key];
            }
            foreach ($this->products as $date => $data) {
                if(in_array($date, $this->years)){
                    $set["data"][] = [
                        "x" => $date,
                        "y" => $data[$product]
                    ];
                }
            }
            $dataSets[] = $set;
        }
        $this->dispatchBrowserEvent("dateschanged", json_encode($dataSets));
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
