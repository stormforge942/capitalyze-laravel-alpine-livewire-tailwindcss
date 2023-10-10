<?php

namespace App\Http\Livewire\Lse;

use App\Http\Livewire\BaseFilingsComponent;

class Filings extends BaseFilingsComponent
{
    public function title(): string
    {
        return "LSE Filings - {$this->model->registrant_name} ({$this->model->symbol})";
    }
}
