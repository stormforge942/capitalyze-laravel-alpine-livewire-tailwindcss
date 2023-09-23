<?php

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ShanghaiMetrics extends BaseMetricsComponent
{    
    public function table(): string
    {
        return 'shanghai_statements';
    }

    protected function data(): Collection
    {
        return DB::connection('pgsql-xbrl')
            ->table('public.' . $this->table())
            ->select('json_result')
            ->where('symbol', '=', $this->model->symbol)
            ->orderBy('date', 'desc')
            ->get();
    }

    protected function title(): string
    {
        return "Shanghai Metrics - {$this->model->full_name}({$this->model->symbol})";
    }
}
