<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Services\OwnershipHistoryService;

class MutualFund extends Component
{
    public $company;
    public $fund;

    public $tabs = [
        MutualFundHoldings::class,
    ];

    public function mount($fund, $company = null)
    {
        $this->fund = $fund;
        $this->company = $company;

        OwnershipHistoryService::push([
            'name' => $this->fund->registrant_name,
            'url' => request()->url(),
        ]);
    }

    public function render()
    {
        return view('livewire.ownership.mutual-fund');
    }
}
