<?php

namespace App\Http\Livewire\Shanghai;

use App\Http\Livewire\BaseFilingsComponent;

class Filings extends BaseFilingsComponent
{
    public function title(): string
    {
        return "Shanghai Filings - {$this->model->full_name} ({$this->model->symbol})";
    }
}
