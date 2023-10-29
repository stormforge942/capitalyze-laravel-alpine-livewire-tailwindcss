<?php

namespace App\Http\Livewire\Ownership;

use App\Services\OwnershipHistoryService;
use Livewire\Component;

class Breadcrumb extends Component
{
    public $company;

    public function mount($company)
    {
        $this->company = $company;
    }

    public function render()
    {
        return view('livewire.ownership.breadcrumb', [
            'historyItems' => OwnershipHistoryService::get(),
        ]);
    }

    public function removeHistory($url)
    {
        $lastItem = OwnershipHistoryService::remove($url);

        if ($lastItem) {
            return redirect($lastItem['url']);
        }

        return redirect()->route('company.ownership', $this->company);
    }

    public function clearHistory()
    {
        OwnershipHistoryService::clear();

        if (OwnershipHistoryService::getCompanyUrl()) {
            return redirect(OwnershipHistoryService::getCompanyUrl());
        }

        return redirect()->route('company.ownership', $this->company);
    }
}
