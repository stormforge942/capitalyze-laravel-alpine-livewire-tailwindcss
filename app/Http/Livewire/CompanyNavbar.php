<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class CompanyNavbar extends Component
{
    public $company;
    public $period = "annual";
    public $currentRoute;

    protected $queryString = [
        'period' => ['except' => 'annual']
    ];

    public function render()
    {
        return view('livewire.company-navbar');
    }

    public function mount(Request $request, $route = '', $active = false)
    {
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
