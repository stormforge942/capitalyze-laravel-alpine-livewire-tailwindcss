<?php

namespace App\Http\Livewire\Tsx;

use App\Http\Livewire\BaseFilingsComponent;

class Filings extends BaseFilingsComponent
{
    public function title(): string
    {
        return "TSX Filings - {$this->model->registrant_name} ({$this->model->symbol})";
    }
}
