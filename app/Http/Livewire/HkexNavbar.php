<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class HkexNavbar extends Component
{
    public $hkex;
    public $currentRoute;
    public $period = "annual";

    protected $queryString = [
        'period' => ['except' => 'annual']
    ];

    protected $listeners = ['periodChange' => '$refresh'];

    public function changePeriod($period)
    {
        $this->period = $period;
        return redirect()->route($this->currentRoute, ['ticker'=>$this->hkex->symbol, 'period' => $period]);
    }

    public function render()
    {
        return view('livewire.hkex-navbar');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
