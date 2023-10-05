<?php

namespace App\Http\Livewire;

class FrankfurtMetrics extends BaseMetricsComponent
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
