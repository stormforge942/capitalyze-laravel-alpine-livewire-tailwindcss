<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;

class SelectChartMetrics extends Component
{
    public $options = [];
    public $selected = [];
    public $metricsMap = [];
    public $metricAttributes = [];

    public function render()
    {
        return view('livewire.builder.select-chart-metrics');
    }
}
