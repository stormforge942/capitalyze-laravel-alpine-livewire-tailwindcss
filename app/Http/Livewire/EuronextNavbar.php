<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class EuronextNavbar extends Component
{
    public $euronext;
    public $currentRoute;
    public $period = "annual";

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
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
