<?php

namespace App\Http\Livewire\Euronext;

use App\Http\Livewire\BaseMetricsComponent;

class Metrics extends BaseMetricsComponent
{
    public function table(): string
    {
        return 'euronext_statements';
    }

    public function title(): string
    {
        return "Euronext Metrics - {$this->model->registrant_name}({$this->model->symbol})";
    }
}
