<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FundNavbar extends Component
{
    public $fund;
    public $currentRoute;
    public $topNav;
    public $bottomNav;

    public function render()
    {
        return view('livewire.fund-navbar');
    }

    public function mount(Request $request)
    {
        $navItems = Auth::user()->navbars();

        $this->topNav = \App\Models\Navbar::getPrimaryLinks($navItems);

        $this->bottomNav = $navItems->where(function ($nav) {
            return Str::startsWith($nav->route_name, 'fund.');
        });

        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
