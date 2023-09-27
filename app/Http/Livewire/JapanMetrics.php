<?php

namespace App\Http\Livewire;

class JapanMetrics extends BaseMetricsComponent
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
