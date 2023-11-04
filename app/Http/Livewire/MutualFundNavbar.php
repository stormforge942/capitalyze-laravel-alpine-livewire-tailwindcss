<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutualFundNavbar extends Component
{
    public $fund;
    public $currentRoute;
    public $topNav;
    public $bottomNav;

    public function render()
    {
        return view('livewire.mutual-fund-navbar');
    }

    public function showNavbar($navbarId)
    {
        foreach ($this->navbarGroupShows as $show) {
            if ($show->navbar_id === $navbarId && $show->show && Auth::user()->group_id === $show->group_id) {
                return true;
            }
        }
        return false;
    }

    public function mount(Request $request)
    {
        $navItems = Auth::user()->navbars();

        $this->topNav = \App\Models\Navbar::getPrimaryLinks($navItems);

        $this->bottomNav = $navItems->where(function ($nav) {
            return Str::startsWith($nav->route_name, 'mutual-fund.');
        });

        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
