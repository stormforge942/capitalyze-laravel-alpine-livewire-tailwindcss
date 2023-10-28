<?php

namespace App\Http\Livewire\Ownership;

use App\Models\Fund;
use App\Models\Company;
use Livewire\Component;
use App\Models\CompanyInsider;

class CompanyFund extends Component
{
    public $company;
    public $fund;
    public $formTypes;

    public $tabs = [
        CompanyFundSummary::class,
        CompanyFundHoldings::class,
    ];

    public function mount(Company $company)
    {
        $this->company = $company;

        $this->fund = Fund::where('cik', request()->route('fund'))->firstOrFail();

        $this->formTypes = $this->getFormTypes();
    }

    public function getFormTypes()
    {
        return CompanyInsider::query()
            ->where('symbol', $this->company->ticker)
            ->where('cik', $this->fund->cik)
            ->distinct()
            ->pluck('form_type')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.ownership.company-fund');
    }
}
