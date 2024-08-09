<?php

namespace App\Http\Livewire\AccountSettings;

use Illuminate\Support\Facades\Auth;
use WireElements\Pro\Components\Modal\Modal;

class TwoFactorAuthentication extends Modal
{
    public $mode;

    public $password;

    public $email;

    public function mount($mode) /* mode: true => enable mode, false => disable mode */
    {
        $this->mode = $mode;

        if (! $this->mode && isPasswordConfirmed()) {
            $this->disableTwoFactorAuthentication();
        }
    }

    public function confirmPassword()
    {
        $rules = [
            'password' => 'required|min:8',
        ];

        $this->validate($rules);

        if (! confirmPassword(auth()->user(), $this->password)) {
            return $this->addError('password', __('The provided password does not match your current password.'));
        }

        if (! $this->mode) {
            $this->disableTwoFactorAuthentication();
        }
    }

    public function confirmEmail()
    {
        abort_if(! isPasswordConfirmed(), 403);

        $rules = [
            'email' => 'required',
        ];

        $this->validate($rules);

        $user = Auth::user();
        $user->two_factor_email = $this->email;
        $user->save();

        $this->emitTo(SecurityMine::class, '2fa-updated');
        $this->close();
    }

    protected function disableTwoFactorAuthentication()
    {
        $user = Auth::user();
        $user->two_factor_email = null;
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        $this->emitTo(SecurityMine::class, '2fa-updated');
        $this->close();
    }

    public function render()
    {
        return view('livewire.account-settings.two-factor-authentication');
    }
}
