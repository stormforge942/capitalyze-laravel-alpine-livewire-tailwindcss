<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Navbar;
use App\Models\NavbarGroupShows;
use App\Models\Groups;
use Illuminate\Support\Facades\Auth;

class MutualFundNavbar extends Component
{
    public $fund;
    public $currentRoute;
    public $navbarItems;

    public function render()
    {
        return view('livewire.mutual-fund-navbar');
    }

    public function showNavbar($navbarId) {
        foreach($this->navbarGroupShows as $show) {
            if ($show->navbar_id === $navbarId && $show->show && Auth::user()->group_id === $show->group_id) {
                return true;
            }
        }
        return false;
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        $this->navbarItems = Navbar::get();
        $this->navbarGroupShows = NavbarGroupShows::get();
        $this->groups = Groups::get();
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
