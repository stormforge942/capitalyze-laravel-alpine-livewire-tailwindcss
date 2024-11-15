<?php

namespace App\Http\Livewire\InvestorAdviser;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdviserCard extends Component
{
    public $adviser;

    public function render()
    {
        return view('livewire.investor-adviser.adviser-card');
    }
}
