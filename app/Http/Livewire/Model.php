<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Model extends Component
{
    public $open = false;

    protected $listeners = ['open'=>'open'];

    public function open(){
        $this->open = true;
        dd('sdlasj');
    }

}
