<?php

namespace App\Http\Livewire\Builder\Chart;

use App\Services\ChartBuilderService;
use Livewire\Component;

class SelectMetrics extends Component
{
    public $options = [];
    public $selected = [];

    public function mount()
    {
        $this->options = ChartBuilderService::options();
    }

    public function render()
    {
        return view('livewire.builder.chart.select-metrics');
    }
}
