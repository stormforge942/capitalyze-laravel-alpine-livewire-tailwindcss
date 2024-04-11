<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Groups;
use Livewire\Component;
use Livewire\WithPagination;
use App\Notifications\AccountApprovedNotification;

class AdminUsers extends Component
{
    use WithPagination;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $confirmingUserDeletion = false;
    public $userToDelete;
    public $groups;

    protected $listeners = ['performUserDeletion'];

    public function render()
    {
        $this->groups = Groups::get();
        $users = User::orderBy($this->sortBy, $this->sortDirection)->paginate(10);
        return view('livewire.admin-users', compact('users'));
    }

    public function updateUserGroup($userId, $value)
    {
        $user = User::find($userId);
        $user->group_id = $value;
        $user->save();
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

    public function approveUser(User $user)
    {
        $user->update([
            'is_approved' => true,
        ]);

        $user->notify(new AccountApprovedNotification);
    }

    public function verifyUserEmail(User $user)
    {
        if (!$user->email_verified_at) {
            $user->markEmailAsVerified();
        }
    }

    public function disapproveUser(User $user)
    {
        $user->update([
            'is_approved' => false,
        ]);
    }

    public function updateIsAdmin(User $user, bool $isAdmin)
    {
        $user->update([
            'is_admin' => $isAdmin,
        ]);
    }

    public function deleteUser($userId)
    {
        $this->userToDelete = User::find($userId);

        $this->confirmingUserDeletion = true;
    }

    public function performUserDeletion()
    {
        $self = auth()->id() == $this->userToDelete->id;

        $this->userToDelete->delete();
        $this->confirmingUserDeletion = false;

        if ($self) {
            return redirect()->route('login');
        }
    }
}
