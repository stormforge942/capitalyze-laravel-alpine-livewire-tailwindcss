<?php

namespace App\Http\Livewire\Frankfurt;

use App\Http\Livewire\BaseFilingsTable;
use App\Models\FrankfurtFilings;
use Illuminate\Database\Eloquent\Builder;

class FilingsTable extends BaseFilingsTable
{
    public function data(): ?Builder
    {
        return FrankfurtFilings::query()
            ->where('symbol', '=', $this->model->symbol);
    }
}
