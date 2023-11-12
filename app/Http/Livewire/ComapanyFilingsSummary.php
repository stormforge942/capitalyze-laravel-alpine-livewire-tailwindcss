<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ComapanyFilingsSummary extends Component
{
    public $tabName = "summary";
    public $company;
    public $ticker;
    public $period;

    protected $listeners = ['handleFilingsSummaryTab' => 'setTabName'];

    public function setTabName($tab){
        $selectedTab = is_array($tab) ? $tab[0] : $tab;
        $this->tabName = $selectedTab;
        if(is_array($tab)){
            $this->emit('handleAllFilingsTabs', $tab[1]);
        }
    }
    
    public function render()
    {
        return view('livewire.comapany-filings-summary');
    }
}
