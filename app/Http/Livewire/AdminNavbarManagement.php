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
        $this->navbarItems = Navbar::orderBy('id', 'asc')->get();
    }


    public function updateNavbar($navbarId, $value)
    {
        $navbar = Navbar::find($navbarId);
        $navbar->show = $value;
        $navbar->save();
    }

    public function render()
    {
        return view('livewire.admin-navbar-management');
    }    
}
