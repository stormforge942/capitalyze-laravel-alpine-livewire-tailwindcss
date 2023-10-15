<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompanyInsiders extends Component
{
    public $company;
    public $ticker;

    public function mount($company, $ticker)
    {
        $this->company = $company;
        $this->ticker = $ticker;
    }

    public function render()
    {
        return view('livewire.company-insiders');
    }
}
