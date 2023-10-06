<?php

namespace App\Http\Livewire\Otc;

use App\Models\OtcFilings;
use App\Http\Livewire\BaseFilingsTable;
use Illuminate\Database\Eloquent\Builder;

class FilingsTable extends BaseFilingsTable
{
    public function data(): ?Builder
    {
        return OtcFilings::query()
            ->where('symbol', '=', $this->model->symbol);
    }
}
