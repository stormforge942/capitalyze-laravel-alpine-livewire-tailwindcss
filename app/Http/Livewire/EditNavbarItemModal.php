<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Navbar;

class EditNavbarItemModal extends Component
{
    public $isOpen = false;
    public $navbarItem;

    protected $listeners = ['openEditModal', 'closeEditModal'];

    protected $rules = [
        'navbarItem.name' => 'required|string',
        'navbarItem.route_name' => 'required|string',
        'navbarItem.is_moddable' => 'required|boolean',
    ];

    public function openEditModal($navbarItemId)
    {
        $this->navbarItem = Navbar::find($navbarItemId);
        $this->isOpen = true;
    }

    public function closeEditModal()
    {
        $this->isOpen = false;
    }

    public function saveNavbarItem()
    {
        $this->validate();

        $this->navbarItem->save();

        $this->isOpen = false;

        $this->emit('navbarItemSaved', $this->navbarItem->id);
    }

    public function render()
    {
        return view('livewire.edit-navbar-item-modal');
    }
}
