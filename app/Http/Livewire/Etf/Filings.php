<?php

namespace App\Http\Livewire\Etf;

use Livewire\Component;

class Filings extends Component
{
    public $company;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.etf.filings');
    }
}
