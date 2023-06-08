<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FundInsider extends Component
{
    public $fund;
    public $cik;

    public function mount($fund, $cik)
    {
        $this->fund = $fund;
        $this->cik = $cik;
    }

    public function render()
    {
        return view('livewire.fund-insider');
    }
}
