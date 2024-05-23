<?php

namespace App\Http\Livewire\InvitedAuth;

use App\Models\User;
use Livewire\Component;

class VerifyEmail extends Component
{
    public $email;
    public $isWrong = false;

    public function checkEmail()
    {
        $user = User::where('email', $this->email)->first();
        $this->isWrong = !$user;

        if ($user) {
            return redirect()->route('invited-auth.confirm-email')
                ->with('user', $user->id);
        }
    }

    public function render()
    {
        return view('livewire.invited-auth.verify-email');
    }
}
