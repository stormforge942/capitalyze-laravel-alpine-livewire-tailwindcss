<?php

namespace App\Http\Livewire\Lse;

use App\Http\Livewire\BaseMetricsComponent;

class Metrics extends BaseMetricsComponent
{
    public function table(): string
    {
        return 'lse_statements';
    }

    public function title(): string
    {
        return "LSE Metrics - {$this->model->registrant_name}({$this->model->symbol})";
    }
}
