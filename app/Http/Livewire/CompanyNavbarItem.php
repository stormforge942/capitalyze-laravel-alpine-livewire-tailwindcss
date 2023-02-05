<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;


class CompanyNavbarItem extends Component
{
    public $name;
    public $href;
    public $active;
    public $route;

    public function render()
    {
        return view('livewire.company-navbar-item');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        if ($route !== '') {
            $this->active = $request->route()->getName() === $route;
            $this->route = $route;
        } else {
            $this->active = $active;
        }
    }
}
