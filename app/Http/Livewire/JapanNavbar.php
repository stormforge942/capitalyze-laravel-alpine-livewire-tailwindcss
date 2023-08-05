<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class JapanNavbar extends Component
{
    public $japan;
    public $currentRoute;

    public function render()
    {
        return view('livewire.japan-navbar');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
