<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ComapnyOwnership extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $infoTabActive = "discover"; 
    public $loading = false;

    public function setInfoActiveTab(string $tab): void {
        $this->infoTabActive = $tab;
        $this->emit('lodingFire');
    }
    
    public function render()
    {
        $this->loading = true;
        return view('livewire.comapny-ownership');
    }
}
