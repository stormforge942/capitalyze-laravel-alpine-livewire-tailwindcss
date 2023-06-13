<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class AdminUsers extends Component
{
    use WithPagination;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function render()
    {
        $users = User::orderBy($this->sortBy, $this->sortDirection)->paginate(10);
        return view('livewire.admin-users', compact('users'));
    }    

    public function sortBy($field)
    {
        if ($this->sortDirection == 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
    }

    public function approveUser($userId)
    {
        $user = User::find($userId);
        $user->approved = true;
        $user->save();
    }

    public function disapproveUser($userId)
    {
        $user = User::find($userId);
        $user->approved = false;
        $user->save();
    }
}
