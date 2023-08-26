<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Navbar;

class AdminNavbarManagement extends Component
{
    public $navbarItems;

    public function mount()
    {
        $this->navbarItems = Navbar::get();
    }


    public function updateNavbar($navbarName, $value)
    {
        $navbar = Navbar::where('name', $navbarName)->get()->first();
        $navbar->update(['show' => $value]);
    }

    public function render()
    {
        return view('livewire.admin-navbar-management');
    }    
}
