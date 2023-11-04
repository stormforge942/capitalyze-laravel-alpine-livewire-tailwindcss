<?php

namespace App\Http\Livewire\Etf;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $etf;
    public $currentRoute;
    public $topNav;
    public $bottomNav;

    public function render()
    {
        return view('livewire.etf.navbar');
    }

    public function mount(Request $request)
    {
        $navItems = Auth::user()->navbars();

        $this->topNav = \App\Models\Navbar::getPrimaryLinks($navItems);

        $this->bottomNav = $navItems->where(function ($nav) {
            return Str::startsWith($nav->route_name, 'etf.');
        });

        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
