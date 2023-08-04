<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LseFilings extends Component
{
    public $japan;

    public function mount($japan) {
        $this->japan = $japan;
    }

    public function render()
    {
        return view('livewire.japan-filings');
    }
}
