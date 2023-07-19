<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;


class FundFilingsPage extends Component
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
        return view('livewire.funds-filings-page');
    }
}
