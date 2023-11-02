<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Navbar;
use App\Models\Groups;
use App\Models\NavbarGroupShows;

class AdminPermissionManagement extends Component
{
    public $navbarItems;
    public $groups;
    public $navbarGroupShows;
    public $navbarItemToEdit = null;

    protected $listeners = ['navbarItemSaved' => 'refreshNavbarItems'];

    public function mount()
    {
        $this->navbarItems = Navbar::orderByDesc('is_moddable')->orderByDesc('id')->get();
        $this->groups = Groups::get();
        $this->navbarGroupShows = NavbarGroupShows::get();
    }

    public function openEditModal($navbarItemId)
    {
        $this->navbarItemToEdit = Navbar::find($navbarItemId);
        $this->emit('openEditModal', $navbarItemId);
    }

    public function refreshNavbarItems()
    {
        $this->navbarItems = Navbar::orderByDesc('is_moddable')->orderByDesc('id')->get();
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

        $this->navbarItems = Navbar::orderByDesc('is_moddable')->orderByDesc('id')->get();
    }

    public function updateNavbarModdable($navbarId, $value)
    {
        $existingNavbarGroupShow = Navbar::find($navbarId)->update(
            [
                'is_moddable' => $value
            ]
        );

        if ($value === "0") {
            $navbarGroups = NavbarGroupShows::where('navbar_id', $navbarId)->get();

            foreach ($navbarGroups as $group) {
                NavbarGroupShows::find($group->id)->update(
                    [
                        'show' => $value
                    ]
                );
            }
        }

        $this->navbarItems = Navbar::orderByDesc('is_moddable')->orderByDesc('id')->get();
    }

    public function isShow($navbarId, $groupId)
    {
        $navbar = NavbarGroupShows::where('navbar_id', $navbarId)->where('group_id', $groupId)->first();

        return $navbar && $navbar->show ? true : false;
    }

    public function render()
    {
        return view('livewire.admin-permission-management');
    }    
}
