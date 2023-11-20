<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;

class AllFilings extends Component
{
    public $company;
    public $ticker;
    public $model = false;
    public $selectedTab = "all-documents";
    public $checkedCount;
    protected $listeners = ['handleAllFilingsTabs' => 'handleTabs', 'emitCountInAllfilings'];

    public function handleTabs($tab){
        $this->selectedTab = $tab;
    }

    public function emitCountInAllfilings($selectChecked){
        $this->checkedCount = count($selectChecked);
    }

    public function handleFilingBrowserType($val){
        $this->emit('handleFilingBrowserType', true);
    }

    public function render()
    {
        return view('livewire.filings-summary.all-filings');
    }
}
