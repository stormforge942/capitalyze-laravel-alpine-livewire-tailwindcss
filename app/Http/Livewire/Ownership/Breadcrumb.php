<?php

namespace App\Http\Livewire\Ownership;

use App\Services\OwnershipHistoryService;
use Livewire\Component;

class Breadcrumb extends Component
{
    public $company;
    public $url;

    public function mount() {
        $this->url = request()->url();
    }
    
    public function render()
    {
        return view('livewire.ownership.breadcrumb', [
            'ticker' => OwnershipHistoryService::getCompany(),
            'historyItems' => OwnershipHistoryService::get($this->url),
        ]);
    }

    public function removeTab(array $tab)
    {
        OwnershipHistoryService::remove($tab['url']);

        if ($tab['active'] ?? false) {
            return redirect(route('company.ownership', ['ticker' => OwnershipHistoryService::getCompany()]));
        }

        return back();
    }

    public function clearHistory()
    {
        OwnershipHistoryService::clear();

        return redirect(route('company.ownership', ['ticker' => OwnershipHistoryService::getCompany()]));
    }
}
