<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Navbar;
use App\Models\Groups;
use App\Models\NavbarGroupShows;

class AdminNavbarManagement extends Component
{
    public $navbarItems;
    public $groups;
    public $navbarGroupShows;

    public function mount()
    {
        $this->navbarItems = Navbar::orderBy('id', 'asc')->get();
        $this->groups = Groups::get();
        $this->navbarGroupShows = NavbarGroupShows::get();
    }

    public function updateNavbarShow($navbarId, $groupId, $value)
    {
        $existingNavbarGroupShow = NavbarGroupShows::updateOrCreate(
            [
                'navbar_id' => $navbarId,
                'group_id' => $groupId,
            ], 
            [
                'show' => $value
            ]
        );

        $this->navbarItems = Navbar::orderBy('id', 'asc')->get();
    }

    public function updateNavbarModdable($navbarId, $value)
    {
        $existingNavbarGroupShow = Navbar::find($navbarId)->update(
            [
                'is_moddable' => $value
            ]
        );

        $this->navbarItems = Navbar::orderBy('id', 'asc')->get();
    }

    public function isShow($navbarId, $groupId)
    {
        $navbar = NavbarGroupShows::where('navbar_id', $navbarId)->where('group_id', $groupId)->first();

        return $navbar && $navbar->show ? true : false;
    }

    public function render()
    {
        return view('livewire.admin-navbar-management');
    }    
}
