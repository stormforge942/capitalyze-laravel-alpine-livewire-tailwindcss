<?php

namespace App\Http\Livewire\KeyExhibits;

use Livewire\Component;

class CommonLayout extends Component
{
    public $data;
    
    public function render()
    {
        return view('livewire.key-exhibits.common-layout');
    }
}
