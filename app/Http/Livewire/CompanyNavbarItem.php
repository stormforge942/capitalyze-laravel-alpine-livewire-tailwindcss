<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Component;


class CompanyNavbarItem extends Component
{
    public $name;
    public $href;
    public $active;

    public function render()
    {
        return view('livewire.company-navbar-item');
    }

}
