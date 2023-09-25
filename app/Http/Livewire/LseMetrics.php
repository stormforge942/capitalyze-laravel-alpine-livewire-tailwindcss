<?php

namespace App\Http\Livewire;

class LseMetrics extends BaseMetricsComponent
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
