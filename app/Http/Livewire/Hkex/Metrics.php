<?php

namespace App\Http\Livewire\Hkex;

use App\Http\Livewire\BaseMetricsComponent;

class Metrics extends BaseMetricsComponent
{
    public function table(): string
    {
        return 'hkex_statements';
    }

    public function title(): string
    {
        return "HKEX Metrics - {$this->model->short_name}({$this->model->symbol})";
    }
}
