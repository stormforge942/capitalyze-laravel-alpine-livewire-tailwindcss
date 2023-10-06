<?php

namespace App\Http\Livewire\Japan;

use App\Http\Livewire\BaseMetricsComponent;

class Metrics extends BaseMetricsComponent
{
    public function table(): string
    {
        return 'japan_statements';
    }

    public function title(): string
    {
        return "Japan Metrics - {$this->model->registrant_name}({$this->model->symbol})";
    }
}
