<?php

namespace App\Http\Livewire\Frankfurt;

use App\Http\Livewire\BaseFilingsComponent;

class Filings extends BaseFilingsComponent
{
    public function title(): string
    {
        return "Frankfurt Filings - {$this->model->company_name} ({$this->model->symbol})";
    }

    public function table(): string
    {
        return 'frankfurt.filings-table';
    }
}
