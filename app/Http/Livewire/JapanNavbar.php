<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Navbar;

class JapanNavbar extends Component
{
    public $japan;
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
        return redirect()->route($this->currentRoute, ['ticker'=>$this->japan->symbol, 'period' => $period]);
    }    

    public function render()
    {
        return view('livewire.japan-navbar');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        $this->navbarItems = Navbar::get();
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
