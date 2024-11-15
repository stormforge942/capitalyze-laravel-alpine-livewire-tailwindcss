<?php

namespace App\Http\Livewire\InvestorAdviser;

use Livewire\Component;
use App\Services\OwnershipHistoryService;

class Adviser extends Component
{
    public $tabs = [
        AdviserSummary::class,
        AdviserDetailInformation::class,
    ];

    public $company;
    public $adviser;

    public function mount($adviser, $company = null)
    {
        $this->adviser = $adviser;
        $this->company = $company;

        OwnershipHistoryService::push([
            'name' => $this->adviser->legal_name,
            'url' => request()->url(),
        ]);
    }

    public function render()
    {
        return view('livewire.investor-adviser.adviser');
    }
}
