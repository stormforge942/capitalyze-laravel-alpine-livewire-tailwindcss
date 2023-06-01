<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class FundNavbar extends Component
{
    public $fund;
    public $currentRoute;

    public function render()
    {
        return view('livewire.fund-navbar');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
