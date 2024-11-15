<?php

namespace App\Http\Livewire\InvestorAdviser;

use App\Services\OwnershipHistoryService;
use Livewire\Component;

class Breadcrumb extends Component
{
    public $company;
    public $url;

    public function mount()
    {
        $this->url = request()->url();
    }

    public function render()
    {
        return view('livewire.investor-adviser.breadcrumb', [
            'ticker' => OwnershipHistoryService::getCompany(),
            'historyItems' => OwnershipHistoryService::get($this->url),
        ]);
    }

    public function removeTab(array $tab)
    {
        OwnershipHistoryService::remove($tab['url']);

        if ($tab['active'] ?? false) {
            if (count(OwnershipHistoryService::get())) {
                return redirect(OwnershipHistoryService::get()[0]['url']);
            }

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
