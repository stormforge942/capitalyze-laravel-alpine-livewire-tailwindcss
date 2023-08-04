<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShanghaiFilings extends Component
{
    public $shanghai;

    public function mount($shanghai) {
        $this->shanghai = $shanghai;
    }

    public function render()
    {
        return view('livewire.shanghai-filings');
    }
}
