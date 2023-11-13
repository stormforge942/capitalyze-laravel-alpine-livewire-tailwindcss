<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;

class AllFilings extends Component
{
    public $company;
    public $ticker;
    public $model = false;
    public $selectedTab = "all-documents";
    protected $listeners = ['handleAllFilingsTabs' => 'handleTabs'];

    public function handleTabs($tab){
        $this->selectedTab = $tab;
    }

    public function handleFilingBrowserType($val){
        $this->emit('handleFilingBrowserType', true);
    }

    public function render()
    {
        return view('livewire.filings-summary.all-filings');
    }
}
