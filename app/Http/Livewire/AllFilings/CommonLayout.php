<?php

namespace App\Http\Livewire\AllFilings;

use Livewire\Component;

class CommonLayout extends Component
{
    public $data;
    public $order;

    public function handleSorting($column){
        $this->emit('sortingOrder', [$column, $this->order]);
        $this->col = $column;
    }
    
    public function render()
    {
        return view('livewire.all-filings.common-layout');
    }
}
