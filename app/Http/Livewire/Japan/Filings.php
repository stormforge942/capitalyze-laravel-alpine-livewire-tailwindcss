<?php

namespace App\Http\Livewire\Japan;

use App\Http\Livewire\BaseFilingsComponent;

class Filings extends BaseFilingsComponent
{
    public function title(): string
    {
        return "Japan Filings - {$this->model->registrant_name} ({$this->model->symbol})";
    }

    public function table(): string
    {
        return 'japan.filings-table';
    }
}
