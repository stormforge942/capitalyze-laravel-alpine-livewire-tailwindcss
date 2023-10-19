<?php

namespace App\Http\Livewire\Ownership;

use App\Models\Fund;
use App\Models\Company;
use Livewire\Component;

class CompanyFund extends Component
{
    public $company;
    public $fund;

    public $tabs = [
        CompanyFundSummary::class,
        CompanyFundHoldings::class,
    ];

    public function mount(Company $company)
    {
        $this->company = $company;

        $this->fund = Fund::where('cik', request()->route('fund'))->firstOrFail();
    }

    public function render()
    {
        return view('livewire.ownership.company-fund');
    }
}
