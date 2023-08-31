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
        $this->navbarItems = Navbar::orderBy('position', 'asc')->orderBy('id', 'asc')->get();
        $this->groups = Groups::get();
        $this->navbarGroupShows = NavbarGroupShows::get();
    }

    public function updateNavbar($navbarId, $groupId, $value)
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

        $this->navbarItems = Navbar::orderBy('position', 'asc')->orderBy('id', 'asc')->get();
    }

    public function updateNavbarClosed($navbarId, $value)
    {
        $existingNavbarGroupShow = Navbar::find($navbarId)->update(
            [
                'is_closed' => $value
            ]
        );

        $this->navbarItems = Navbar::orderBy('position', 'asc')->orderBy('id', 'asc')->get();
    }

    public function updateNavbarCustom($navbarId, $value)
    {
        $existingNavbarGroupShow = Navbar::find($navbarId)->update(
            [
                'is_custom' => $value
            ]
        );

        $this->navbarItems = Navbar::orderBy('position', 'asc')->orderBy('id', 'asc')->get();
    }

    public function updateNavbarPosition($navbarId, $value)
    {
        $existingNavbarGroupShow = Navbar::find($navbarId)->update(
            [
                'position' => $value
            ]
        );

        $this->navbarItems = Navbar::orderBy('position', 'asc')->orderBy('id', 'asc')->get();
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
