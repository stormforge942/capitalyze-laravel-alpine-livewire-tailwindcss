<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class LseNavbar extends Component
{
    public $company;
    public $currentRoute;

    public function render()
    {
        return view('livewire.lse-navbar');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
