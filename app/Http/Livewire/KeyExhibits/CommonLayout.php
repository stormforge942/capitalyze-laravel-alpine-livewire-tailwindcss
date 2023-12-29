<?php

namespace App\Http\Livewire\KeyExhibits;

use Livewire\Component;
use App\Models\CompanyLinks;

class CommonLayout extends Component
{
    public $data;
    public $order;
    public $col;
    public $company;

    public function handleSorting($column){
        $this->emit('sortingOrder', [$column, $this->order]);
    }
    
    public function render()
    {
        return view('livewire.key-exhibits.common-layout');
    }
}
