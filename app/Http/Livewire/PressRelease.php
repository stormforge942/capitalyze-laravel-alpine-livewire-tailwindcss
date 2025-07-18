<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;

class PressRelease extends Component
{
    public $company;
    public $pressReleases;

    public function mount()
    {
        // only because of left bar needs a default ticker if clicked on it
        $company = Company::where('ticker', "AAPL")->get()->first();
        $this->company = $company;
    }

    public function render()
    {
        return view('livewire.press-release');
    }
}
