<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class ShanghaiNavbar extends Component
{
    public $shanghai;
    public $currentRoute;

    public function render()
    {
        return view('livewire.shanghai-navbar');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
