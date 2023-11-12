<?php

namespace App\Http\Livewire\AllFilings;

use Livewire\Component;

class CommonLayout extends Component
{
    public $data;
    
    public function render()
    {
        return view('livewire.all-filings.common-layout');
    }
}
