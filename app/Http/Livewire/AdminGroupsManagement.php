<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Groups;

class AdminGroupsManagement extends Component
{
    public $groups;
    public $confirmingGroupDeletion = false;
    public $groupToDelete;

    protected $listeners = ['performGroupDeletion'];

    public function mount()
    {
        $this->groups = Groups::get();
    }

    public function deleteGroup($groupId)
    {
        $this->groupToDelete = Groups::find($groupId);
        $this->dispatchBrowserEvent('swal:confirming-group-deletion', [
            'title' => __('Confirm Group Deletion'),
            'text' => __('Are you sure you want to delete this group?'),
            'type' => 'warning',
            'confirmButtonText' => __('Delete Group'),
            'cancelButtonText' => __('Cancel'),
        ]);
    }    

    public function performGroupDeletion()
    {
        $this->groupToDelete->delete();
        $this->confirmingGroupDeletion = false;

        $this->groups = Groups::get();
    }

    public function createGroup($value)
    {
        $newGroup = Groups::create(
            [
                'name' => $value,
            ]
        );

        $this->groups = Groups::get();
    }

    public function render()
    {
        return view('livewire.admin-groups-management');
    }    
}
