<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompanyNavbar extends Component
{
    public $company;
    public $period = "annual";

    public function render()
    {
        return view('livewire.company-navbar');
    }
}
