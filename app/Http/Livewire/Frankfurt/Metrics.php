<?php

namespace App\Http\Livewire\Frankfurt;

use App\Http\Livewire\BaseMetricsComponent;

class Metrics extends BaseMetricsComponent
{
    public function table(): string
    {
        return 'frankfurt_statements';
    }

    public function title(): string
    {
        return "Frankfurt Metrics - {$this->model->company_name}({$this->model->symbol})";
    }
}
