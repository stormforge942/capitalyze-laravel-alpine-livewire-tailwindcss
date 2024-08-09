<?php

namespace App\Http\Livewire\AccountSettings;

use Illuminate\Support\Facades\Hash;
use WireElements\Pro\Components\Modal\Modal;

class PasswordReset extends Modal
{
    public $oldPassword;

    public $password;

    public $password_confirmation;

    public function confirmOldPassword()
    {
        $rules = [
            'oldPassword' => 'required',
        ];

        $this->validate($rules);

        if (! confirmPassword(auth()->user(), $this->oldPassword)) {
            return $this->addError('oldPassword', __('The provided password does not match your current password.'));
        }
    }

    public function updatePassword()
    {
        abort_if(! isPasswordConfirmed(), 403);

        $rules = [
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // At least one symbol
            ],
        ];

        $this->validate($rules);

        auth()->user()->update([
            'password' => Hash::make($this->password),
        ]);

        session()->forget('auth.password_confirmed_at');

        $this->reset(['oldPassword', 'password', 'password_confirmation']);

        $this->close();
    }

    public function render()
    {
        return view('livewire.account-settings.password-reset', [
            'state' => isPasswordConfirmed() ? 1 : 0,
        ]);
    }
}
