<?php

namespace App\Http\Livewire\InvitedAuth;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class SetPassword extends Component
{
    public $user;
    public $token;
    public $isValidToken = false;

    public function mount(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->isValidToken = Password::tokenExists($user, $token);
    }

    public function render()
    {
        return view('livewire.invited-auth.set-password', [
            'user' => $this->user,
            'token' => $this->token,
            'isValidToken' => $this->isValidToken,
        ]);
    }
}
