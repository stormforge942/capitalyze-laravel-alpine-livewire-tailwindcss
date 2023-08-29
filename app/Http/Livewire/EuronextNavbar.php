<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Navbar;

class EuronextNavbar extends Component
{
    public $euronext;
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
        return redirect()->route($this->currentRoute, ['ticker'=>$this->euronext->symbol, 'period' => $period]);
    }    

    public function render()
    {
        return view('livewire.euronext-navbar');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        $this->navbarItems = Navbar::get();
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
