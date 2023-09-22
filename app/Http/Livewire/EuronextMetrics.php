<?php

namespace App\Http\Livewire;

class EuronextMetrics extends BaseMetricsComponent
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
