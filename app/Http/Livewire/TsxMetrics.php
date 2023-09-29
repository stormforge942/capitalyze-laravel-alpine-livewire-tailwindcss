<?php

namespace App\Http\Livewire;

class TsxMetrics extends BaseMetricsComponent
{
    public function table(): string
    {
        return 'tsx_statements';
    }

    public function title(): string
    {
        return "TSX Metrics - {$this->model->registrant_name}({$this->model->symbol})";
    }
}
