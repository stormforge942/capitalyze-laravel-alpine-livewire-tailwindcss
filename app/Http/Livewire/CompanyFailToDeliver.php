<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyFailToDeliver extends Component
{
    public $company;
    public $ticker;
    public $period;

    public function mount($company, $ticker, $period)
    {
        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
    }

    public function render()
    {
        return view('livewire.company-fail-to-deliver');
    }
}
