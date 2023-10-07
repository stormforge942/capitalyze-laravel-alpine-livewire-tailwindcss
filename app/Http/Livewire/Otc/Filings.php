<?php

namespace App\Http\Livewire\Otc;

use App\Http\Livewire\BaseFilingsComponent;

class Filings extends BaseFilingsComponent
{
    public function title(): string
    {
        return "OTC Filings - {$this->model->company_name} ({$this->model->symbol})";
    }

    public function table(): string
    {
        return 'otc.filings-table';
    }
}
