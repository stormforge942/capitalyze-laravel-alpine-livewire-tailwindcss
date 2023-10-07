<?php

namespace App\Http\Livewire\Euronext;

use App\Http\Livewire\BaseFilingsComponent;

class Filings extends BaseFilingsComponent
{
    public function title(): string
    {
        return "Euronext Filings - {$this->model->registrant_name} ({$this->model->symbol})";
    }
}
