<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TsxFilings extends Component
{
    public $tsx;

    public function mount($tsx) {
        $this->tsx = $tsx;
    }

    public function render()
    {
        return view('livewire.tsx-filings');
    }
}
