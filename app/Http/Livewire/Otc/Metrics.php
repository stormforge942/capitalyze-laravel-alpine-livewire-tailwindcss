<?php

namespace App\Http\Livewire\Otc;

use App\Http\Livewire\BaseMetricsComponent;

class Metrics extends BaseMetricsComponent
{
    public function table(): string
    {
        return 'otc_statements';
    }

    public function title(): string
    {
        return "OTC Metrics - {$this->model->company_name}({$this->model->symbol})";
    }
}
