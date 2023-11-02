<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ComapnyTrackInvestor extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $infoTabActive = "track-investor"; 
    public $loading = false;

    public function setInfoActiveTab(string $tab): void {
        $this->infoTabActive = $tab;
        $this->emit('lodingFire');
    }
    
    public function render()
    {
        $this->loading = true;
        return view('livewire.comapny-track-investor');
    }
}
