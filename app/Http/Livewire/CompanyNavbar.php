<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Navbar;
use App\Models\NavbarGroupShows;
use App\Models\Groups;

class CompanyNavbar extends Component
{
    public $company;
    public $period = "annual";
    public $currentRoute;
    public $navbarItems;
    public $navbarGroupShows;
    public $groups;

    protected $queryString = [
        'period' => ['except' => 'annual']
    ];

    protected $listeners = ['periodChange' => '$refresh'];

    public function changePeriod($period)
    {
        $this->period = $period;
        return redirect()->route($this->currentRoute, ['ticker'=>$this->company->ticker, 'period' => $period]);
    }    

    public function render()
    {
        return view('livewire.company-navbar');
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
        $this->navbarItems = Navbar::orderBy('position', 'asc')->get();
        $this->navbarGroupShows = NavbarGroupShows::get();
        $this->groups = Groups::get();
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}

