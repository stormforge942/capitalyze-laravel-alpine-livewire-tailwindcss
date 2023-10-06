<?php

namespace App\Http\Livewire\Tsx;

use App\Http\Livewire\BaseMetricsComponent;

class Metrics extends BaseMetricsComponent
{
    public function table(): string
    {
        return 'tsx_statements';
    }

    public function title(): string
    {
        return "TSX Metrics - {$this->model->registrant_name}({$this->model->symbol})";
    }
}
