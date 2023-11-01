<?php

namespace App\Http\Livewire\Shenzhen;

use App\Http\Livewire\BaseMetricsComponent;

class Metrics extends BaseMetricsComponent
{
    public $hasPeriod = false;

    public function table(): string
    {
        return 'shenzhen_statements';
    }

    public function title(): string
    {
        return "Frankfurt Metrics - {$this->model->company_name}({$this->model->symbol})";
    }
}
