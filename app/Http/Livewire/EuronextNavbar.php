<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class EuronextNavbar extends Component
{
    public $euronext;
    public $currentRoute;

    public function render()
    {
        return view('livewire.euronext-navbar');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
