<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EuronextFilings extends Component
{
    public $euronext;

    public function mount($euronext) {
        $this->euronext = $euronext;
    }

    public function render()
    {
        return view('livewire.euronext-filings');
    }
}
