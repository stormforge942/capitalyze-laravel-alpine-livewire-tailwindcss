<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;

class ViewPopUpModel extends Component
{
    public $test ="hello";
    public function render()
    {
        return view('livewire.filings-summary.view-pop-up-model');
    }
}
