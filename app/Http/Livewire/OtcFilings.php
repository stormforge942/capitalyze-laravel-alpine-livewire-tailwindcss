<?php

namespace App\Http\Livewire;

use Livewire\Component;

class OtcFilings extends Component
{
    public $otc;

    public function mount($otc) {
        $this->otc = $otc;
    }

    public function render()
    {
        return view('livewire.otc-filings');
    }
}
