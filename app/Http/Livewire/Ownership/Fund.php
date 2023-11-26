<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Models\CompanyInsider;
use App\Http\Livewire\Ownership\History;
use App\Services\OwnershipHistoryService;

class Fund extends Component
{
    public $company;
    public $fund;
    public $formTypes;

    public $tabs = [
        FundSummary::class,
        FundHoldings::class,
        // History::class,
    ];

    public function mount($fund, $company = null)
    {
        $this->fund = $fund;
        $this->company = $company;

        OwnershipHistoryService::push([
            'name' => $this->fund->name,
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
