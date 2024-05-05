<?php

namespace App\Http\Livewire\Builder\Table;

use Livewire\Component;
use App\Services\ChartBuilderService;

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
        return view('livewire.builder.table.select-metrics');
    }
}
