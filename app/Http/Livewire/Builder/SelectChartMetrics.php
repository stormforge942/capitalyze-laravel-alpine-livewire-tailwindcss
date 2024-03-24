<?php

namespace App\Http\Livewire\Builder;

use App\Services\ChartBuilderService;
use Livewire\Component;

class SelectChartMetrics extends Component
{
    public $options = [];
    public $selected = [];
    public $metricsMap = [];

    public function mount()
    {
        $this->options = ChartBuilderService::options();
        $this->metricsMap = ChartBuilderService::options(true);
    }

    public function render()
    {
        return view('livewire.builder.select-chart-metrics');
    }
}
