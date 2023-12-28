<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;

class AllFilings extends Component
{
    public $company;
    public $ticker;
    public $selectedTab = "all-documents";
    protected $listeners = ['handleAllFilingsTabs' => 'handleTabs'];

    public function handleTabs($tab){
        $this->selectedTab = is_array($tab) ? $tab[0] : $tab;
        $this->emit('passTabNameInParent', $this->selectedTab);
    }

    public function handleFilingBrowserType($val){
        $this->emit('handleFilingBrowserType', true);
    }

    public function render()
    {
        return view('livewire.filings-summary.all-filings');
    }
}
