<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HkexFilings extends Component
{
    public $hkex;

    public function mount($hkex) {
        $this->hkex = $hkex;
    }

    public function render()
    {
        return view('livewire.hkex-filings');
    }
}
