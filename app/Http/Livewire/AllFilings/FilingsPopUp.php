<?php

namespace App\Http\Livewire\AllFilings;

use Livewire\Component;

class FilingsPopUp extends Component
{
    public $model = false;
    public $selectedIds = [];

    protected $listeners = ['handleFilingBrowserType'];

    public function handleFilingBrowserType($val){
        $this->model = $val;
    }

    public function handleCheckBox(){
      $this->emit('emitCountInAllfilings', count($this->selectedIds));  
    }

    public function render()
    {
        return view('livewire.all-filings.filings-pop-up');
    }
}
