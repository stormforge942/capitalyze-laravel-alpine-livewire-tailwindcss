<?php

namespace App\Http\Livewire\Ownership;

use App\Models\Fund;
use App\Models\Company;
use Livewire\Component;
use Illuminate\Support\Arr;

class Shareholder extends Component
{
    public $company;
    public $funds;
    public $active;
    
    public $queryString = [
        'funds' => [],
        'active' => []
    ];

    public $tabs = [
        ShareholderSummary::class,
        ShareholderHoldings::class,
    ];

    public function mount(Company $company)
    {
        $this->company = $company;

        $funds = Fund::whereIn('cik', Arr::wrap(request('companies', [])))->get();

        $active = Fund::where('cik', request()->route('company'))->firstOrFail();

        if (!$funds->firstWhere('cik', $active->cik)) {
            $funds->push($active);
        }
        
        $this->funds = $funds;
        $this->active = $active->cik;
    }

    public function render()
    {
        return view('livewire.ownership.shareholder', [
            'activeFund' => $this->funds->firstWhere('cik', $this->active),
        ]);
    }

    function setActive(string $cik)
    {
        $this->active = $cik;
    }
}
