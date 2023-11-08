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

    protected $listeners = ['dateChanged', 'initChart'];

    public function dateChanged(){
        $this->initChart();
    }

    public function initChart()
    {
        $dataSets = [];
        foreach ($this->segments as $product) {
            $set = [
                "label" => $product,
                "borderRadius" => 2,
                "fill" => true,
                "barThickness" => 100
            ];
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
