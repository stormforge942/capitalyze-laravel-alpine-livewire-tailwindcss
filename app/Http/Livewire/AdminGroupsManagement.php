<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Groups;

class AdminGroupsManagement extends Component
{
    public $groups;

    public function mount()
    {
        $this->groups = Groups::get();
    }

    public function render()
    {
        return view('livewire.admin-groups-management');
    }    
}
