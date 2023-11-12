<?php

namespace App\Http\Livewire\AllFilings;

use Livewire\Component;

class FilingsPopUp extends Component
{
    public $model = false;
    protected $listeners = ['handleFilingBrowserType'];

    public function handleFilingBrowserType($val){
        dd($val);
        $this->model = $val;
    }

    public function render()
    {
        return view('livewire.all-filings.filings-pop-up');
    }
}
