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
        $this->tabName = $tab;
    }
    
    public function render()
    {
        return view('livewire.comapany-filings-summary');
    }
}
