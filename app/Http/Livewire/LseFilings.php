<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LseFilings extends Component
{
    public $euronext;

    public function mount($lse) {
        $this->lse = $lse;
    }

    public function render()
    {
        return view('livewire.lse-filings');
    }
}
