<?php

namespace App\Http\Livewire\KeyExhibits;

use Livewire\Component;
use App\Models\CompanyLinks;

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
        return view('livewire.key-exhibits.common-layout');
    }
}
