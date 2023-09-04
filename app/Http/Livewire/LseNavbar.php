<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Navbar;
use App\Models\NavbarGroupShows;
use App\Models\Groups;
use Illuminate\Support\Facades\Auth;

class LseNavbar extends Component
{
    public $lse;
    public $currentRoute;
    public $period = "annual";
    public $navbarItems;

    protected $queryString = [
        'period' => ['except' => 'annual']
    ];

    protected $listeners = ['periodChange' => '$refresh'];

    public function changePeriod($period)
    {
        $this->period = $period;
        return redirect()->route($this->currentRoute, ['ticker'=>$this->lse->symbol, 'period' => $period]);
    }

    public function render()
    {
        return view('livewire.lse-navbar');
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
