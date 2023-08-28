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


    public function updateNavbarForUsers($navbarId, $value)
    {
        $navbar = Navbar::find($navbarId);
        $navbar->show_users = $value;
        $navbar->save();
    }

    public function updateNavbarForTesters($navbarId, $value)
    {
        $navbar = Navbar::find($navbarId);
        $navbar->show_testers = $value;
        $navbar->save();
    }

    public function updateNavbarForAdmins($navbarId, $value)
    {
        $navbar = Navbar::find($navbarId);
        $navbar->show_admins = $value;
        $navbar->save();
    }

    public function updateNavbarForDevelopers($navbarId, $value)
    {
        $navbar = Navbar::find($navbarId);
        $navbar->show_developers = $value;
        $navbar->save();
    }

    public function render()
    {
        return view('livewire.admin-navbar-management');
    }    
}
