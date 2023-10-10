<?php

namespace App\Http\Livewire\Hkex;

use App\Http\Livewire\BaseFilingsComponent;

class Filings extends BaseFilingsComponent
{
    public function title(): string
    {
        return "HKEX Filings - {$this->model->short_name} ({$this->model->symbol})";
    }

    public function table(): string
    {
        return 'hkex.filings-table';
    }
}
