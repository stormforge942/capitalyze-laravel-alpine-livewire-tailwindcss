<?php

namespace App\Http\Livewire\Ownership;

use App\Services\OwnershipHistoryService;
use Livewire\Component;

class Breadcrumb extends Component
{
    public $company;

    public function render()
    {
        return view('livewire.ownership.breadcrumb', [
            'ticker' => OwnershipHistoryService::getCompany(),
            'historyItems' => OwnershipHistoryService::get(),
        ]);
    }

    public function removeHistory($url)
    {
        $lastItem = OwnershipHistoryService::remove($url);

        if ($lastItem) {
            return redirect($lastItem['url']);
        }

        $this->clearHistory();
    }

    public function clearHistory()
    {
        OwnershipHistoryService::clear();

        return redirect(route('company.ownership', ['ticker' => OwnershipHistoryService::getCompany()]));
    }
}
