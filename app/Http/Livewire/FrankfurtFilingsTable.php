<?php

namespace App\Http\Livewire;

use App\Models\Frankfurt;
use Illuminate\Database\Eloquent\Builder;

class FrankfurtFilingsTable extends BaseFilingsTable
{
    public function title(): string
    {
        return "Frankfurt Metrics - {$this->model->company_name}({$this->model->symbol})";
    }

    public function data(): ?Builder
    {
        return Frankfurt::query()
            ->where('symbol', '=', $this->otc->symbol);
    }
}
