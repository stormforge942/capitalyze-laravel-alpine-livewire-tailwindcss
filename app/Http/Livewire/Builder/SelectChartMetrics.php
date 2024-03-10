<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;

class SelectChartMetrics extends Component
{
    protected $options = [];

    public function mount($options)
    {
        $this->options = $options;
    }

    public function render()
    {
        return view('livewire.builder.select-chart-metrics', [
            'options' => $this->options
        ]);
    }
}
