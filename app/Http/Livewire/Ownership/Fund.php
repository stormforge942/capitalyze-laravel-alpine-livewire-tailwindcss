<?php

namespace App\Http\Livewire\Ownership;

use App\Models\Fund as FundModel;
use App\Models\Company;
use Livewire\Component;
use App\Models\CompanyInsider;
use App\Services\OwnershipHistoryService;

class Fund extends Component
{
    public $company;
    public $fund;
    public $formTypes;

    public $tabs = [
        FundSummary::class,
        FundHoldings::class,
    ];

    public function mount(Company $company)
    {
        $this->company = $company;

        $this->fund = FundModel::where('cik', request()->route('fund'))->firstOrFail();

        OwnershipHistoryService::push([
            'name' => $this->fund->name,
            'type' => 'fund',
            'url' => request()->url(),
        ]);

        $this->formTypes = $this->getFormTypes();
    }

    public function getFormTypes()
    {
        return CompanyInsider::query()
            ->where('cik', $this->fund->cik)
            ->distinct()
            ->pluck('form_type')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.ownership.fund');
    }
}
