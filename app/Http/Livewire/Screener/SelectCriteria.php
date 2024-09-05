<?php

namespace App\Http\Livewire\Screener;

use App\Services\ChartBuilderService;
use Livewire\Component;

class SelectCriteria extends Component
{
    public $options = [];
    public $selected = [];
    public $id;
    public $dates;

    public function mount()
    {
        $this->options = ChartBuilderService::options();
    }

    public function render()
    {
        return view('livewire.screener.select-criteria');
    }
}
