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
        $this->navbarItems = Navbar::get();
        $this->groups = Groups::get();
        $this->navbarGroupShows = NavbarGroupShows::get();
    }

    public function updateNavbar($navbarId, $groupId, $value)
    {
        $existingNavbarGroupShow = NavbarGroupShows::where('navbar_id', $navbarId)
        ->where('group_id', $groupId)
        ->first();

        if ($existingNavbarGroupShow) {
            // Update the existing row
            $existingNavbarGroupShow->show = $value;
            $existingNavbarGroupShow->save();
        } else {
            // Create a new row
            $navbarGroupShow = new NavbarGroupShows();
            $navbarGroupShow->navbar_id = $navbarId;
            $navbarGroupShow->group_id = $groupId;
            $navbarGroupShow->show = $value;
            $navbarGroupShow->save();
        }
    }

    public function isShow($navbarId, $group_id)
    {
        $navbar = NavbarGroupShows::where('navbar_id', $navbarId)->where('group_id', $group_id)->first();

        if ($navbar) {
            return $navbar->show;
        }
    
        return false;
    }

    public function render()
    {
        return view('livewire.admin-navbar-management');
    }    
}
