<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Livewire\Component;


class MutualFundFilingsPage extends Component
{

    public $company;
    public $period = "annual";

    public function mount()
    {

        $company = Company::where('ticker', "AAPL")->get()->first();
        $this->company = $company;

    }

    public function render()
    {
        return view('livewire.mutual-funds-filings-page');
    }
}
