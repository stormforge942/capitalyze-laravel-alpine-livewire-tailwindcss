<?php

namespace App\Http\Livewire\InvitedAuth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ConfirmEmail extends Component
{
    public $user;
    public $email;
    public $isVerified;
    public $isAdminApproved;
    public $isPasswordSet;

    public function resend()
    {
        $this->user->notify(new VerifyEmail);

        $this->emit('verificationEmailSent');
    }

    public function resetPassword()
    {
        Password::sendResetLink(['email' => $this->user->email]);

        $this->emit('passwordResetSent');
    }

    public function mount()
    {
        $userId = session()->get('user');

        if ($userId) {
            $user = User::findOrFail((int)$userId);

            $this->user = $user;
            $this->email = $this->maskEmail($this->user->email);
            $this->isVerified = $this->user->hasVerifiedEmail();
            $this->isAdminApproved = $this->user->is_approved;
            $this->isPasswordSet = $this->user->is_password_set;
        }
    }

    private function maskEmail(string $input) {
        $symbols = 3;
        $arr = explode('@', $input);

        return substr($arr[0],0, $symbols) . str_repeat('*',strlen($arr[0]) - $symbols) . $arr[1];
    }

    public function render()
    {
        return view('livewire.invited-auth.confirm-email');
    }
}
